module "sql-db" {
  source  = "GoogleCloudPlatform/sql-db/google/modules/mysql"
  version = "8.0.0"

  name       = "orgyourway"
  db_name    = "orgyourway"
  project_id = var.gcp_project
  region     = "us-central1"

  tier                  = "db-f1-micro"
  disk_type             = "PD_HDD"
  disk_size             = 10
  disk_autoresize_limit = 30

  user_name = "orgyourway"
}

