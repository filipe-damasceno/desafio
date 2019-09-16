## spring-boot-docker-laravel

### Pré requisito
- Maven 3
- Java 8 (java version "1.8.0_131")
- Docker version 19.03.1, build 74b1e89
- PHP 7.3.9 (https://laravel.com/docs/5.5#server-requirements)

## Preparando ambiente (local) Bash:


```
git clone https://github.com/filipe-damasceno/desafio.git
``` 
```
cd desafio/orquestra_app/
```
```
composer install
```
```
touch database/database.sqlite
```
```
php artisan migrate
```
```
php artisan config:cache
```
```
php artisan serve
```

Aplicação dem execução em: http://localhost:8000



