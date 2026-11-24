# Club Events

A small Laravel application to manage a club's **events** and the **members** who organize and attend them.

- Every event has one organizer (a member) and a list of attendees (members).
- You can list, view, create, edit and delete events, filter them (upcoming / past / organizer / search) and see each member's events.

## Requirements

- PHP 8.2 or newer (with the `pdo_sqlite` extension)
- Composer
- No database server needed: the app uses SQLite.

## Installation

```bash
git clone https://github.com/Rawaa223/club-events.git
cd club-events
composer install
cp .env.example .env            # on Windows: copy .env.example .env
php artisan key:generate
touch database/database.sqlite  # on Windows: type nul > database\database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Open http://127.0.0.1:8000 in your browser.

`php artisan migrate:fresh --seed` can be run again at any time to get a fresh demo (20 members, 15 events).

## Running the tests

```bash
php artisan test
```

## What is where

| Requirement | Where |
|---|---|
| Two models + relationship | `app/Models/Event.php` (`organizer()` belongsTo, `attendees()` belongsToMany), `app/Models/Member.php` (`organizedEvents()` hasMany, `attendedEvents()` belongsToMany) |
| Migrations | `database/migrations/2026_11_18_*` (members, events, event_member pivot) |
| Factories + seeder | `database/factories/`, `database/seeders/DatabaseSeeder.php` |
| CRUD with named routes | `routes/web.php` (`Route::resource('events', …)`), `app/Http/Controllers/EventController.php` |
| Validation, messages, `old()` | `app/Http/Requests/EventRequest.php`, `resources/views/events/_form.blade.php` |
| Layout + partials | `resources/views/layouts/app.blade.php`, `partials/nav`, `partials/flash`, `events/_form`, `events/_card` |
| Scopes | `Event::upcoming()`, `Event::past()`, `Event::search()` in `app/Models/Event.php` |
| Page filtered by the related model | `/members/{id}` (events of one member) and `/events?organizer={id}` |
| JSON route | `/api/events` (route name `events.json`) |
| Bonus | search, pagination, feature tests (`tests/Feature/EventTest.php`) |

## Main routes

| Method | URL | Name |
|---|---|---|
| GET | `/events` | events.index |
| GET | `/events/create` | events.create |
| POST | `/events` | events.store |
| GET | `/events/{event}` | events.show |
| GET | `/events/{event}/edit` | events.edit |
| PUT | `/events/{event}` | events.update |
| DELETE | `/events/{event}` | events.destroy |
| GET | `/members` | members.index |
| GET | `/members/{member}` | members.show |
| GET | `/api/events` | events.json |

Run `php artisan route:list` to see them all.
