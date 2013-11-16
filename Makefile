 
.PHONY: dbviz test package

dbviz:
	php bin/composer.phar update

test:
	php vendor/bin/phpunit

package:
	php vendor/bin/box build

