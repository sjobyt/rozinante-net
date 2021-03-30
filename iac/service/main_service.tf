
# IaC Terraform Service Layer
terraform {
  required_providers {
    cloudflare = {
      source  = "cloudflare/cloudflare"
      version = "~> 2.0"
    }
    aws = {
      source  = "hashicorp/aws"
      version = "~> 3.0"
    }
    github = {
      source  = "integrations/github"
      version = "4.6.0"
    }
  }
  backend "s3" {
    bucket  = "roz-prod-tfbackend"
    key     = "roz-prod-tfbackend/service"
    encrypt = true
    region  = "eu-north-1"
  }
}

# Cloudflare Provider config
provider "cloudflare" {
  email   = var.email
  api_key = var.cloudflare_secret
}

# AWS Provider Config
provider "aws" {
  region = "eu-north-1"
}

# Configure the GitHub Provider
provider "github" {
  token = var.github_token
  owner = var.github_owner
}


# DataSourcs
data "cloudflare_ip_ranges" "cloudflare" {}

data "aws_availability_zones" "available" {
  state = "available"
}

data "aws_region" "current" {}


# Label
module "label" {
  source    = "git::https://github.com/cloudposse/terraform-null-label.git?ref=tags/0.24.1"
  namespace = var.namespace
  name      = var.name
  stage     = var.stage
}


# VPC
module "vpc" {
  source                           = "git::https://github.com/cloudposse/terraform-aws-vpc.git?ref=tags/0.21.1"
  namespace                        = var.namespace
  stage                            = var.stage
  name                             = var.name
  cidr_block                       = var.cidr_block
  assign_generated_ipv6_cidr_block = false
}


locals {
  public_cidr_block  = cidrsubnet(module.vpc.vpc_cidr_block, 1, 0)
  private_cidr_block = cidrsubnet(module.vpc.vpc_cidr_block, 1, 1)
}

module "public_subnets" {
  source              = "git::https://github.com/cloudposse/terraform-aws-multi-az-subnets?ref=tags/0.11.0"
  namespace           = var.namespace
  stage               = var.stage
  name                = var.name
  availability_zones  = [data.aws_availability_zones.available.names[2], data.aws_availability_zones.available.names[1]]
  vpc_id              = module.vpc.vpc_id
  cidr_block          = local.public_cidr_block
  max_subnets         = 2
  type                = "public"
  igw_id              = module.vpc.igw_id
  nat_gateway_enabled = "true"
}

module "private_subnets" {
  source             = "git::https://github.com/cloudposse/terraform-aws-multi-az-subnets?ref=tags/0.11.0"
  namespace          = var.namespace
  stage              = var.stage
  name               = var.name
  availability_zones = [data.aws_availability_zones.available.names[2], data.aws_availability_zones.available.names[1]]
  vpc_id             = module.vpc.vpc_id
  cidr_block         = local.private_cidr_block
  max_subnets        = 2
  type               = "private"
  az_ngw_ids         = module.public_subnets.az_ngw_ids
}

# Lists of subnet ids
locals {
  private_subnet_ids = [module.private_subnets.az_subnet_ids[data.aws_availability_zones.available.names[2]], module.private_subnets.az_subnet_ids[data.aws_availability_zones.available.names[1]]]
  public_subnet_ids  = [module.public_subnets.az_subnet_ids[data.aws_availability_zones.available.names[2]], module.public_subnets.az_subnet_ids[data.aws_availability_zones.available.names[1]]]
}

# ECS Cluster
resource "aws_ecs_cluster" "default" {
  name               = module.label.id
  tags               = module.label.tags
  capacity_providers = ["FARGATE_SPOT"]
  default_capacity_provider_strategy {
    capacity_provider = "FARGATE_SPOT"
    base              = 1
  }
}

