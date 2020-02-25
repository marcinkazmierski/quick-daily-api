#!/bin/sh
docker-compose up -d
docker-compose exec api sh -c "composer install && chmod 777 -R var/* && php bin/console doctrine:schema:update --force"
xdg-open http://localhost:8106/
docker-compose exec api bash
