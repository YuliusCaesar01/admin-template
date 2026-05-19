# Design System — AdminPro

Dokumen ini adalah referensi desain tunggal untuk project ini. Setiap keputusan warna, tipografi, spacing, dan komponen diambil langsung dari kode yang sudah berjalan. Gunakan dokumen ini sebelum membuat komponen atau halaman baru agar tampilan tetap konsisten.

---

## Panduan Ganti Warna

Warna saat ini tersebar langsung di kelas Tailwind di file Blade. Tidak ada satu titik pusat. Gunakan tabel di bawah sebagai **checklist** saat ingin mengganti warna tema.

### Biru Tua — `#1e3a5f`
Warna anchor utama: logo icon, avatar, tooltip.

| File | Cari | Jumlah |
|---|---|---|
| `components/sidebar.blade.php` | `bg-[#1e3a5f]` | 2× |
| `components/sidebar.blade.php` | `text-[#1e3a5f]` | 1× |
| `components/topbar.blade.php` | `bg-[#1e3a5f]` | 1× |
| `components/sidebar/nav-link.blade.php` | `bg-[#1e3a5f]` | 1× (tooltip) |
| `components/sidebar/dropdown.blade.php` | `bg-[#1e3a5f]` | 1× (tooltip) |

**Total: 6 tempat.**

---

### Biru Aksen — `blue-600` / `blue-700` / `blue-50`
Warna interaksi: aktif, hover, fokus, teks aksen.

| Kelas | Digunakan di | Peran |
|---|---|---|
| `text-blue-600` | `sidebar.blade.php`, `topbar.blade.php`, `nav-link.blade.php`, `dropdown.blade.php` | Teks aktif, ikon toggle, breadcrumb aktif |
| `text-blue-700` | `nav-link.blade.php`, `dropdown.blade.php`, `topbar.blade.php` | Teks hover item & dropdown |
| `bg-blue-50` | Semua komponen | Background hover & aktif |
| `hover:bg-blue-50` | Semua komponen | Hover state |
| `hover:text-blue-700` | `sidebar.blade.php`, `topbar.blade.php` | Hover teks dropdown |
| `hover:border-blue-200` | `topbar.blade.php` | Hover border icon button |
| `focus:ring-blue-400/40` | Semua komponen | Focus ring |
| `border-blue-300` | `sidebar.blade.php` | Hover border toggle button |

**Cari `blue-` di semua file `components/` untuk menemukan seluruhnya.**

---

### Warna Netral — `slate-*`
Warna struktur: background, border, teks sekunder.

| Kelas | File | Peran |
|---|---|---|
| `bg-white` | `sidebar.blade.php`, `topbar.blade.php`, `layouts/app.blade.php` | Background sidebar & topbar |
| `bg-slate-50` | `layouts/app.blade.php`, `pages/dashboard.blade.php` | Background halaman |
| `border-slate-200` | Semua komponen | Semua garis border |
| `bg-slate-100` | `sidebar.blade.php`, `topbar.blade.php` | Garis divider dropdown |
| `text-slate-800` | `sidebar.blade.php`, `topbar.blade.php` | Nama pengguna |
| `text-slate-500` | `nav-link.blade.php`, `dropdown.blade.php` | Teks menu non-aktif |
| `text-slate-400` | `sidebar.blade.php`, `topbar.blade.php` | Role, section label, breadcrumb |
| `text-slate-300` | `sidebar.blade.php`, `topbar.blade.php` | Ikon dots-vertical, chevron |

---

### Warna Avatar & Badge

| Kelas | File | Peran |
|---|---|---|
| `text-blue-200` | `sidebar.blade.php`, `topbar.blade.php` | Inisial teks di atas avatar gelap |
| `border-blue-100` | `sidebar.blade.php`, `topbar.blade.php` | Border avatar |
| `bg-blue-100 text-blue-700` | `nav-link.blade.php` | Badge / pill notifikasi |
| `text-blue-400` | `sidebar.blade.php`, `topbar.blade.php`, `nav-link.blade.php` | Ikon di dalam dropdown |
| `bg-blue-500` | `topbar.blade.php` | Dot notifikasi di bell icon |

---

### Ringkasan File yang Harus Dibuka

Jika ingin ganti **seluruh tema warna**, buka dan edit file berikut secara berurutan:

