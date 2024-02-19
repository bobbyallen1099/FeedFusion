# FeedFusion
## Made with ❤️ by Bobby Allen.
### Powered by Symfony & Docker.

## Getting Docker up & running
If not already done, install [Docker Compose](https://docs.docker.com/compose/install/) (v2.10+) You can also use [Docker Desktop](https://www.docker.com/products/docker-desktop/) 

Navigate to the project root & we'll set-up the docker containers. Make sure Docker is started.

1. Run `docker compose build --no-cache` to build fresh Docker images
2. Run `docker compose up -d --wait` to start FeedFusion
3. Open `http://localhost/` in your web browser
4. You can also use  `docker compose down --remove-orphans` to stop the Docker containers. Or you can use Docker UI.

## Symfony commands
As Symfony is running in Docker, use `docker compose exec php php bin/console` before Symfony console commands to execute them within the Docker container.

1. Run `composer install && npm install && npm run tailwind` to se-tup extensions & npm for styles.
2. Run `docker compose exec php php bin/console doctrine:migrations:migrate` to migrate the tables into docker PostgresQL DB
3. Run `docker compose exec php php bin/console app:seed-feeds` to seed some example RSS feeds.

# Showcase!
![image](https://github.com/bobbyallen1099/FeedFusion/assets/38939673/6f588f49-8708-4a31-9666-bba345a8b908)
![image](https://github.com/bobbyallen1099/FeedFusion/assets/38939673/fb2f5062-d43b-45bf-9f86-62716048af9a)
![image](https://github.com/bobbyallen1099/FeedFusion/assets/38939673/5745cd90-7ff5-4ded-a650-a2b63d74a586)
![image](https://github.com/bobbyallen1099/FeedFusion/assets/38939673/f61f7a28-8bf9-40b3-aa87-e1055a38c3b0)
![image](https://github.com/bobbyallen1099/FeedFusion/assets/38939673/02bf2dcd-94b9-4721-95c0-8dcecf6a99b8)
![image](https://github.com/bobbyallen1099/FeedFusion/assets/38939673/6fe28fcc-c8a9-4fc3-94ef-23a07ea6ae27)
