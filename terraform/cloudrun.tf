module "cloud_run" {
  source  = "GoogleCloudPlatform/cloud-run/google"
  version = "~> 0.2.0"

  service_name = "OrgYourWay"
  project_id   = var.gcp_project
  location     = "us-central1"

  image = "gcr.io/cloudrun/hello"

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
      value = module.mysql-db.instance_ip_address
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
}
