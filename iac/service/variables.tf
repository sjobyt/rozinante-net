variable "namespace" {
  description = "Environment Name"
}

variable "stage" {
  description = "Stage prod, dev, qa etc"
}

variable "name" {
  description = "Instance Name"
}

variable "dns_zone" {
  description = "DNS Zone Name eq foobar.com"
}

variable "email" {
  description = "Email used for Cloudflare API acccess"
}

variable "cloudflare_secret" {
  description = "API Key used for Cloudflare API"
}

variable "github_token" {
  description = "API Key used for Github"
}

variable "github_owner" {
  description = "Github Owner"
}

variable "github_repo" {
  description = "Github Repo Name"
}

variable "aws_ecr_name" {
  description = "AWS ECR Repo Name from bootstrap layer"
}

variable "cloudflare_zone_id" {
  description = "Cloudflare DNS Zone ID"
}

variable "cidr_block" {
  description = "VPC CIDR Block eg 10.0.0.0/20"
}