1. `resources/views/components/sidebar.blade.php`
2. `resources/views/components/topbar.blade.php`
3. `resources/views/components/sidebar/nav-link.blade.php`
4. `resources/views/components/sidebar/dropdown.blade.php`
5. `resources/views/layouts/app.blade.php`

File `pages/dashboard.blade.php` hanya berisi warna semantik (`emerald`, `amber`) yang tidak perlu diganti saat ganti tema utama.

---

## Prinsip Desain

**Terang & Bersih** — Putih sebagai kanvas utama, bukan warna dekorasi. Elemen penting menonjol lewat kontras, bukan lewat efek.

**Biru Tua sebagai Anchor** — `#1e3a5f` digunakan di titik-titik yang membutuhkan bobot visual: logo, avatar, tombol primer. Bukan dipakai di mana-mana.

**Aksen Biru Medium untuk Interaksi** — `blue-600` (`#2563eb`) dan turunannya menandai state aktif, hover, dan fokus secara konsisten di seluruh aplikasi.

**Hierarki lewat Tipografi, bukan Warna** — Perbedaan level informasi ditunjukkan dengan ukuran font dan berat, bukan dengan menambah warna baru.

---

## Palet Warna

### Warna Utama

| Nama | Nilai | Kelas Tailwind | Digunakan untuk |
|---|---|---|---|
| Biru Tua | `#1e3a5f` | `bg-[#1e3a5f]` | Logo icon, avatar bg, teks logo |
| Biru Medium | `#2563eb` | `text-blue-600` / `bg-blue-600` | Teks aktif, ikon aktif, indikator aktif |
| Biru Hover | `#eff6ff` | `bg-blue-50` | Background hover & aktif item menu |
| Biru Muda | `#bfdbfe` | `text-blue-200` | Teks di atas avatar gelap |
| Biru Aksen | `#93c5fd` | `text-blue-300` | Ikon di dalam logo icon |
| Biru Badge | `#dbeafe` / `#1e40af` | `bg-blue-100 text-blue-700` | Badge / pill notifikasi |

### Warna Netral

| Nama | Nilai | Kelas Tailwind | Digunakan untuk |
|---|---|---|---|
| Putih | `#ffffff` | `bg-white` | Background sidebar, topbar, dropdown, card |
| Abu Halaman | `#f8fafc` | `bg-slate-50` | Background halaman utama |
| Border | `#e2e8f0` | `border-slate-200` | Semua garis pemisah & border komponen |
| Divider | `#f1f5f9` | `bg-slate-100` | Garis divider di dalam dropdown |
| Teks Utama | `#1e293b` | `text-slate-800` | Nama pengguna, judul halaman |
| Teks Sekunder | `#64748b` | `text-slate-500` | Label menu non-aktif, teks body |
| Teks Muted | `#94a3b8` | `text-slate-400` | Section label, role, breadcrumb, teks placeholder |
| Teks Hint | `#cbd5e1` | `text-slate-300` | Ikon dots-vertical, chevron |

### Warna Semantik

| Nama | Kelas Tailwind | Digunakan untuk |
|---|---|---|
| Danger (teks) | `text-red-500` | Tombol logout |
| Danger (hover bg) | `bg-red-50` | Hover tombol logout |
| Danger (hover teks) | `text-red-600` | Hover teks logout |
| Success | `text-emerald-400` | Angka perubahan positif di stat card |
| Warning | `text-amber-400` | Angka perubahan yang perlu perhatian |
| Fokus ring | `ring-blue-400/40` | Focus outline semua elemen interaktif |

---

## Tipografi

Font: **DM Sans** (Google Fonts)
```html
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet">
```

### Skala

| Peran | Ukuran | Berat | Kelas Tailwind |
|---|---|---|---|
| Nama logo | 15px | 600 | `text-[15px] font-semibold` |
| Section label nav | 10px | 600 | `text-[10px] font-semibold uppercase tracking-widest` |
| Item menu | 13px | 500 | `text-[13px] font-medium` |
| Sub-item menu | 12px | 500 | `text-[12px] font-medium` |
| Nama pengguna | 12.5px | 500 | `text-[12.5px] font-medium` |
| Role pengguna | 11px | 400 | `text-[11px]` |
| Inisial avatar | 11px | 600 | `text-[11px] font-semibold` |
| Badge / pill | 10px | 600 | `text-[10px] font-semibold` |
| Menu dropdown item | 13px | 400 | `text-[13px]` |
| Breadcrumb | 12px | 400 | `text-[12px]` |
| Judul halaman | 18–20px | 600 | `text-xl font-semibold` |
| Sub-judul halaman | 12.5–13px | 400 | `text-[12.5px]` |

