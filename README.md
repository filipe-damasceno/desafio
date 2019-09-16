## spring-boot-docker-laravel

### Pré requisito
- Maven 3
- Java 8 (java version "1.8.0_131")
- Docker version 19.03.1, build 74b1e89
- PHP 7.3.9 (https://laravel.com/docs/5.5#server-requirements)

## Preparando ambiente (local) Bash:

#1
```
git clone https://github.com/filipe-damasceno/desafio.git
```
#2
```
cd desafio/orquestra_app/
```
#3
```
composer install
```
#4
```
touch database/database.sqlite
```
#5
```
php artisan migrate
```
#6
```
php artisan config:cache
```
#7
```
php artisan serve
```

Aplicação dem execução em: http://localhost:8000



