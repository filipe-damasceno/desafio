## spring-boot-docker-laravel

### Pré requisito
- Apache Maven 3.0.5
- Java 8 (java version "1.8.0_131")
- Docker version 19.03.1, build 74b1e89
- PHP 7.3.9 (https://laravel.com/docs/5.5#server-requirements)
- ngrok https://ngrok.com/
- Composer version 1.9.0

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

Aplicação em execução em: http://localhost:8000

Em um outro terminal tambem no caminho (desafio\orquestra_app) execute:

```
php artisan queue:work
```
Queue de processamento dos JOBs


## Tunelamento (exposição do servidor local a internet) bash:

No local onde foi extraido o ngrok execute: 
```
./ngrok authtoken 1QmY50YdSJ2mD6BQTZL4kqp3rZy_bjZmKa5PZ7kcG92xpPqk
```
```
./ngrok http 8000
```
Obs: token associado a minha conta 1QmY50YdSJ2mD6BQTZL4kqp3rZy_bjZmKa5PZ7kcG92xpPqk pode usar esse ou gerar outro

Ngrok em execução em: http://localhost:4040
Status do serviço (coletar url em command_line): http://localhost:4040/status 


##Git Hub
Alterar Payload URL em:
https://github.com/filipe-damasceno/desafio/settings/hooks/139919415

Colocar url coletada no passo anterior com sufixo (/api/payload)

Ex:

```
https://2c39517a.ngrok.io/api/payload
```

