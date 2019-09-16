## spring-boot-docker 

### Pré requisito
- Apache Maven 3.0.5
- Java 8 (java version "1.8.0_131")
- Docker version 19.03.1, build 74b1e89

Caso queira rodar individualmente 

```
mvn clean package -Dmaven.test.skip=true 
``` 
```
docker build -t apptest .
``` 
```
docker run -it -p 9000:9000 apptest
``` 

## Rotas

```
curl -X GET \
  http://localhost:9000/api/v1/status
``` 
```
curl -X POST \
  http://localhost:9000/api/v1/testApi \
  -d http://docker-app:8080/api/v1/
``` 



