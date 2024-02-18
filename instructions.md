Make sure you have PHP, NPM & Docker setup on your machine. 

## Getting Docker up & running
If not already done, install [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+) You can also use [Docker Desktop](https://www.docker.com/products/docker-desktop/)
2. Navigate to the project root & we'll set-up the docker containers. Make sure Docker is started.
3. Run `docker compose build --no-cache` to build fresh Docker images
4. Run `docker compose up -d --wait` to start FeedFusion
5. Open `http://localhost/` in your web browser
6. You can also use  `docker compose down --remove-orphans` to stop the Docker containers. Or you can use Docker UI.

## Symfony commands
As Symfony is running in Docker, use `docker compose exec php php bin/console` before Symfony console commands to execute them within the Docker container.

1. Run `composer install && npm install && npm run tailwind` to se-tup extensions & npm for styles.
2. Run `docker compose exec php php bin/console doctrine:migrations:migrate` to migrate the tables into docker PostgresQL DB
3. Run `docker compose exec php php bin/console app:seed-feeds` to seed some example RSS feeds.
