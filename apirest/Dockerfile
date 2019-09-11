FROM openjdk:8-jdk-alpine
LABEL maintainer="filipead@gmail.com"
VOLUME /tmp
COPY target/apirest-*.jar app.jar
ENTRYPOINT ["java", "-Djava.security.egd=file:/dev/./urandom", "-Dspring.profiles.active=docker", "-jar", "/app.jar"]