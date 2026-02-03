Quick Docker deployment (development)

1. Requirements
- Docker and Docker Compose installed.

2. Files created
- `docker-compose.yml` - app + mysql + phpmyadmin
- `.env.docker` - example environment for the containers

3. Start containers

```bash
# build and start
docker compose up --build -d
```

4. One-time setup inside the `app` container

```bash
# install PHP deps (if vendor empty)
docker compose exec app composer install --ignore-platform-req=ext-http --no-interaction

# generate app key
docker compose exec app php artisan key:generate

# run migrations (if needed)
docker compose exec app php artisan migrate --force

# set storage permissions (if needed)
docker compose exec app chown -R www-data:www-data storage bootstrap/cache

# install npm deps and build assets (optional)
docker compose exec app bash -lc "npm install && npm run dev"
```

5. Access
- App: http://localhost:8080
- phpMyAdmin: http://localhost:8081 (user: root, password: rootpassword)

Notes
- The `docker-compose.yml` mounts the project into the container for live dev. For production, build assets and avoid mounting the full source to the image.
- Fill `APP_KEY` in `.env.docker` or run `php artisan key:generate` as above.
