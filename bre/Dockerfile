FROM gradle:4.10.3-jdk-alpine as builder
WORKDIR /home/gradle
COPY --chown=gradle:gradle . .
RUN gradle build --full-stacktrace
RUN ls -l build/distributions

FROM openjdk:8-jre-alpine as production
COPY --from=builder /home/gradle/build/distributions/bre.tar /app/
WORKDIR /app
RUN tar -xvf bre.tar
WORKDIR /app/bre
CMD ["bin/bre"]
EXPOSE 5000
#HEALTHCHECK --interval=10s --timeout=60s --retries=1 CMD curl -f http://localhost/healthcheck || exit 1
