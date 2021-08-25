#!/usr/bin/env bash

COMPOSER_FLAGS=${1:-""}

BRANCH=$(git rev-parse --abbrev-ref HEAD)

PHP_VERSION=$(php --version)
PHP_VERSION=${PHP_VERSION:4:3}

TAG="$PHP_VERSION-$BRANCH"
export TAG

echo "Building image: stephenneal/redis-helpers:${TAG}"
docker build -t stephenneal/redis-helpers:"${TAG}" \
    --build-arg php_composer_tag="${PHP_VERSION}" \
    --build-arg composer_flags="${COMPOSER_FLAGS}" \
     .

docker compose up -d

docker logs -f package

sleep 20
docker-compose down -v --remove-orphans

docker image inspect stephenneal/redis-helpers:"${TAG}" > /dev/null 2>&1
