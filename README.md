# Symfony Docker
> Пример использования Symfony v.6.2 (PHP 8.2) с Docker-Compose.

## Как работать с этим проектом?

Для работы с этим проектом вам не потребуется ставить что-то дополнительное, кроме как Docker & Docker-Compose на свою локальную машину!
> Если ваш компьютер или ОС не поддерживает Docker, вы всегда сможете развернуть все вручную. Но вам придется обзавестись файлом .env.local.

### Соберите и запустите контейнер с уже готовым рабочим окружением:

```
$ docker-compose up --build -d
```

### Зайдите в свое рабочение окружение:

```
$ docker-compose exec php /bin/bash
```


### Дополнительная информация
 - Для того, чтобы сменить версию PHP нужно всего лишь отредактировать файл php/Dockerfile
 - Внутри контейнера инсталлированы Symfony CLI, NPM/NODEJS, COMPOSER и PHP
 - Впервые запустив контейнер, вам нужно в него зайти и создать проект с помощью Symfony CLI


### TODO
 - Поддержка XDebug via PHPStorm
 - Доработать права на файлы