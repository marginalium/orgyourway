variable "gcp_project" {
  type        = string
  description = "Google Cloud project id"
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

