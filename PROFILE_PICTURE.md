# Profile Picture — Base64 Database Storage

## Why this approach?

Platforms like **Railway, Render, Fly.io, and Heroku** use ephemeral (temporary) containers.
Any file written to the local filesystem — including `storage/app/public/avatars/` — is
**permanently deleted** every time the container restarts or redeploys.

Storing the image as a base64 string inside the database solves this completely because the
database is persistent across all deployments.

---

## How it works

### Upload flow
1. User selects a JPG or PNG (max 2 MB) on the Profile page
2. `ProfileController::update()` reads the raw binary with `file_get_contents()`
3. It encodes it to base64 and prepends the data URI scheme:
   ```
   data:image/jpeg;base64,/9j/4AAQSkZJRgAB...
   ```
4. The full string is saved to the `profile_picture_base64` column (`longtext`)

### Display flow
Every view checks `profile_picture_base64` first:
```blade
@if($user->profile_picture_base64)
    <img src="{{ $user->profile_picture_base64 }}" ...>
@else
    {{-- initials placeholder --}}
@endif
```
Because the `src` is already a complete data URI, no file path, no `Storage::url()`,
and no symlink is needed.

---

## Database column

| Column | Type | Purpose |
|---|---|---|
| `profile_picture` | varchar(255) | Legacy — kept for backward compatibility, no longer written |
| `profile_picture_base64` | longtext | Active — stores the full data URI string |

A `longtext` column can hold up to **4 GB**, so even a 2 MB image (≈ 2.7 MB base64) fits
comfortably.

---

## Local setup (XAMPP)

```bash
# 1. Import the database
#    Open phpMyAdmin → Import → select pcparts_ves.sql

# 2. Run the migration (if you already have the DB without the new column)
php artisan migrate

# 3. No storage:link needed for profile pictures anymore
```

---

## Railway / production deployment steps

```bash
# 1. Push your code — Railway auto-deploys on git push

# 2. Set these environment variables in the Railway dashboard:
APP_KEY=           # generate with: php artisan key:generate --show
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=           # your Railway MySQL host
DB_PORT=3306
DB_DATABASE=       # your database name
DB_USERNAME=       # your database user
DB_PASSWORD=       # your database password

# 3. Run migrations via Railway's shell or a release command:
php artisan migrate --force
```

No `storage:link` command is needed for profile pictures since nothing is written to disk.

---

## Validation rules applied

```php
'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
```

- Only `jpg`, `jpeg`, `png` accepted
- Maximum **2 MB** per upload
- Field is optional — existing picture is kept if no new file is uploaded

---

## Size consideration

A 2 MB image encodes to roughly **2.7 MB** of base64 text. For a typical app with tens or
hundreds of users this is negligible. If you ever need to scale to thousands of users with
frequent image updates, consider migrating to an object storage service (e.g. AWS S3,
Cloudflare R2) at that point.
