# IaC Code

- ./bootstrap is intial config and does only need to be run for clean install
- Docker CI need to be ran after inital bootstrap to generate Docker image in AWS ECR for service to exist
- ./service is CI/CD and used for modifying infrastructure
