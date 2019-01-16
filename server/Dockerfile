FROM gradle:4.10.3-jdk-alpine as builder
WORKDIR /home/gradle
COPY --chown=gradle:gradle . .
RUN gradle build --full-stacktrace
RUN ls -l build/distributions

FROM openjdk:8-jre-alpine as production
COPY --from=builder /home/gradle/build/distributions/server.tar /app/
WORKDIR /app
RUN tar -xvf server.tar
WORKDIR /app/server
CMD bin/server
EXPOSE 9001
