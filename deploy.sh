#!/bin/bash

echo "Generate .env file..."
rm .env
cp .env.example .env
echo "WWW-USER=$(id -u)" >> .env
length=16
POSTGRES_PASSWORD=$(tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c "$length")
echo "POSTGRES_PASSWORD=$POSTGRES_PASSWORD" >> .env
length=32
COOKIE_VALIDATION_KEY=$(tr -dc 'a-zA-Z0-9' < /dev/urandom | head -c "$length")
echo "COOKIE_VALIDATION_KEY=$COOKIE_VALIDATION_KEY" >> .env

echo "Start docker-compose services..."
cd ./docker
docker-compose up -d
#docker-compose exec php composer install

echo "Migrate database..."
docker-compose exec php yii migrate --interactive=0

echo "Done!"