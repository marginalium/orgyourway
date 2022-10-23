terraform {
  backend "gcs" {
    prefix = "orgyourway"
  }
}

provider "google" {
  project = var.gcp_project
  region  = "us-central1"
  zone    = "us-central1a"
}

variable "gcp_service_list" {
  description = "List of service APIs to enable for this project"
  type        = list(string)
  default = [
    "cloudbuild.googleapis.com",
    "cloudresourcemanager.googleapis.com",
    "iam.googleapis.com",
    "sqladmin.googleapis.com",
  ]
}

resource "google_project_service" "gcp_services" {
  for_each = toset(var.gcp_service_list)
  project  = var.gcp_project
  service  = each.key
}

