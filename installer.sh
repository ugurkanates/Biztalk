#!/usr/bin/env bash
docker-compose -f config.yml build
docker-compose -f config.yml up -d --force-recreate
