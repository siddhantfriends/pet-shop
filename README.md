# Pet Shop

<p align="center">
  <a href="https://github.com/siddhantfriends/pet-shop/actions"><img src="https://github.com/siddhantfriends/pet-shop/workflows/Laravel%20Tests/badge.svg" alt="Laravel Tests Status"></a>
  <a href="https://github.com/siddhantfriends/pet-shop/actions"><img src="https://github.com/siddhantfriends/pet-shop/workflows/Static%20Code%20Coverage/badge.svg" alt="Larastan Static Code Coverage Status"></a>
  <a href="https://github.com/siddhantfriends/pet-shop/actions"><img src="https://github.com/siddhantfriends/pet-shop/workflows/PHP%20Insights%20Code%20Quality/badge.svg" alt="PHP Insights Code Quality"></a>
</p>

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

## Continuous Integration

* Laravel Tests
* Larastan Static Code Analysis

# Setup Guide

### 1. Clone the repository to your local folder

### 2. Run with docker-compose

Execute the below command:

```bash
docker-compose exec up -d
```
### 3. Connect to the container for further setup

```bash
docker-compose exec php8 bash
```
### 4. Copy .env.example to .env

```bash
cp .env.example .env
```

### 5. Run Composer Install

```bash
composer install
```

### 6. Generate Application Keys

```bash
php artisan key:generate
```

Keys for JWT can be generated using:

```bash
php artisan jwt:keys
```
### 7. Run Migrations

```bash
php artisan migrate
```
### 8. Choose your localhost or virtual host configuration.

Localhost: [http://localhost](http://localhost)

Virtual Host: [http://api.pet-shop.test](http://api.pet-shop.test)

Note: Please make sure the host file has the correct entry.

-------
Thank you!
