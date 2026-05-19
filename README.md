# 🚀 AdminPro — Laravel Starter Kit

Aplikasi admin panel berbasis **Laravel 11** + **Breeze** dengan sistem manajemen user, role, dan permission menggunakan **Spatie Laravel Permission**.

---

## 📋 Fitur

- **Autentikasi** — Login, Register, Forgot Password bawaan Laravel Breeze
- **Manajemen User** — CRUD user dengan assign role & direct permission
- **Manajemen Role** — CRUD role beserta permission yang ditetapkan
- **Manajemen Permission** — Tambah & hapus permission secara dinamis
- **Direct Permission** — User bisa memiliki permission sendiri di luar role
- **Sidebar Dinamis** — Menu muncul/sembunyi otomatis berdasarkan permission user
- **Role-based Access Control** — Route & view dilindungi berdasarkan role/permission
- **UUID** — Primary key semua model menggunakan UUID
- **SweetAlert2** — Konfirmasi aksi dan notifikasi toast
- **Responsive** — Sidebar collapsible, support mobile

---

## 🛠 Tech Stack

| Teknologi | Versi |
|---|---|
| PHP | 8.2+ |
| Laravel | 11.x |
| Laravel Breeze | Blade SSR |
| Spatie Permission | ^6.x |
| Tailwind CSS | ^3.x |
| Alpine.js | ^3.x |
| SweetAlert2 | ^11.x |
| Tabler Icons | Latest |
| DM Sans | Google Fonts |

---

## ⚙️ Instalasi

### 1. Clone & Install

```bash
git clone https://github.com/username/adminpro.git
cd adminpro
composer install
npm install
```

### 2. Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adminpro
DB_USERNAME=root
DB_PASSWORD=

HASH_DRIVER=argon2id
```

### 3. Migrasi & Seeder

```bash
php artisan migrate:fresh --seed
```

### 4. Build Assets

```bash
npm run build
# atau untuk development
npm run dev
```

### 5. Jalankan

```bash
php artisan serve
```

Akses di `http://127.0.0.1:8000`

---

## 👤 Akun Default

| Email | Password | Role |
|---|---|---|
| `admin@example.com` | `password` | Admin |
| `user@example.com` | `password` | User |

---

## 🔐 Permission

| Permission | Admin | User |
|---|:---:|:---:|
| `dashboard.view` | ✓ | ✓ |
| `users.view` | ✓ | ✓ |
| `users.show` | ✓ | ✓ |
| `users.create` | ✓ | |
| `users.edit` | ✓ | |
| `users.delete` | ✓ | |
| `roles.view` | ✓ | |
| `roles.create` | ✓ | |
| `roles.edit` | ✓ | |
| `roles.delete` | ✓ | |
| `permissions.view` | ✓ | |
| `permissions.create` | ✓ | |
| `permissions.edit` | ✓ | |
| `permissions.delete` | ✓ | |

---

## 📁 Struktur Penting

```
app/
├── Http/Controllers/
│   ├── UserController.php        # CRUD user + sync permission
│   ├── RoleController.php        # CRUD role + sync permission
│   └── PermissionController.php  # Tambah & hapus permission
├── Models/
│   ├── User.php                  # HasUuids + HasRoles
│   ├── Role.php                  # Extend SpatieRole + HasUuids
│   └── Permission.php            # Extend SpatiePermission + HasUuids

database/
└── seeders/
    └── DatabaseSeeder.php        # Permission, Role, User default

resources/views/
├── components/
│   ├── sidebar/
│   │   ├── nav-link.blade.php    # Item menu dengan activeRoutes
│   │   └── dropdown.blade.php   # Dropdown menu dengan activeRoutes
│   ├── sidebar.blade.php         # Sidebar dinamis berbasis permission
│   └── topbar.blade.php          # Header dengan user dropdown
├── users/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php            # Termasuk direct permission management
├── roles/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── permissions/
    └── index.blade.php

routes/
└── web.php                       # Route berbasis permission middleware

bootstrap/
└── app.php                       # Registrasi middleware Spatie
```

---

## 🗺 Routes

### Users
| Method | URL | Name | Middleware |
|---|---|---|---|
| GET | `/users` | `users.index` | `permission:users.view` |
| GET | `/users/create` | `users.create` | `permission:users.view` |
| POST | `/users` | `users.store` | `permission:users.view` |
| GET | `/users/{user}` | `users.show` | `permission:users.view` |
| GET | `/users/{user}/edit` | `users.edit` | `permission:users.view` |
| PUT | `/users/{user}` | `users.update` | `permission:users.view` |
| DELETE | `/users/{user}` | `users.destroy` | `permission:users.view` |
| PUT | `/users/{user}/permissions` | `users.permissions.sync` | `permission:users.view` |

### Roles
| Method | URL | Name | Middleware |
|---|---|---|---|
| GET | `/roles` | `roles.index` | `permission:roles.view` |
| GET | `/roles/create` | `roles.create` | `permission:roles.view` |
| POST | `/roles` | `roles.store` | `permission:roles.view` |
| GET | `/roles/{role}/edit` | `roles.edit` | `permission:roles.view` |
| PUT | `/roles/{role}` | `roles.update` | `permission:roles.view` |
| DELETE | `/roles/{role}` | `roles.destroy` | `permission:roles.view` |

### Permissions
| Method | URL | Name | Middleware |
|---|---|---|---|
| GET | `/permissions` | `permissions.index` | `permission:roles.view` |
| POST | `/permissions` | `permissions.store` | `permission:roles.view` |
| DELETE | `/permissions/{permission}` | `permissions.destroy` | `permission:roles.view` |

---

## 💡 Cara Menambah Menu Baru

### 1. Tambah permission di `DatabaseSeeder.php`
```php
'products.view', 'products.create', 'products.edit', 'products.delete',
```

Jalankan:
```bash
php artisan db:seed --class=DatabaseSeeder
```

### 2. Tambah menu di `sidebar.blade.php`
```php
$user->can('products.view') ? [
    'label'        => 'Produk',
    'icon'         => 'ti-shopping-cart',
    'route'        => 'products.index',
    'url'          => route('products.index'),
    'activeRoutes' => ['products.index', 'products.create', 'products.edit', 'products.show'],
] : null,
```

### 3. Lindungi route
```php
Route::middleware(['auth', 'permission:products.view'])->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    // ...
});
```

### 4. Tambah `@can` di view
```blade
@can('products.create')
    <a href="{{ route('products.create') }}">Tambah Produk</a>
@endcan
```

---

## 📝 Lisensi

MIT License — bebas digunakan dan dimodifikasi.