#!/bin/env sh

# now its support taking the path and root password from env
# so it can be changed on the fly without changing `private/config.php`

cd ./web/
ROOT_PASSWORD="1" \
    DB_PATH="/home/fernando/git/tg-perpus-php/private/db.sqlite"\
    php -S localhost:8081
