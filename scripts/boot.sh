#!/usr/bin/env bash

# todo: move to gists that can be pulled

# exit when any command fails
set -e

COMPOSER_FLAGS=${1:-""}

BRANCH=$(git rev-parse --abbrev-ref HEAD)

PHP_VERSION=$(php --version)
PHP_VERSION=${PHP_VERSION:4:3}

TAG="$PHP_VERSION-$BRANCH"
export TAG

docker-compose down -v --remove-orphans

echo "Building image: stephenneal/redis-helpers:${TAG}"
docker build -t stephenneal/redis-helpers:"${TAG}" \
    --build-arg php_composer_tag="${PHP_VERSION}" \
    --build-arg composer_flags="${COMPOSER_FLAGS}" \
     .

docker-compose up -d

docker logs -f package

while true; do
    if [[ $(docker inspect -f '{{.State.Running}}' package) != true ]]; then
        break
    else
        echo "'package' container is still running... waiting 3 secs then checking again..."
        sleep 3
    fi
done

# Confirm it exited with code 0
docker inspect -f '{{.State.ExitCode}}' package > /dev/null 2>&1

# Confirm the image exists
docker image inspect stephenneal/redis-helpers:"${TAG}" > /dev/null 2>&1
