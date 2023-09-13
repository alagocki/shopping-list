SHELL := /bin/bash

startdev:
	symfony proxy:start
	symfony server:start -d
	docker-compose up -d
	open https://shoppinglist.wip
.PHONY: startdev

stopdev:
	symfony server:stop
	symfony proxy:stop
	docker-compose down
.PHONY: stopdev

