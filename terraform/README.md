## Requirements

No requirements.

## Providers

| Name | Version |
|------|---------|
| <a name="provider_google"></a> [google](#provider\_google) | 4.40.0 |

## Modules

| Name | Source | Version |
|------|--------|---------|
| <a name="module_mysql-db"></a> [mysql-db](#module\_mysql-db) | ./gcloud-db-mysql | n/a |

## Resources

| Name | Type |
|------|------|
| [google_project_service.gcp_services](https://registry.terraform.io/providers/hashicorp/google/latest/docs/resources/project_service) | resource |

## Inputs

| Name | Description | Type | Default | Required |
|------|-------------|------|---------|:--------:|
| <a name="input_gcp_project"></a> [gcp\_project](#input\_gcp\_project) | Google Cloud project id | `string` | n/a | yes |
| <a name="input_gcp_service_list"></a> [gcp\_service\_list](#input\_gcp\_service\_list) | List of service APIs to enable for this project | `list(string)` | <pre>[<br>  "sqladmin.googleapis.com"<br>]</pre> | no |

## Outputs

No outputs.
