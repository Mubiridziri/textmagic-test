install:
	docker run --rm --interactive --tty \
      --volume ./app:/app \
      composer install
phpunit:
	docker run -it --rm \
	--volume ./app:/app php:8.2-cli \
	php app/vendor/bin/phpunit app/tests 
--configuration=app/phpunit.xml
