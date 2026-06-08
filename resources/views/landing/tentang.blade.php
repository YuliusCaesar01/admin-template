{{-- resources/views/pages/tentang.blade.php --}}
@extends('layouts.landing')

@section('title', 'Tentang Kami')

@push('styles')
<style>
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 56px;
        align-items: center;
    }

    .about-text h2 {
        font-size: clamp(22px, 3.5vw, 32px);
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.4px;
        line-height: 1.25;
        margin: 0 0 16px;
    }

    .about-text p {
        font-size: 13.5px;
        color: var(--text-secondary);
        line-height: 1.7;
        margin: 0 0 14px;
    }

    .about-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 28px;
    }

    .about-stat {
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        border-radius: 12px;
        padding: 16px 18px;
    }

    .about-stat strong {
        display: block;
        font-size: 22px;
        font-weight: 700;
        color: var(--orange-primary);
        letter-spacing: -0.5px;
        margin-bottom: 2px;
    }

    .about-stat span { font-size: 12px; color: #92400E; }

    /* Alat / Mesin Grid */
    .equipment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 40px;
    }

    .equipment-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
        transition: all 0.2s;
    }

    .equipment-card:hover {
        border-color: var(--orange-border);
        box-shadow: 0 4px 20px rgba(242,140,40,0.08);
        transform: translateY(-2px);
    }

    .equipment-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--orange-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--orange-primary);
        margin-bottom: 14px;
    }

    .equipment-card h3 {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 6px;
        line-height: 1.35;
    }

    .equipment-card p {
        font-size: 12.5px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0 0 10px;
    }

    .standard-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .standard-badge {
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        border-radius: 20px;
        padding: 2px 8px;
        font-size: 10.5px;
        color: #92400E;
        font-weight: 500;
    }

    /* Values */
    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 40px;
    }

    .value-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 24px;
        text-align: center;
        transition: all 0.2s;
    }

    .value-card:hover {
        border-color: var(--orange-border);
        box-shadow: 0 4px 20px rgba(242,140,40,0.08);
        transform: translateY(-2px);
    }

    .value-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--orange-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: var(--orange-primary);
        margin: 0 auto 14px;
    }

    .value-card h3 { font-size: 14px; font-weight: 600; color: var(--text-primary); margin: 0 0 8px; }
    .value-card p { font-size: 12.5px; color: var(--text-secondary); line-height: 1.6; margin: 0; }

    /* Testimoni */
    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 40px;
    }

    .testimonial-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
        transition: box-shadow 0.2s;
    }

    .testimonial-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.05); }

    .testimonial-stars { display: flex; gap: 2px; margin-bottom: 12px; }
    .testimonial-stars i { color: var(--orange-primary); font-size: 13px; }

    .testimonial-card blockquote {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.65;
        margin: 0 0 16px;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid var(--divider);
    }

    .author-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--orange-primary);
        border: 2px solid var(--orange-badge);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        flex-shrink: 0;
    }

    .author-name { font-size: 12.5px; font-weight: 500; color: var(--text-primary); }
    .author-role { font-size: 11px; color: var(--text-muted); }

    @media (max-width: 900px) {
        .about-grid { grid-template-columns: 1fr; }
        .equipment-grid { grid-template-columns: 1fr 1fr; }
        .values-grid { grid-template-columns: 1fr 1fr; }
        .testimonials-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 560px) {
        .equipment-grid { grid-template-columns: 1fr; }
        .values-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<!-- Page Hero -->
<div class="page-hero">
    <div class="page-hero-inner">
        <div class="page-breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <i class="ti ti-chevron-right"></i>
            <span>Tentang Kami</span>
        </div>
        <h1>Tentang MateriTest</h1>
        <p>
            Laboratorium pengujian material plastik dan komposit yang lengkap, dioperasikan oleh
            Program Studi Perancangan Manufaktur Politeknik ATMI Surakarta untuk mendukung
            kegiatan belajar, penelitian, dan layanan industri.
        </p>
    </div>
</div>

<!-- About Section -->
<section class="section" style="background:var(--white);">
    <div class="section-inner">
        <div class="about-grid">
            <div class="about-text animate-in">
                <div class="section-label">
                    <i class="ti ti-microscope"></i>
                    Tentang Kami
                </div>
                <h2>Laboratorium Material Testing ATMI Surakarta</h2>
                <p>
                    Laboratorium Material Testing merupakan laboratorium pengujian material plastik dan komposit
                    milik Program Studi Perancangan Manufaktur Politeknik ATMI Surakarta. Laboratorium ini
                    dilengkapi dengan mesin UTM, Impact, Hardness, dan berbagai peralatan pengujian modern
                    lainnya.
                </p>
                <p>
                    Fasilitas pengujian kami digunakan untuk mendukung kegiatan belajar dan penelitian mahasiswa,
                    sekaligus membuka layanan pengujian bagi industri yang membutuhkan analisis material
                    berstandar internasional. Seluruh pengujian mengacu pada standar ASTM, ISO, DIN, dan JIS.
                </p>
                <p>
                    Berlokasi di kampus Politeknik ATMI Surakarta, laboratorium kami dikelola oleh tenaga
                    teknisi terlatih dengan dukungan peralatan presisi dari merek terkemuka seperti
                    Zwick Roell.
                </p>

                <div class="about-stats">
                    <div class="about-stat">
                        <strong>8+</strong>
                        <span>Jenis Pengujian</span>
                    </div>
                    <div class="about-stat">
                        <strong>20 kN</strong>
                        <span>Kapasitas UTM</span>
                    </div>
                    <div class="about-stat">
                        <strong>ASTM & ISO</strong>
                        <span>Standar Pengujian</span>
                    </div>
                    <div class="about-stat">
                        <strong>Plastik & Komposit</strong>
                        <span>Material Utama</span>
                    </div>
                </div>
            </div>

            <div class="animate-in delay-2" style="background:var(--page-bg);border:1px solid var(--border);border-radius:16px;padding:32px;">
                <div class="section-label" style="margin-bottom:16px;">
                    <i class="ti ti-target"></i>
                    Visi & Misi Lab
                </div>
                <div style="margin-bottom:20px;">
                    <h3 style="font-size:14px;font-weight:600;color:var(--text-primary);margin:0 0 8px;">Visi</h3>
                    <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;margin:0;">
                        Menjadi laboratorium pengujian material plastik dan komposit terpercaya yang mendukung
                        riset terapan, pendidikan vokasi berkualitas, serta kebutuhan industri manufaktur.
                    </p>
                </div>
                <div style="border-top:1px solid var(--divider);padding-top:20px;">
                    <h3 style="font-size:14px;font-weight:600;color:var(--text-primary);margin:0 0 12px;">Misi</h3>
                    <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                            <i class="ti ti-check" style="color:var(--orange-primary);margin-top:2px;flex-shrink:0;"></i>
                            Menyediakan hasil pengujian material yang akurat berdasarkan standar ASTM, ISO, DIN, dan JIS
                        </li>
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                            <i class="ti ti-check" style="color:var(--orange-primary);margin-top:2px;flex-shrink:0;"></i>
                            Mendukung kegiatan belajar dan penelitian mahasiswa Prodi Perancangan Manufaktur
                        </li>
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                            <i class="ti ti-check" style="color:var(--orange-primary);margin-top:2px;flex-shrink:0;"></i>
                            Melayani kebutuhan pengujian material industri secara profesional dan tepat waktu
                        </li>
                        <li style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                            <i class="ti ti-check" style="color:var(--orange-primary);margin-top:2px;flex-shrink:0;"></i>
                            Terus memperbarui peralatan dan kompetensi teknisi sesuai perkembangan teknologi material
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Keunggulan -->
<section class="section" style="background:var(--page-bg);">
    <div class="section-inner">
        <div style="text-align:center;margin-bottom:0;">
            <div class="section-label" style="justify-content:center;">
                <i class="ti ti-heart"></i>
                Keunggulan
            </div>
            <h2 class="section-title">Yang Membuat Kami Berbeda</h2>
        </div>

        <div class="values-grid">
            <div class="value-card animate-in">
                <div class="value-icon"><i class="ti ti-shield-check"></i></div>
                <h3>Standar Internasional</h3>
                <p>Setiap pengujian mengacu pada standar ASTM, ISO, DIN, dan JIS yang diakui secara internasional untuk memastikan validitas hasil.</p>
            </div>
            <div class="value-card animate-in delay-1">
                <div class="value-icon"><i class="ti ti-tool"></i></div>
                <h3>Peralatan Presisi</h3>
                <p>Didukung mesin dari Zwick Roell — merek terkemuka dunia — termasuk UTM 20kN, Impact Tester HIT 5.5P, dan Melt Flow Indexer MFLOW.</p>
            </div>
            <div class="value-card animate-in delay-2">
                <div class="value-icon"><i class="ti ti-clock-bolt"></i></div>
                <h3>Hasil Tepat Waktu</h3>
                <p>Proses pengujian yang terstruktur dan tenaga teknisi berpengalaman memastikan laporan hasil uji dapat diselesaikan sesuai jadwal.</p>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Pengujian -->
<section class="section" style="background:var(--white);">
    <div class="section-inner">
        <div style="text-align:center;margin-bottom:0;">
            <div class="section-label" style="justify-content:center;">
                <i class="ti ti-flask"></i>
                Fasilitas Pengujian
            </div>
            <h2 class="section-title">Mesin & Jenis Pengujian</h2>
        </div>

        <div class="equipment-grid">

            <div class="equipment-card animate-in">
                <div class="equipment-icon"><i class="ti ti-arrows-move-vertical"></i></div>
                <h3>Tensile & Flexural Test</h3>
                <p>Universal Testing Machine 20kN untuk mengukur kekuatan tarik dan kekuatan lentur material plastik dan komposit.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ISO 527-2</span>
                    <span class="standard-badge">ASTM D638</span>
                    <span class="standard-badge">ASTM D790</span>
                    <span class="standard-badge">ISO 178</span>
                </div>
            </div>

            <div class="equipment-card animate-in delay-1">
                <div class="equipment-icon"><i class="ti ti-bolt"></i></div>
                <h3>Impact Test</h3>
                <p>Zwick HIT 5.5P untuk uji Charpy dan Izod — mengukur kemampuan material menyerap energi saat mengalami benturan mendadak.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ISO 179</span>
                    <span class="standard-badge">ASTM D6110</span>
                    <span class="standard-badge">ISO 180</span>
                    <span class="standard-badge">ASTM D256</span>
                </div>
            </div>

            <div class="equipment-card animate-in delay-2">
                <div class="equipment-icon"><i class="ti ti-circles-relation"></i></div>
                <h3>Hardness Test</h3>
                <p>Rockwell Hardness Testing Machine ZHR 8150 untuk mengukur kekerasan material logam berdasarkan kedalaman penetrasi indentor.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ASTM E18</span>
                    <span class="standard-badge">ISO 6508</span>
                </div>
            </div>

            <div class="equipment-card animate-in">
                <div class="equipment-icon"><i class="ti ti-temperature"></i></div>
                <h3>HDT / Vicat Test</h3>
                <p>Mengukur Heat Deflection Temperature dan Vicat Softening Temperature — titik di mana plastik mulai melunak atau melengkung akibat panas.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ISO 75-1</span>
                    <span class="standard-badge">ASTM D648</span>
                    <span class="standard-badge">ASTM D790</span>
                    <span class="standard-badge">ISO 178</span>
                </div>
            </div>

            <div class="equipment-card animate-in delay-1">
                <div class="equipment-icon"><i class="ti ti-droplets"></i></div>
                <h3>Moisture Test</h3>
                <p>Metode Loss on Drying (LOD) untuk mengukur kadar air dalam bahan plastik, resin, dan polimer guna memastikan kualitas bahan baku sebelum diproses.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ASTM D6980</span>
                    <span class="standard-badge">ISO 15512</span>
                </div>
            </div>

            <div class="equipment-card animate-in delay-2">
                <div class="equipment-icon"><i class="ti ti-flame"></i></div>
                <h3>Film Shrinkage Test</h3>
                <p>Mengukur kemampuan film plastik atau polimer untuk menyusut saat terkena panas — krusial untuk industri kemasan dan pembungkus termal.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ASTM D2732</span>
                    <span class="standard-badge">ISO 11501</span>
                    <span class="standard-badge">DIN 53369</span>
                    <span class="standard-badge">JIS K6767</span>
                </div>
            </div>

            <div class="equipment-card animate-in">
                <div class="equipment-icon"><i class="ti ti-weight"></i></div>
                <h3>Density Test</h3>
                <p>ViBRA DME-220HE menggunakan Underwater Replacement Method untuk mengukur densitas material karet dan plastik secara presisi.</p>
                <div class="standard-badges">
                    <span class="standard-badge">JIS Z8807</span>
                </div>
            </div>

            <div class="equipment-card animate-in delay-1">
                <div class="equipment-icon"><i class="ti ti-ripple"></i></div>
                <h3>Melt Flow Index Test</h3>
                <p>Zwick MFLOW untuk mengukur MFR dan MVR material termoplastik — menentukan sifat aliran saat leleh, penting untuk proses injection molding dan ekstrusi.</p>
                <div class="standard-badges">
                    <span class="standard-badge">ISO 1133</span>
                    <span class="standard-badge">ASTM D1238</span>
                </div>
            </div>

            <div class="equipment-card animate-in delay-2" style="background:var(--orange-light);border-color:var(--orange-border);">
                <div class="equipment-icon" style="background:var(--white);"><i class="ti ti-plus" style="color:var(--orange-primary);"></i></div>
                <h3 style="color:var(--text-primary);">Layanan Lainnya</h3>
                <p style="color:#92400E;">Butuh pengujian di luar daftar di atas? Hubungi kami untuk konsultasi dan penawaran layanan pengujian khusus sesuai kebutuhan industri Anda.</p>
                <a href="{{ url('/kontak') }}"
                   style="display:inline-flex;align-items:center;gap:6px;font-size:12.5px;font-weight:600;color:var(--orange-primary);text-decoration:none;margin-top:4px;">
                    Hubungi Kami <i class="ti ti-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="section" style="background:var(--page-bg);" id="testimoni">
    <div class="section-inner">
        <div style="text-align:center;">
            <div class="section-label" style="justify-content:center;">
                <i class="ti ti-message-circle"></i>
                Testimoni Klien
            </div>
            <h2 class="section-title">Dipercaya Berbagai Industri</h2>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card animate-in">
                <div class="testimonial-stars">
                    <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i>
                </div>
                <blockquote>
                    "Hasil uji tarik dan lentur sangat detail dengan referensi standar ISO yang jelas. Laporan membantu kami melakukan seleksi material plastik untuk komponen otomotif dengan lebih percaya diri."
                </blockquote>
                <div class="testimonial-author">
                    <div class="author-avatar">HS</div>
                    <div>
                        <div class="author-name">Hendra Susanto</div>
                        <div class="author-role">QC Engineer — PT Astra Otoparts</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card animate-in delay-1">
                <div class="testimonial-stars">
                    <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i>
                </div>
                <blockquote>
                    "Uji MFI dan moisture test bahan baku kami diselesaikan cepat dan akurat. Teknisi laboratorium sangat responsif dalam menjelaskan hasil dan rekomendasi prosesnya."
                </blockquote>
                <div class="testimonial-author">
                    <div class="author-avatar">RP</div>
                    <div>
                        <div class="author-name">Ratna Pertiwi</div>
                        <div class="author-role">R&D Manager — PT Supernova Flexible Packaging</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card animate-in delay-2">
                <div class="testimonial-stars">
                    <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-filled"></i><i class="ti ti-star-filled"></i>
                    <i class="ti ti-star-half-filled"></i>
                </div>
                <blockquote>
                    "Pengujian impact Charpy dan HDT untuk material komposit kami berjalan profesional. Peralatan Zwick yang digunakan memberikan kepercayaan penuh terhadap validitas data."
                </blockquote>
                <div class="testimonial-author">
                    <div class="author-avatar">DW</div>
                    <div>
                        <div class="author-name">Dwi Wicaksono</div>
                        <div class="author-role">Product Development — PT Chandra Asri Petrochemical</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection