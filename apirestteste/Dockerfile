FROM openjdk:8-jdk-alpine
LABEL maintainer="filipead@gmail.com"
VOLUME /tmp
COPY target/apirestteste-*.jar apptest.jar
ENTRYPOINT ["java", "-Djava.security.egd=file:/dev/./urandom",  "-jar", "/apptest.jar"]