# Area 75 — Symfony App Setup

## Prerequisites
- PHP 8.2+ at `/opt/homebrew/bin/php`
- Symfony CLI at `/opt/homebrew/bin/symfony`
- PostgreSQL running on `localhost:5432`
- Composer (install via `brew install composer` if needed)

## First-time setup

```bash
cd /Users/Shared/Projects/recovery/area75

# 1. Install PHP dependencies
/opt/homebrew/bin/php $(which composer) install
# OR if composer is in PATH:
composer install

# 2. Create the database
/opt/homebrew/bin/php bin/console doctrine:database:create

# 3. Run migrations (creates the user and event tables)
/opt/homebrew/bin/php bin/console doctrine:migrations:migrate

# 4. Set file permissions on the uploads directory
chmod -R 775 public/uploads/
chmod -R 775 var/

# 5. Start the development server
/opt/homebrew/bin/symfony server:start
```

Then open: http://localhost:8000

## Credentials
- **Database**: `postgres`/`postgres` at `localhost:5432/area75`
- See `.env` to change the `DATABASE_URL`

## Creating an admin user

After registering via the web UI, promote yourself to admin:

```bash
/opt/homebrew/bin/php bin/console doctrine:query:sql \
  "UPDATE \"user\" SET roles = '[\"ROLE_ADMIN\",\"ROLE_USER\"]' WHERE username = 'your_username'"
```

## Key URLs
| Path | Description |
|------|-------------|
| `/` | Home page |
| `/calendar` | Events calendar |
| `/calendar/add` | Add event (login required) |
| `/business` | Business meetings & forms |
| `/page/whatisaa` | What is AA? |
| `/page/12steps` | The 12 Steps |
| `/page/12traditions` | The 12 Traditions |
| `/page/districtmeetings` | District meeting schedule |
| `/login` | Login |
| `/register` | Register |
| `/resetting/request` | Forgot password |
| `/_profiler` | Symfony profiler (dev only) |

## Event approval
Events submitted via the calendar form are **not publicly visible** until approved.
To approve an event:
```bash
/opt/homebrew/bin/php bin/console doctrine:query:sql \
  "UPDATE event SET is_approved = true WHERE id = <event_id>"
```
A future admin panel can be added to manage this from the browser.

## Production deployment
1. Set `APP_ENV=prod` in `.env.local`
2. Update `DATABASE_URL` with production credentials
3. Run `composer install --no-dev --optimize-autoloader`
4. Run `php bin/console cache:clear --env=prod`
5. Configure your web server to point at the `public/` directory
