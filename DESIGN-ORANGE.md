# Design System — AdminPro v2

Dokumen ini adalah referensi desain tunggal untuk project ini. Setiap keputusan warna, tipografi, spacing, dan komponen harus mengacu pada dokumen ini agar seluruh halaman dan komponen memiliki tampilan yang konsisten.

---

# Filosofi Desain

## Terang & Profesional

Putih tetap menjadi kanvas utama aplikasi. Warna digunakan untuk memberikan penekanan, bukan mendominasi tampilan.

## Orange Corporate sebagai Anchor

Warna utama menggunakan orange hangat yang modern dan profesional.

Orange digunakan pada:

* Logo aplikasi
* Avatar pengguna
* Tombol primer
* Menu aktif
* Badge
* Fokus interaksi

## Hierarki melalui Tipografi

Perbedaan level informasi dibangun menggunakan:

* ukuran font
* berat font
* spacing

bukan dengan menambahkan banyak warna.

---

# Palet Warna

## Warna Utama

| Nama           | Nilai   | Digunakan untuk            |
| -------------- | ------- | -------------------------- |
| Orange Primary | #F28C28 | Logo, avatar, tombol utama |
| Orange Hover   | #E67E22 | Hover tombol utama         |
| Orange Active  | #D66B0D | State aktif                |
| Orange Light   | #FFF4E8 | Hover background           |
| Orange Soft    | #FFF2E5 | Teks avatar                |
| Orange Accent  | #FDBA74 | Accent icon                |
| Orange Border  | #FED7AA | Hover border               |
| Orange Badge   | #FFE7CC | Background badge           |

---

## Warna Netral

| Nama            | Nilai   | Tailwind         |
| --------------- | ------- | ---------------- |
| White           | #FFFFFF | bg-white         |
| Page Background | #FAFAF9 | bg-stone-50      |
| Border          | #E7E5E4 | border-stone-200 |
| Divider         | #F5F5F4 | bg-stone-100     |
| Text Primary    | #292524 | text-stone-800   |
| Text Secondary  | #78716C | text-stone-500   |
| Text Muted      | #A8A29E | text-stone-400   |
| Text Hint       | #D6D3D1 | text-stone-300   |

---

## Warna Semantik

| Nama              | Tailwind           |
| ----------------- | ------------------ |
| Success           | text-emerald-400   |
| Warning           | text-amber-400     |
| Danger            | text-red-500       |
| Danger Hover      | text-red-600       |
| Danger Background | bg-red-50          |
| Focus Ring        | ring-orange-400/40 |

---

# Tipografi

Font utama:

```html
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet">
```

## Skala Tipografi

| Peran          | Ukuran    | Berat |
| -------------- | --------- | ----- |
| Nama Logo      | 15px      | 600   |
| Section Label  | 10px      | 600   |
| Menu Item      | 13px      | 500   |
| Sub Menu       | 12px      | 500   |
| Nama User      | 12.5px    | 500   |
| Role User      | 11px      | 400   |
| Avatar Initial | 11px      | 600   |
| Badge          | 10px      | 600   |
| Dropdown Item  | 13px      | 400   |
| Breadcrumb     | 12px      | 400   |
| Page Title     | 18–20px   | 600   |
| Page Subtitle  | 12.5–13px | 400   |

---

# Layout & Spacing

## Tinggi Komponen

| Komponen       | Tinggi |
| -------------- | ------ |
| Sidebar Header | 62px   |
| Topbar         | 62px   |
| Avatar         | 30px   |
| Icon Button    | 30px   |
| Logo Icon      | 32px   |
| Sidebar Toggle | 22px   |

---

## Lebar Sidebar

| State     | Lebar |
| --------- | ----- |
| Expanded  | 240px |
| Collapsed | 60px  |

---

## Padding Standar

| Konteks            | Nilai           |
| ------------------ | --------------- |
| Menu Item          | px-2.5 py-[9px] |
| User Card          | px-2.5 py-2     |
| Dropdown Item      | px-3 py-2       |
| Navigation Section | py-3 px-2       |
| Page Content       | p-6             |

---

# Border & Radius

