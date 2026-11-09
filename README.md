# Bezzey

Bezzey is Hassan’s 2023 Laravel shop: a public catalog, a cart, cash-on-delivery and Stripe checkout, product comments, and an admin desk for products, categories, orders, invoice PDFs, and customer email.

This repository is a portfolio cut of that store. It boots with a fictional catalog, two demo accounts, and cash checkout when Stripe is not configured. Card checkout stays off until you add **Stripe test keys**.

![Storefront](docs/screenshots/storefront.png)

## Features

- Catalog with search, categories, discount prices, and product detail
- Comments and replies on a product
- Cart for signed-in customers
- Cash on delivery, including when Stripe keys are blank
- Stripe Checkout-style card charge when `pk_test_` / `sk_test_` keys are set
- Admin dashboard, products, categories, and orders
- Mark an order delivered, print an invoice PDF, and email the customer
- Jetstream (Livewire) accounts with email verification

## Stack

- PHP 8.2, Laravel 10, Jetstream, Livewire 2, Sanctum, Fortify
- Blade storefront (Bootstrap template in `public/home`) and Corona admin theme (`public/admin`)
- Vite and Tailwind for the account screens
- Stripe PHP SDK, DomPDF for invoices
- SQLite by default, MySQL or Postgres through env

## Architecture

The shop is a classic Laravel MVC app. `routes/web.php` sends the storefront and admin to `HomeController` and `AdminController`.

| Piece | Where it lives |
| --- | --- |
| Catalog, cart, checkout, comments | `app/Http/Controllers/HomeController.php`, `resources/views/home` |
| Products, categories, orders, invoice, email | `app/Http/Controllers/AdminController.php`, `resources/views/admin` |
| Accounts | Jetstream Livewire under `resources/views/auth` and `resources/views/profile` |
| Tables | `products`, `catagories` (spelled that way in the schema), `carts`, `oders`, `comments`, `replies`, `users` |
| Who is an admin | `users.usertype = 1`. Customers are `0` |
| Product photos | Filename stored on the product. Files live in `public/product/` |

Checkout copies each cart line into `oders` and reduces stock. Cash on delivery stores `payment_status = On Delivery`. A successful Stripe test charge stores `Paid`. Both leave the order `Processing` until an admin marks it delivered (`Deliverd` in the existing schema).

Customer email uses the `Oder` model’s `Notifiable` trait and `App\Notifications\Email`. The demo mailer is `log`, so those messages land in the log instead of a mailbox.

Asset URLs are rooted at `/`. Serve the app with `php artisan serve` or any web server whose document root is `public/`.

## Screenshots

![Product detail](docs/screenshots/product-detail.png)

![Admin products](docs/screenshots/admin-products.png)

## Local setup

Requirements: PHP 8.2 with `pdo_sqlite`, `mbstring`, `xml`, `curl`, `zip`, `bcmath`, and `gd`; Composer; Node 18 or newer.

```bash
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Open http://127.0.0.1:8000.

`php artisan migrate --seed` is safe to run again. Products and categories are updated in place. The two demo passwords are reset to the value below. Sample orders are inserted only when they are missing.

### Demo logins

Both accounts are already email-verified.

| Role | Email | Password |
| --- | --- | --- |
| Admin | admin@bezzey.example | password |
| Customer | customer@bezzey.example | password |

After login, admins land on `/redirect`. Customers land on the storefront. Use **Cash on Delivery** from the cart. Card payment is hidden until Stripe test keys exist.

### Stripe, test mode only

Leave `STRIPE_KEY` and `STRIPE_SECRET` empty to run the shop on cash on delivery.

To try cards, put **test** keys from the Stripe dashboard in `.env` and restart:

```bash
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

Use Stripe’s test card `4242 4242 4242 4242`, any future expiry, and any CVC. Do not put live keys in this project. A failed charge leaves the cart intact so the customer can switch to cash on delivery.

### Mail

`.env.example` sets `MAIL_MAILER=log`. Admin “send email” writes the message to `storage/logs/laravel.log`.

### Photos

Demo product photos are Unsplash images under the [Unsplash License](https://unsplash.com/license). Credits are in `public/product/demo/CREDITS.md`. Names and prices in the seeder are fictional.

## Deploy on Render (free web service)

[Render](https://render.com) is the free host that fits this app: a Docker web service, no card required for the free instance, and HTTPS. The free instance sleeps after about 15 minutes without traffic and the disk is ephemeral, so SQLite data can disappear on a new deploy. The container runs migrations and the demo seed on every boot, which puts the fictional catalog and the two logins back.

Fly.io no longer has a free allowance for new accounts. A Render Postgres database on the free plan expires after 30 days, so the default below is SQLite plus the demo seed.

1. Push this branch and open a Render account.
2. **New → Web Service**. Connect the Git repository. Render detects the `Dockerfile`.
3. Choose the **Free** instance type. Health check path: `/`.
4. Set environment variables:

| Key | Value |
| --- | --- |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | output of `php artisan key:generate --show` (a new key, not one from git history) |
| `APP_URL` | the `https://…onrender.com` URL Render assigns |
| `DB_CONNECTION` | `sqlite` |
| `DB_DATABASE` | `/var/www/html/database/database.sqlite` |
| `MAIL_MAILER` | `log` |
| `MAIL_FROM_ADDRESS` | `hello@bezzey.example` |
| `MAIL_FROM_NAME` | `Bezzey` |
| `SESSION_DRIVER` | `file` |
| `CACHE_DRIVER` | `file` |
| `QUEUE_CONNECTION` | `sync` |
| `LOG_CHANNEL` | `stderr` |
| `STRIPE_KEY` | empty, or a `pk_test_…` key |
| `STRIPE_SECRET` | empty, or a `sk_test_…` key |

5. Deploy. The entrypoint migrates, seeds, and listens on Render’s `PORT`.
6. Log in with the demo accounts above.

If `APP_KEY` is omitted, the container generates one in memory for that process. Set a stable key so sessions survive a restart.

### Postgres instead of SQLite

Create a Postgres database (Render’s free database expires after 30 days; [Neon](https://neon.tech) is another option) and replace the SQLite variables:

```bash
DB_CONNECTION=pgsql
DATABASE_URL=postgres://USER:PASSWORD@HOST:5432/DATABASE
DB_SSLMODE=require
```

You can remove `DB_DATABASE` when `DATABASE_URL` is set. The entrypoint still migrates and seeds.

## Security

`.env` is gitignored. `.env.example` contains placeholders only. If an older clone still has a real `.env` in git history, rotate those keys in Stripe and anywhere else they were used. This repo does not rewrite history.

## Tests

```bash
php artisan test --filter=DemoCheckoutTest
```

Use SQLite for the test run, for example `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`.
