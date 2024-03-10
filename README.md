# Vacation Plan

This is an API for the Vacation Plan application.


```
Author: Roland Edward Santos
Email: dev.weward@gmail.com
Linkedin: https://www.linkedin.com/in/roland-edward-santos/
GitHub: https://github.com/weward 
```


--- 


# Table of Contents


## Installation

This app utlizes Laravel Sail (Docker). 

Clone the repository:

```bash 
    git clone git@github.com:weward/VacationPlan.git

```


Install dependencies 

```bash
composer install
# OR <===

#install dependencies without Sail yet (Docker instance):
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs

```

Generate Application Key 

```bash 

# Application's root directory
cd VacationPlan 

# Normal command
php artisan key:generate

# Sail command (if an alias was already set)
sail artisan key:generate
```


Update the `.env` file

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=vacationplan
DB_USERNAME=sail
DB_PASSWORD=password

```


.
> **NOTE:**
> Try adding an alias for sail commands. https://laravel.com/docs/10.x/sail#configuring-a-shell-alias




Start Laravel Sail (Docker)

```bash

# Detached 
sail up -d

``` 

Symlink Storage

```bash
sail artisan storage:link
```


## Tech Stack 

- Laravel 10
- Laravel Sanctum (Authentication)


# Stories

### Authentication

- User may login to the system by providing an email and password.
- User receives a secured token upon successful login.
- User receives an error response in string format upon failed login.

### Registration 
- Users may register to the system by providing their name, email and password
- User receives a response with HTTP status of 200 in string format upon successful registration.
- User receives a response with HTTP status of 500 in string format upon failed registration.
- User receives an error response in string format upon failed registration.

### Logout 
- Users may log out of the system by hitting the `/api/auth/logout` endpoint.


### Holiday Plan Creation