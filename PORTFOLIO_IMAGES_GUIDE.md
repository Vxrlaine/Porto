# Portfolio Images Database Guide

## Setup yang Sudah Dilakukan

✅ Model `PortfolioImage` sudah dibuat
✅ Migration table sudah dibuat
✅ Seeder untuk load gambar dari `public/storage/images`
✅ Controller `HomeController` untuk menampilkan gambar
✅ Route sudah diupdate
✅ View `welcome.blade.php` sudah menggunakan database
✅ Command artisan `portfolio:import` untuk import gambar

## Quick Start

```bash
# 1. Pastikan gambar ada di folder public/storage/images/
# 2. Import semua gambar ke database
php artisan portfolio:import --fresh

# 3. Refresh halaman web Anda
```

## Struktur Database

Table: `portfolio_images`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| title | string | Judul gambar (nullable) |
| description | string | Deskripsi gambar (nullable) |
| image_path | string | Path ke file gambar |
| order | integer | Urutan tampilan (default: 0) |
| is_active | boolean | Status aktif/tidak (default: true) |
| timestamps | timestamp | created_at & updated_at |

## Cara Menambahkan Gambar

### Metode 1: Upload ke Folder + Command (RECOMMENDED)
1. Upload gambar Anda ke folder `public/storage/images/`
2. Jalankan command:
```bash
# Import semua gambar (skip yang sudah ada)
php artisan portfolio:import

# Import ulang dari awal (hapus semua data lama)
php artisan portfolio:import --fresh
```

### Metode 2: Upload ke Folder + Seeder
1. Upload gambar Anda ke folder `public/storage/images/`
2. Jalankan seeder:
```bash
php artisan db:seed PortfolioImageSeeder
```

### Metode 3: Manual via Database/Tinker
```bash
php artisan tinker
```

Kemudian jalankan:
```php
App\Models\PortfolioImage::create([
    'title' => 'My Artwork',
    'description' => 'Description of my artwork',
    'image_path' => 'storage/images/filename.jpg',
    'order' => 0,
    'is_active' => true
]);
```

## Menampilkan Gambar di Carousel

Gambar akan otomatis ditampilkan di section "My Design" di homepage. Urutan berdasarkan kolom `order` (ascending).

## Mengelola Gambar

### Mengubah Urutan
```php
$image = App\Models\PortfolioImage::find(1);
$image->order = 5;
$image->save();
```

### Menonaktifkan Gambar
```php
$image = App\Models\PortfolioImage::find(1);
$image->is_active = false;
$image->save();
```

### Menghapus Gambar
```php
App\Models\PortfolioImage::find(1)->delete();
```

### Mengambil Semua Gambar Aktif
```php
$images = App\Models\PortfolioImage::where('is_active', true)
    ->orderBy('order')
    ->get();
```

## File yang Dimodifikasi

1. `app/Models/PortfolioImage.php` - Model
2. `database/migrations/2026_03_27_033620_create_portfolio_images_table.php` - Migration
3. `database/seeders/PortfolioImageSeeder.php` - Seeder
4. `app/Http/Controllers/HomeController.php` - Controller
5. `routes/web.php` - Route
6. `resources/views/welcome.blade.php` - View (carousel section)

## Command Berguna

```bash
# Import gambar dari folder ke database (recommended)
php artisan portfolio:import

# Import ulang dari awal (hapus data lama)
php artisan portfolio:import --fresh

# Lihat semua gambar
php artisan tinker
>>> App\Models\PortfolioImage::all();

# Lihat gambar aktif
>>> App\Models\PortfolioImage::where('is_active', true)->get();

# Seed saja (tanpa reset)
php artisan db:seed PortfolioImageSeeder

# Reset dan seed ulang
php artisan migrate:fresh --seed
```

## Troubleshooting

### Gambar tidak muncul
1. Pastikan folder `public/storage/images` ada
2. Pastikan file gambar ada di folder tersebut
3. Jalankan ulang seeder: `php artisan db:seed PortfolioImageSeeder`

### Error "Table doesn't exist"
Jalankan migration:
```bash
php artisan migrate
```

### Gambar terbalik urutannya
Update kolom `order`:
```php
DB::table('portfolio_images')->where('id', 1)->update(['order' => 0]);
```
