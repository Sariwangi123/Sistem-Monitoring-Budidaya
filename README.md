# UtiFarm

UtiFarm adalah foundation aplikasi manajemen budidaya perikanan sesuai `00_Project_Master.md` dan `01_Milestone_Foundation.md`.

## Stack

- Backend: Laravel 12, PHP 8.4, PostgreSQL, Redis, Sanctum
- Frontend: React, TypeScript strict mode, Vite, TailwindCSS
- Deployment: Docker, Nginx, Linux

## Foundation

- Clean Architecture dengan `Core`, `Shared`, `Infrastructure`, dan `Modules`
- Repository Pattern dan Service Layer
- REST API v1 dengan response standar
- Authentication Sanctum
- RBAC dengan role, permission, gate, policy, dan middleware
- Global configuration
- Audit logging
- Notification template foundation
- PHPUnit dan CI/CD ready

## Local Setup

```bash
cp .env.example .env
docker compose up --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Frontend:

```bash
npm install
npm run dev
```