| Elemen        | Radius       |
| ------------- | ------------ |
| Card          | rounded-lg   |
| Dropdown      | rounded-xl   |
| Logo Icon     | rounded-lg   |
| Avatar        | rounded-full |
| Toggle Button | rounded-full |
| Badge         | rounded-full |
| Sub Menu      | rounded-md   |

Semua border menggunakan ketebalan 1px kecuali avatar yang menggunakan border-2.

---

# Komponen

## Active Navigation Indicator

```html
<span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] rounded-r-full bg-orange-600"></span>
```

Menu aktif:

```html
bg-orange-50
text-orange-700
```

---

## Badge

```html
<span class="rounded-full bg-orange-100 px-1.5 py-px text-[10px] font-semibold text-orange-700">
    3
</span>
```

---

## Avatar

```html
<div class="flex h-[30px] w-[30px] items-center justify-center rounded-full
            bg-[#F28C28]
            text-[11px]
            font-semibold
            text-[#FFF2E5]
            border-2
            border-orange-100">
    AN
</div>
```

---

## Dropdown Menu

```html
<div class="rounded-xl bg-white border border-stone-200 shadow-lg shadow-stone-200/60 py-1">

    <a class="flex items-center gap-2.5 px-3 py-2
              text-[13px] text-stone-500
              hover:bg-orange-50
              hover:text-orange-700
              transition-colors">
        <i class="ti ti-user-circle text-orange-400"></i>
        Profil
    </a>

    <div class="my-1 mx-2 h-px bg-stone-100"></div>

    <button class="flex w-full items-center gap-2.5 px-3 py-2
                   text-[13px]
                   text-red-500
                   hover:bg-red-50
                   hover:text-red-600
                   transition-colors">
        <i class="ti ti-logout"></i>
        Keluar
    </button>

</div>
```

---

## Icon Button

```html
<button class="flex h-[30px] w-[30px]
               items-center justify-center
               rounded-lg
               bg-stone-50
               border border-stone-200
               text-stone-500
               hover:bg-orange-50
               hover:border-orange-200
               hover:text-orange-600
               transition-colors duration-150
               focus:outline-none
               focus:ring-2
               focus:ring-orange-400/40">
    <i class="ti ti-search text-[14px]"></i>
</button>
```

---

## Stat Card

```html
<div class="rounded-xl border border-stone-200 bg-white p-5">

    <div class="mb-3 flex items-center justify-between">

        <span class="text-[10px] font-semibold uppercase tracking-wider text-stone-400">
            Label
        </span>

        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50">
            <i class="ti ti-users text-orange-500 text-base"></i>
        </div>

    </div>

    <div class="text-2xl font-semibold text-stone-800">
        2,847
    </div>

    <div class="mt-1 text-xs text-emerald-400">
        ↑ 12% dari bulan lalu
    </div>

</div>
```

---

## Tooltip

```html
<span class="pointer-events-none absolute left-full ml-2 z-50
             whitespace-nowrap rounded-md
             bg-[#F28C28]
             px-2.5 py-1
             text-xs font-medium text-white
             opacity-0
             group-hover:opacity-100
             transition-opacity duration-150"
      role="tooltip">
    Nama Menu
</span>
```

---

# Ikonografi

Library:

```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
```

Format:

```html
<i class="ti ti-users" aria-hidden="true"></i>
```

Gunakan ikon outline dari Tabler Icons secara konsisten.

---

# Aksesibilitas

* Semua elemen interaktif menggunakan focus ring.
* Sidebar memiliki aria-label.
* Dropdown menggunakan aria-expanded.
* Menu aktif menggunakan aria-current="page".
* Tooltip menggunakan role="tooltip".
* Ikon dekoratif menggunakan aria-hidden="true".

---

# Aturan Tambahan

* Jangan menambahkan warna baru tanpa memperbarui dokumen ini.
* Hindari gradien.
* Hindari shadow berat.
* Gunakan hover orange secara konsisten.
* Gunakan stone sebagai warna netral utama.
* Semua state aktif menggunakan keluarga orange.
* Putih tetap menjadi background dominan aplikasi.
