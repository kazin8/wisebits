## Создание инфраструктуры

    docker-compose up --build --force-recreate --no-deps

    docker exec -it wisebits_php_1 /bin/bash
    cd /usr/share/nginx/html/basic && php yii migrate

## Доступ к сайту
    http://localhost:8080/index.php?r=video

---

## Подключение к базе данных
    docker exec -it wisebits_postgres_1 /bin/bash
    psql -U wisebits -W wisebits # password

## Удаление контейнеров
    docker rm wisebits_nginx_1 wisebits_php_1 wisebits_postgres_1