## ALB Security Group
resource "aws_security_group" "allow_http_from_cloudflare" {
  name        = "${module.label.id}-allow-http-cloudflare"
  description = "Allow http inbound traffic"
  vpc_id      = module.vpc.vpc_id

  ingress {
    description = "http from Cloudflare Network"
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = data.cloudflare_ip_ranges.cloudflare.ipv4_cidr_blocks
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
  tags = module.label.tags
}

#ALB ACM Cert
resource "aws_acm_certificate" "_" {
  domain_name               = var.dns_zone
  subject_alternative_names = ["www.${var.dns_zone}"]
  validation_method         = "DNS"
}

# ALB ACM Cert Cloudflare Validation
resource "cloudflare_record" "_" {
  zone_id = var.cloudflare_zone_id
  for_each = {
    for dvo in aws_acm_certificate._.domain_validation_options : dvo.domain_name => {
      name    = dvo.resource_record_name
      record  = dvo.resource_record_value
      type    = dvo.resource_record_type
      zone_id = dvo.domain_name == var.dns_zone ? var.cloudflare_zone_id : var.cloudflare_zone_id
    }
  }
  name = each.value.name
  # cloudflare removes . at end of value need to trim it for it not to be required to replaced on every build.
  value   = trimsuffix(each.value.record, ".")
  ttl     = 60
  type    = each.value.type
  proxied = false
}

# AWS ALB http redirect, https enabled and ACM certificate
module "alb" {
  source                             = "git::https://github.com/cloudposse/terraform-aws-alb?ref=tags/0.29.6"
  namespace                          = var.namespace
  stage                              = var.stage
  name                               = var.name
  vpc_id                             = module.vpc.vpc_id
  security_group_enabled             = false
  security_group_ids                 = [aws_security_group.allow_http_from_cloudflare.id]
  subnet_ids                         = local.public_subnet_ids
  access_logs_enabled                = true
  https_enabled                      = true
  target_group_protocol              = "HTTPS"
  certificate_arn                    = aws_acm_certificate._.arn
  lifecycle_rule_enabled             = true
  noncurrent_version_expiration_days = 90
  noncurrent_version_transition_days = 30
  tags                               = module.label.tags
}

# ECS config
module "container_definition" {
  source                       = "git::https://github.com/cloudposse/terraform-aws-ecs-container-definition.git?ref=tags/0.56.0"
  container_name               = var.name
  container_image              = "${var.aws_ecr_name}:latest"
  container_memory             = 512
  container_memory_reservation = 128
  container_cpu                = 1
  readonly_root_filesystem     = false
  port_mappings = [{
    containerPort = 443
    hostPort      = 443
    protocol      = "tcp"
  }]
}

module "ecs_alb_service_task" {
  source    = "git::https://github.com/cloudposse/terraform-aws-ecs-alb-service-task?ref=tags/0.54.2"
  namespace = var.namespace
  stage     = var.stage
  name      = var.name
  container_definition_json = jsonencode([
    module.container_definition.json_map_object,
  ])
  ecs_load_balancers = [{
    container_name   = var.name
    container_port   = 443
    elb_name         = ""
    target_group_arn = module.alb.default_target_group_arn


  }]
  ecs_cluster_arn                    = aws_ecs_cluster.default.arn
  launch_type                        = "FARGATE"
  vpc_id                             = module.vpc.vpc_id
  alb_security_group                 = aws_security_group.allow_http_from_cloudflare.id
  container_port                     = 443
  use_alb_security_group             = true
  subnet_ids                         = local.private_subnet_ids
  assign_public_ip                   = false
  deployment_minimum_healthy_percent = 100
  deployment_maximum_percent         = 200
  deployment_controller_type         = "ECS"
  desired_count                      = 1
  task_memory                        = 512
  # task_cpu https://docs.aws.amazon.com/AmazonECS/latest/developerguide/task_definition_parameters.html#task_size
  task_cpu = 256
  tags     = module.label.tags
}

# Cloudflare Recrods for www and domain
resource "cloudflare_record" "www" {
  zone_id = var.cloudflare_zone_id
  name    = "www"
  value   = module.alb.alb_dns_name
  type    = "CNAME"
  ttl     = 1
  proxied = true
}

resource "cloudflare_record" "_dnszone" {
  zone_id = var.cloudflare_zone_id
  name    = "@"
  value   = module.alb.alb_dns_name
  type    = "CNAME"
  ttl     = 1
  proxied = true
}