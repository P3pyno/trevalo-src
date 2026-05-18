<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Railway deployment

This repository includes Railway config-as-code for the Laravel app:

- `railway.toml` uses Railway's Railpack builder and runs the Vite production build.
- `railway/init-app.sh` is configured as the pre-deploy command and runs database migrations before the web service goes live.
- `railway/run-worker.sh` and `railway/run-cron.sh` can be used as custom start commands if you add separate Railway worker or scheduler services later.

### Deploy from GitHub

1. Push this repository to GitHub.
2. In Railway, create a new project and choose **Deploy from GitHub repo**.
3. Add a Postgres database service.
4. Add these variables to the Laravel app service:

   ```dotenv
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:generated-with-php-artisan-key-generate
   APP_URL=https://your-railway-domain.up.railway.app
   FRONTEND_URL=https://your-railway-domain.up.railway.app
   DB_CONNECTION=pgsql
   DB_URL=${{Postgres.DATABASE_URL}}
   QUEUE_CONNECTION=database
   SESSION_DRIVER=database
   CACHE_STORE=database
   LOG_CHANNEL=stderr
   LOG_STDERR_FORMATTER=\Monolog\Formatter\JsonFormatter
   ```

5. Generate a public domain in the Railway service **Networking** settings.
6. Redeploy after variables are saved.

To generate an app key locally, run:

```bash
php artisan key:generate --show
```

### Optional worker and scheduler services

For production queues or scheduled tasks, create additional Railway services from the same GitHub repository and set their custom start commands to:

```bash
chmod +x ./railway/run-worker.sh && ./railway/run-worker.sh
```

```bash
chmod +x ./railway/run-cron.sh && ./railway/run-cron.sh
```
