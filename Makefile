
ID := $(shell id -u) 
default:
	@if [ $(ID) -ne 0 ]; then \
		echo You must be root; \
	else \
		docker build -t pokal_db ./pokal_db; \
		docker build -t pokal_php ./pokal_php; \
	fi
