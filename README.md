
## 🚀 Getting Started

### 1. Clone the Project

```bash
git clone https://github.com/Dinnova-AG/readback-admin.git
cd readback-admin
git config core.hooksPath git-hooks
```

### 2. Set Up .env

```bash
cp .env.example .env
```

#### Update database/Redis configs in project .env:

```bash
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret

ACTIVITY_LOGGER_DB_CONNECTION=mongodb
MONGO_DB_HOST=mongo
MONGO_DB_PORT=27017
MONGO_DB_DATABASE=activity_log_db
MONGO_DB_USERNAME=laravel
MONGO_DB_PASSWORD=secret

REDIS_HOST=redis

PGADMIN_EMAIL=admin@admin.com   
PGADMIN_PASSWORD=password

MONGO_EXPRESS_USER=admin
MONGO_EXPRESS_PASSWORD=password
```

### 🛠 Docker Commands

### 3. Build Containers

```bash
docker compose build
```

### 4. Install PHP Dependencies

```bash
docker compose run --rm php composer install
```

### 5. Install Node.js Dependencies

```bash
docker compose run --rm node npm install
```

### 6. Generate App Key

```bash
docker compose run --rm php php artisan key:generate
```

## ▶️ Start the App

```bash
docker compose up -d
```

### 7. Run Migrations (Optional)

```bash
docker compose run --rm php php artisan migrate
```

#### Open:
- Laravel App: http://localhost:8000

- Api doc: http://localhost:8000/docs

- Vite Dev Server: http://localhost:5173

- mailpit: http://localhost:8020

- pgAdmin: http://localhost:5050

    - Email: admin@admin.com

    - Password: password

- mongo express: http://localhost:8081

    - User: admin

    - Password: password

## 🐚 Common Commands

| Task | Command |
|------|---------|
| Access PHP container | `docker exec -it readback_php bash` |
| Run Artisan | `docker compose run --rm php php artisan` |
| Run Migrations | `docker compose run --rm php php artisan migrate` |
| npm run dev | `docker compose run --rm node npm run dev` |
| npm run build | `docker compose run --rm node npm run build` |
| Stop containers | `docker compose down` |
| Stop & remove volumes | `docker compose down -v` |
| Monitor Logs | `docker logs -f readback_horizon` |
