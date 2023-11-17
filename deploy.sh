#!/bin/bash

echo "Generate .env file..."
rm .env $2 > /dev/null
cp .env.example .env

if [ "$(id -u)" -eq 0 ]; then
    echo "PHP_USER_ID=33" >> .env
    echo "PHP_USER_GID=33" >> .env
else
    echo "PHP_USER_ID=$(id -u)" >> .env
    echo "PHP_USER_GID=$(id -g)" >> .env
fi

length=16
POSTGRES_PASSWORD=$(tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c "$length")
echo "POSTGRES_PASSWORD=$POSTGRES_PASSWORD" >> .env
length=32
COOKIE_VALIDATION_KEY=$(tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c "$length")
echo "COOKIE_VALIDATION_KEY=$COOKIE_VALIDATION_KEY" >> .env

echo "Start docker-compose services..."

if [ "$(id -u)" -eq 0 ]; then
  docker-compose -f ./docker/docker-compose.yml  build  --build-arg EXT_PHP_USER_ID=33 --build-arg EXT_PHP_USER_GID=33
else
  docker-compose -f ./docker/docker-compose.yml  build  --build-arg EXT_PHP_USER_ID=$(id -u) --build-arg EXT_PHP_USER_GID=$(id -g)
fi

docker-compose  -f  ./docker/docker-compose.yml up php-composer

docker-compose -f ./docker/docker-compose.yml up -d
#docker-compose exec php composer install

echo "Migrate database..."
docker-compose -f ./docker/docker-compose.yml  exec php yii migrate --interactive=0

echo "Done!"