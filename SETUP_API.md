# API Ditambahkan ke Project Ini

Semua endpoint API sudah langsung dipasang ke project kamu (bukan project terpisah lagi). File yang ditambahkan/diubah:

**Baru:**
- `app/Http/Controllers/Api/*` — AuthController, ItemController, JobDivisionController, ItemPickupController, ItemLoanController, ItemRequestController, UserController
- `routes/api.php`
- `database/migrations/2025_06_20_000000_create_personal_access_tokens_table.php` (tabel token Sanctum)
- `config/sanctum.php`

**Diubah:**
- `bootstrap/app.php` — daftar `routes/api.php`
- `app/Models/User.php` — tambah trait `HasApiTokens`
- `app/Http/Middleware/RoleMiddleware.php` — sekarang balas JSON 401/403 kalau request API (`Accept: application/json`), tetap redirect kalau request web biasa. Jadi middleware `role:admin` yang sudah ada di project kamu dipakai bareng untuk web & API, nggak bikin file middleware baru.
- `composer.json` — tambah `laravel/sanctum`

## Yang WAJIB kamu jalankan sendiri (sandbox aku nggak bisa akses Packagist)

```bash
composer update laravel/sanctum
# atau kalau baru pertama kali:
composer require laravel/sanctum

php artisan migrate
```

Kalau upload gambar item lewat API, pastikan storage link sudah ada:
```bash
php artisan storage:link
```

## Contoh pakai

Login:
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Accept: application/json" \
  -d "email=admin@gmail.com" -d "password=password"
```

Response berisi `access_token`. Pakai di setiap request selanjutnya:
```
Authorization: Bearer {access_token}
Accept: application/json
```

Contoh ambil daftar barang:
```bash
curl http://127.0.0.1:8000/api/items \
  -H "Authorization: Bearer {access_token}" \
  -H "Accept: application/json"
```

## Daftar endpoint

| Method | Endpoint | Akses |
|---|---|---|
| POST | `/api/register` | Publik |
| POST | `/api/login` | Publik |
| POST | `/api/logout` | Login |
| GET | `/api/me` | Login |
| GET | `/api/items` , `/api/items/{id}` | Login |
| POST/PUT/DELETE | `/api/items...` | Admin |
| GET | `/api/job-divisions` , `/api/job-divisions/{id}` | Login |
| POST/PUT/DELETE | `/api/job-divisions...` | Admin |
| GET/POST | `/api/item-pickups` | Login (data sendiri, admin lihat semua) |
| DELETE | `/api/item-pickups/{id}` | Admin (kembalikan stok) |
| GET/POST | `/api/item-loans` | Login |
| POST | `/api/item-loans/{id}/return` | Pemilik/Admin |
| DELETE | `/api/item-loans/{id}` | Admin |
| GET/POST | `/api/item-requests` | Login |
| POST | `/api/item-requests/{id}/approve` , `/reject` | Admin |
| DELETE | `/api/item-requests/{id}` | Pemilik/Admin |
| GET/POST/PUT/DELETE | `/api/users...` | Admin |

Semua endpoint yang butuh stok (pickup & pinjam) sudah dicek kecukupan stok dan dibungkus `DB::transaction`.
