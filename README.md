# Pet Shop

This repository contains APIs for the Pet Shop (eCommerce). The project uses docker compose to minimise the setup process. Each directory in the project signifies a single function and is mounted in the appropriate containers.

<details>
<summary>Directory Structure</summary>

### build/ directory
The build directory contains instructions for building a container. It provides us with a logical separation of build steps.

### config/ directory
The config directory contains configuration attached to containers. It helps us to persist the configuration even when the containers are rebooted.

### data/ directory
The data directory contains container related data. It helps us to persist the application specific data even when the containers are rebooted.

### repository/ directory
The repository directory will contain the Laravel application.

</details>

**Note:** Please note that this docker setup should only be used for development purposes and by no means should be deployed to production.

## System requirements

* Docker
* Docker Compose
* Port 80 should be available for Nginx
* Port 3306 should be available for MySQL

## Infrastructure

* Nginx
* PHP 8.2
* MySQL 8.1
* Laravel 10
