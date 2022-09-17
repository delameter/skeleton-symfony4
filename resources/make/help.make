.ONESHELL:
.PHONY: help

H1=@echo === ${1} ===
BR=@echo
TAB=@echo "\t"

help:
	$(call H1,App)
	$(TAB) make install - установка/обновление сервиса
	$(TAB) make clean - снос и прогрев кэша доктрины
	$(call H1,Files)
	$(TAB) make perms - выставляет нужные разрешения на каталог var
