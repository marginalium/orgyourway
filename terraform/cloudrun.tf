

module "cloud_run" {
  source  = "GoogleCloudPlatform/cloud-run/google"
  version = "~> 0.2.0"

  service_name = "orgyourway"
  project_id   = var.gcp_project
  location     = "us-central1"

  image = "gcr.io/cloudrun/hello"

  timeout_seconds = 1000

  ports = {
    name = "http1"
    port = 80
  }

  template_annotations = {
    "autoscaling.knative.dev/maxScale"      = 10,
    "autoscaling.knative.dev/minScale"      = 1,
    "run.googleapis.com/cloudsql-instances" = module.mysql-db.instance_connection_name
    "run.googleapis.com/execution-environment" = "gen2"
  }

  env_vars = [
    {
      name  = "APP_NAME"
      value = var.app_name
    },
    {
      name  = "ORG_ENV"
      value = var.org_env
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
      value = module.mysql-db.instance_first_ip_address
    },
    {
      name  = "MYSQL_UNIX_SOCKET"
      value = "${module.mysql-db.instance_connection_name}"
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

  container_concurrency = 20

  members = [
    "allUsers",
  ]

  limits = {
    cpu    = "1000m"
    memory = "1G"
  }
}
