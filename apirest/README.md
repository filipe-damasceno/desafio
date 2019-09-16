## spring-boot-docker 

### Pré requisito
- Apache Maven 3.0.5
- Java 8 (java version "1.8.0_131")
- Docker version 19.03.1, build 74b1e89

Caso queira rodar individualmente 

```
docker run -d --name docker-postgres -e POSTGRES_DB=apirest -e POSTGRES_USER=postgres -e POSTGRES_PASSWORD=admin postgres:10.4
``` 
```
mvn clean package -Dmaven.test.skip=true 
``` 
```
docker build -t app .
``` 
```
docker run -it  --link docker-postgres   -p 8080:8080 app
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


