RED=$$(tty -s && tput setaf 1)
GREEN=$$(tty -s && tput setaf 2)
BLUE=$$(tty -s && tput setaf 4)
CLEAR=$$(tty -s && tput sgr 0)

.PHONY: tests
help:
	@echo ""
	@echo "${BLUE}Trainstation${CLEAR}"
	@echo ""
	@echo "${BLUE}Usage:${CLEAR}"
	@echo "  ${GREEN}command${CLEAR}"
	@echo ""
	@echo "${BLUE}Day-to-day tasks:${CLEAR}"
	@echo "  ${GREEN}build${CLEAR} - builds the application"
	@echo "  ${GREEN}up${CLEAR}    - start the application"
	@echo "  ${GREEN}down${CLEAR}  - stop the application"
	@echo "  ${GREEN}tests${CLEAR} - run tests"
	@echo ""

build: composer-install
	@echo "${BLUE}Building docker images.${CLEAR}"
	@docker-compose build

dev: build up tests

ensure-network:
	@echo "${BLUE}Ensure traefik_proxy network exists.${CLEAR}"
	@docker network create traefik_proxy || true

up: ensure-network
	@echo "${BLUE}Starting docker containers.${CLEAR}"
	@docker-compose up -d
	@docker-compose ps
	@echo ""
	@echo "${GREEN}Url:${CLEAR}  http://trainstation.docker.localhost/"
	@echo ""

down:
	@echo "${BLUE}Stopping docker containers.${CLEAR}"
	@docker-compose down

tests:
	@echo "${BLUE}Running phpspec examples...${CLEAR}"
	@(docker run --rm -v `pwd`:/app -w /app -u $$(id -u):$$(id -g) trainstation_api bin/phpspec run -fprogress) || \
		(echo "${RED} Phpspec examples failed.${CLEAR}" && exit 1)
	@echo "${GREEN}Phpspec examples passed.${CLEAR}"
	@echo "${BLUE}Running behat scenarios...${CLEAR}"
	@(docker run --rm -it -v `pwd`:/app -w /app -u $$(id -u):$$(id -g) trainstation_api bin/behat -fprogress) || \
  		(echo "${RED} Behat scenarios failed.${CLEAR}" && exit 1)
	@echo "${GREEN}Behat scenarios passed.${CLEAR}"
	@echo "${BLUE}Running phpunit tests...${CLEAR}"
	@(docker run --rm -it -v `pwd`:/app -w /app -u $$(id -u):$$(id -g) trainstation_api bin/phpunit) || \
  		(echo "${RED} Phpunit tests passed.${CLEAR}" && exit 1)
	@echo "${GREEN}Phpunit tests failed.${CLEAR}"

verify: build tests

composer-install:
	@echo "${BLUE}Installing backend dependencies.${CLEAR}"
	@docker run --rm -it -v ${HOME}/.cache/composer:/tmp/cache -v ${PWD}:/app -u $$(id -u):$$(id -g) composer install -n -o

db:
	@docker exec -it `docker-compose ps | grep 3306/tcp | cut -f 1 -d " "` mysql -uroot -p trainstation
