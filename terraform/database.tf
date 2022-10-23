module "mysql-db" {
  source = "./gcloud-db-mysql"

  name       = "orgyourway"
  db_name    = "orgyourway"
  project_id = var.gcp_project
  region     = "us-central1"
  zone       = "us-central1-a"

  tier                  = "db-f1-micro"
  disk_type             = "PD_HDD"
  disk_size             = 3
  disk_autoresize_limit = 15

  database_version = "MYSQL_8_0"
  user_name        = "orgyourway"
}

