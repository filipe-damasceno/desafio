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

Para comunicação com API do github estou utilizando Personal access tokens, antes de continuar gere um token pessoal na sua conta (permissões de repo) em:


https://github.com/settings/tokens

e adicione o token em:

desafio\orquestra_app\app\Helpers\functions_curl.php line 73

Ex:
```
"Authorization: token 0f1de63eacd8768367cb20c3a5ccee5c38345cd0", 
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


## Git Hub

Alterar Payload URL em:

https://github.com/filipe-damasceno/desafio/settings/hooks/139919415

Colocar url coletada no passo anterior com sufixo (/api/payload)

Ex:

```
https://2c39517a.ngrok.io/api/payload
```

## Executando

Nesse ponto se tem tres terminais abertos para monitorar a execução, basta criar uma PR para testar, o webhook esta configurado para notificar em qualquer evento de PR.

Alem dos tres terminais existe um log em 

desafio\orquestra_app\storage\logs\laravel.log

# Execução local para testes
## Caso queira executar com docker compose localmente individualmente  bash:

```
mvn clean package -Dmaven.test.skip=true -f desafio/apirest/pom.xml
```
```
mvn clean package -Dmaven.test.skip=true -f desafio/apirestteste/pom.xml
```
```
docker-compose -f desafio/docker-compose.yml build
```
```
docker pull postgres:10.4
```
```
docker-compose -f desafio/docker-compose.yml up
```

## Rotas

```
curl -X GET \
  http://localhost:8080/api/v1/vehicleId/999
``` 
```
curl -X GET \
  http://localhost:8080/api/v1/status 
``` 
```
curl -X POST \
  http://localhost:8080/api/v1/coordenada \
  -H 'Content-Type: application/json' \
  -d '{"lat": -3.734652, "long": -38.469755, "instant": "2018-08-08T23:48:15+00:00", "vehicleId": 12345}'
``` 

```
curl -X GET \
  http://localhost:9000/api/v1/status
``` 
```
curl -X POST \
  http://localhost:9000/api/v1/testApi \
  -d http://docker-app:8080/api/v1/
``` 

