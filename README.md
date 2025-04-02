# Transaction Validation Service

### Tech stack backend:

- PHP 8.3
- Laravel 12
- MySQL 8.0
- Docker v2

### Run project - Development
```shell
    cp ./backend/.env.example ./backend/.env

    cp docker-compose.override.yml.example docker-compose.override.yml

    docker-compose up --build
    
    make fresh
```