APP=${EXEC} php bin/console

.ONESHELL:
.PHONY: install clean

install:
	composer install
	make clean
	make perms

clean:
	@${APP} cache:clear
	@${APP} cache:warmup
