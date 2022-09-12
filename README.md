# orgyourway
A toolset of simple site functions that empower the creation of small community organization sites.

## Docker Setup

To build the docker environment, do the following.

1. Copy the .env.dist in the root directory to a .env in the same directory.
2. Update the .env with your local environment secrets.
3. Run `docker-compose up --build -d`
4. Upon completion, run `docker cp orgyourway-nginx:/var/www/html/vendor ./app/` to pull down latest Composer files

TODO:
- Need to add --add-host host.docker.internal:host-gateway argument to the docker build in the CI pipeline
- Complete logic to parse user and event CSV files from EventBrite
- Complete Sonata admin setup