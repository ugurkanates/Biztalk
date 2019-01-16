FROM gradle:4.10.3-jdk-alpine as builder
WORKDIR /home/gradle
COPY --chown=gradle:gradle . .
CMD gradle build --stacktrace

FROM openjdk:8-jre-alpine as production
EXPOSE 8080
COPY --from=builder /home/gradle/build/distributions/log.tar /app/
WORKDIR /app
RUN tar -xvf log.tar
WORKDIR /app/log
CMD bin/log