---

## Spacing & Layout

### Tinggi Elemen Tetap

| Elemen | Tinggi | Kelas |
|---|---|---|
| Sidebar logo area | 62px | `h-[62px]` |
| Topbar | 62px | `h-[62px]` |
| Icon button (topbar) | 30px | `h-[30px] w-[30px]` |
| Avatar | 30px | `h-[30px] w-[30px]` |
| Logo icon | 32px | `h-8 w-8` |
| Toggle button sidebar | 22px | `h-[22px] w-[22px]` |

### Lebar Sidebar

| State | Lebar | Kelas Alpine |
|---|---|---|
| Expanded | 240px | `w-60` |
| Collapsed | 60px | `w-[60px]` |

### Padding Standar

| Konteks | Nilai | Kelas |
|---|---|---|
| Item menu (dalam) | 9px 10px | `px-2.5 py-[9px]` |
| User card | 8px 10px | `px-2.5 py-2` |
| Dropdown item | 8px 12px | `px-3 py-2` |
| Nav section (container) | 12px 8px | `py-3 px-2` |
| Konten halaman | 24px | `p-6` |

---

## Border & Radius

| Elemen | Radius | Kelas |
|---|---|---|
| Item menu, card kecil | 8px | `rounded-lg` |
| Dropdown menu | 12px | `rounded-xl` |
| Logo icon | 8px | `rounded-lg` |
| Avatar | 50% | `rounded-full` |
| Toggle button | 50% | `rounded-full` |
| Badge / pill | 9999px | `rounded-full` |
| Sub-item menu | 6px | `rounded-md` |

Semua border menggunakan ketebalan `1px` (default) kecuali avatar border: `border-2` (2px), dan indikator aktif sidebar: `3px` via inline width.

---

## Komponen

### Indikator Aktif Menu

Bilah vertikal 3px di sisi kiri item menu yang sedang aktif.

```html
<span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] rounded-r-full bg-blue-600"></span>
```

Background item aktif: `bg-blue-50`, teks: `text-blue-700`, ikon: `text-blue-600`.

### Badge / Pill Notifikasi

```html
<span class="rounded-full bg-blue-100 px-1.5 py-px text-[10px] font-semibold text-blue-700">
    3
</span>
```

### Avatar (Inisial)

```html
<div class="flex h-[30px] w-[30px] items-center justify-center rounded-full
            bg-[#1e3a5f] text-[11px] font-semibold text-blue-200
            border-2 border-blue-100">
    AN
</div>
```

### Dropdown Menu

Arah terbuka disesuaikan posisi trigger:
- Sidebar (bawah layar) → `bottom-full mb-1` (terbuka ke atas)
- Topbar (atas layar) → `top-full mt-1` (terbuka ke bawah)

```html
<!-- Struktur dasar dropdown -->
<div class="rounded-xl bg-white border border-slate-200 shadow-lg shadow-slate-200/60 py-1">
    <!-- item biasa -->
    <a class="flex items-center gap-2.5 px-3 py-2 text-[13px] text-slate-600
              hover:bg-blue-50 hover:text-blue-700 transition-colors">
        <i class="ti ti-user-circle text-blue-400"></i> Label
    </a>
    <!-- divider -->
    <div class="my-1 mx-2 h-px bg-slate-100"></div>
    <!-- item danger -->
    <button class="flex w-full items-center gap-2.5 px-3 py-2 text-[13px]
                   text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
        <i class="ti ti-logout"></i> Keluar
    </button>
</div>
```

### Icon Button (Topbar)

```html
<button class="flex h-[30px] w-[30px] items-center justify-center rounded-lg
               bg-slate-50 border border-slate-200 text-slate-500
               hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600
               transition-colors duration-150
               focus:outline-none focus:ring-2 focus:ring-blue-400/40">
    <i class="ti ti-search text-[14px]"></i>
</button>
```

