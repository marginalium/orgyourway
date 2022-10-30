variable "gcp_project" {
  type        = string
  description = "Google Cloud project id"
}

variable "org_env" {
  type        = string
  description = "Application environment"
  default     = "prod"
}

variable "app_name" {
  type        = string
  description = "Application name to display"
  default     = "Orgyourway"
}

variable "admin_user" {
  type        = string
  description = "Admin username"
}

variable "admin_password" {
  type        = string
  description = "Admin password"
}

variable "max_children" {
  type        = string
  description = "Maximum PHP Child Processes"
  default     = 80
}

variable "domain" {
  type        = string
  description = "Custom domain mapping"
  default     = "example.com"
}

