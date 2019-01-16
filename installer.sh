#!/usr/bin/env bash
docker-compose -f graph.yml build
docker-compose -f graph.yml up -d --force-recreate
