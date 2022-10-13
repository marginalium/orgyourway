1. Create Google Cloud project
1. Create deploy service account
  1. Granted `Editor` privileges
  1. Export JSON key for GitHub
  1. Add JSON key to GitHub
1. Create Terraform state bucket
  1. Permit use to deploy sa created above
1. Enable necessary APIs
  1. Cloud Resource Manager
  1. Identity and Access Management (IAM)
1. Populate GitHub Actions secrets with environment values
  1. GCLOUD_PROJECT
  1. GCLOUD_DEPLOY_KEY
  1. TF_BUCKET

