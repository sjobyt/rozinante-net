
# IaC Terraform Bootstrap
## Manually Add to Github Secrets in Github to avoid them getting into Terraform State
# AWS_ACCCESS_KEY_ID
# AWS_SECRET_ACCESS_KEY
# TF_VAR_CLOUDFLARE_SECRET
# TF_VAR_EMAIL (Cloudflare Login ID)
# TF_VAR_GITHUB_OWNER
# TF_VAR_GITHUB_TOKEN 
# TF_VAR_DOCKER_SSL_SECRET
# Once that is done Run this manully to create depdencies in Github for CI/CD Service. 

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
    key     = "roz-prod-tfbackend/backend"
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

# TF Backend S3 Bucket
module "s3_bucket" {
  source                       = "git::https://github.com/cloudposse/terraform-aws-s3-bucket?ref=0.32.0"
  acl                          = "private"
  allow_encrypted_uploads_only = true
  block_public_acls            = true
  block_public_policy          = true
  enabled                      = true
  user_enabled                 = false
  versioning_enabled           = true
  lifecycle_rule_enabled       = false
  sse_algorithm                = "AES256"
  name                         = "tfbackend"
  stage                        = var.stage
  namespace                    = var.namespace
}

# DataSourcs
data "aws_availability_zones" "available" {
  state = "available"
}

data "aws_region" "current" {}

# Cloudflare Config
resource "cloudflare_zone" "zone1" {
  zone = var.dns_zone
}

resource "cloudflare_zone_settings_override" "zone1" {
  zone_id = cloudflare_zone.zone1.id
  settings {
    brotli = "on"
    automatic_https_rewrites = "on"
    always_use_https         = "on"
    ssl = "full"
  }
}

# AWS
# AWS ECR
module "ecr" {
  source    = "git::https://github.com/cloudposse/terraform-aws-ecr?ref=0.32.2"
  namespace = var.namespace
  stage     = var.stage
  name      = var.name
}


# Add ECR Name to Github for use by Github Action Docker build to AWS ECR
resource "github_actions_secret" "ecrname" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_AWS_ECR_NAME"
  plaintext_value  = module.ecr.repository_name
}

# Add Cloudflare Zone ID To Github
resource "github_actions_secret" "cloudflare_zone_id" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_CLOUDFLARE_ZONE_ID"
  plaintext_value  = cloudflare_zone.zone1.id
}

# Add AWS Current Regtion to Github Secrets from use in Github Action Docker build to AWS ECR
resource "github_actions_secret" "awsregion" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_AWS_REGION"
  plaintext_value  = data.aws_region.current.name
}

# Add dns zone info to Github Secrets
resource "github_actions_secret" "dns_zone" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_DNS_ZONE"
  plaintext_value  = var.dns_zone
}

# Add dns zone info to Github Secrets
resource "github_actions_secret" "namespace" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_NAMESPACE"
  plaintext_value  = var.namespace
}

# Add Stage info to Github Secrets
resource "github_actions_secret" "stage" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_STAGE"
  plaintext_value  = var.stage
}

# Add Resource name info to Github Secrets
resource "github_actions_secret" "name" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_NAME"
  plaintext_value  = var.name
}

# Add VPC CIDR Block Used by VPC and Subnets info to Github Secrets
resource "github_actions_secret" "cidr_block" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_CIDR_BLOCK"
  plaintext_value  = var.cidr_block
}

# Name of Gitub Repo to Github Secrets
resource "github_actions_secret" "github_repo" {
  repository       = var.github_repo
  secret_name      = "TF_VAR_GITHUB_REPO"
  plaintext_value  = var.github_repo
}