### Stat Card

```html
<div class="rounded-xl border border-slate-200 bg-white p-5">
    <div class="mb-3 flex items-center justify-between">
        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Label</span>
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50">
            <i class="ti ti-users text-blue-500 text-base"></i>
        </div>
    </div>
    <div class="text-2xl font-semibold text-slate-800">2,847</div>
    <div class="mt-1 text-xs text-emerald-400">↑ 12% dari bulan lalu</div>
</div>
```

### Tooltip (Sidebar Collapsed)

Muncul saat sidebar dalam kondisi collapsed, di sebelah kanan icon menu.

```html
<span class="pointer-events-none absolute left-full ml-2 z-50
             whitespace-nowrap rounded-md bg-[#1e3a5f]
             px-2.5 py-1 text-xs font-medium text-white
             opacity-0 group-hover:opacity-100 transition-opacity duration-150"
      role="tooltip">
    Nama Menu
</span>
```

---

## Transisi & Animasi

| Konteks | Durasi | Easing | Properti |
|---|---|---|---|
| Sidebar expand/collapse | 250ms | `ease-in-out` | `width`, `opacity` |
| Hover item menu | 150ms | default | `background-color`, `color` |
| Dropdown buka | 150ms | `ease-out` | `opacity`, `transform` (scale + translate) |
| Dropdown tutup | 100ms | `ease-in` | `opacity`, `transform` |
| Chevron rotate | 150ms | default | `transform` |
| Toggle button chevron | 250ms | default | `transform` |

Semua animasi menggunakan Alpine.js `x-transition` atau kelas Tailwind `transition-*`. Tidak ada keyframe kustom untuk interaksi UI rutin.

---

## Ikonografi

Library: **Tabler Icons** (webfont, outline only)
```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
```

Penggunaan: `<i class="ti ti-[nama-ikon]"></i>`. Selalu tambahkan `aria-hidden="true"` untuk ikon dekoratif.

### Ikon yang Digunakan

| Konteks | Ikon |
|---|---|
| Dashboard | `ti-layout-dashboard` |
| Pengguna | `ti-users` |
| Laporan | `ti-chart-bar` |
| Konten | `ti-file-text` |
| Produk | `ti-shopping-cart` |
| Pengaturan | `ti-settings` |
| Keamanan | `ti-shield-check` |
| Notifikasi | `ti-bell` |
| Logo aplikasi | `ti-bolt` |
| Cari | `ti-search` |
| Hamburger mobile | `ti-menu-2` |
| Toggle sidebar | `ti-chevron-left` |
| Dropdown arrow | `ti-chevron-down` |
| User menu trigger | `ti-dots-vertical` |
| Profil | `ti-user-circle` |
| Logout | `ti-logout` |
| Breadcrumb separator | `ti-chevron-right` |

Ukuran ikon: `text-lg` (18px) untuk nav item, `text-[14px]` untuk icon button topbar, `text-xl` untuk hamburger.

---

## Aksesibilitas

- Setiap elemen interaktif memiliki `focus:outline-none focus:ring-2 focus:ring-blue-400/40`.
- Item menu aktif menggunakan `aria-current="page"`.
- Dropdown menggunakan `aria-expanded`, `aria-haspopup`, dan `role="menu"` / `role="menuitem"`.
- Sidebar menggunakan `aria-label="Navigasi utama"`.
- Semua ikon dekoratif menggunakan `aria-hidden="true"`.
- Tooltip sidebar menggunakan `role="tooltip"`.
- Overlay mobile menggunakan `aria-hidden="true"`.

---

## Aturan Tambahan

**Jangan tambahkan warna baru** tanpa mendefinisikannya di dokumen ini terlebih dahulu.

**Hindari shadow berat** — satu-satunya shadow yang diizinkan adalah `shadow-lg shadow-slate-200/60` pada dropdown, untuk memberikan kesan lapisan tanpa kesan dramatis.

**Tidak ada gradien** — seluruh tampilan menggunakan flat color.

**Konsistensi hover** — semua elemen klikable menggunakan `hover:bg-blue-50` sebagai background hover, dan `hover:text-blue-600` atau `hover:text-blue-700` sebagai warna teks hover.
