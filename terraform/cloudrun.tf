module "cloud_run" {
  source  = "GoogleCloudPlatform/cloud-run/google"
  version = "~> 0.2.0"

  service_name = "orgyourway"
  project_id   = var.gcp_project
  location     = "us-central1"

  image = "gcr.io/cloudrun/hello"

  ports = {
    name = "http1"
    port = 80
  }

  env_vars = [
    {
      name  = "APP_NAME"
      value = var.app_name
    },
    {
      name  = "ADMIN_USERNAME"
      value = var.admin_user
    },
    {
      name  = "ADMIN_PASSWORD"
      value = var.admin_password
    },
    {
      name  = "MYSQL_HOST"
      value = "localhost"
    },
    {
      name  = "MYSQL_UNIX_SOCKET"
      value = "/cloudsql/${var.gcp_project}:us-central1:${module.mysql-db.instance_name}"
    },
    {
      name  = "MYSQL_DATABASE"
      value = "orgyourway"
    },
    {
      name  = "MYSQL_USER"
      value = "orgyourway"
    },
    {
      name  = "MYSQL_PASSWORD"
      value = module.mysql-db.generated_user_password
    }
  ]

  container_concurrency = 80

  members = [
    "allUsers",
  ]

  limits = {
    cpu    = "1000m"
    memory = "512M"
  }
}
