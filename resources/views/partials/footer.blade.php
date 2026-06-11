<footer class="footer">

    <div class="footer-main">

        <!-- Brand -->
        <div class="footer-brand">
            <a href="{{ url('/') }}" class="nav-logo">
                <div class="nav-logo-icon">
                    <img src="{{ asset('logopoltek.png') }}" alt="Logo Poltek" class="nav-logo-image">
                </div>
                <span class="nav-logo-text">PM-PUTP</span>
            </a>
            <p>
                Pusat Unggulan Teknologi Plastik Politeknik ATMI Surakarta menyediakan layanan pengujian spesimen, 
                analisis produk, dan pengembangan material untuk kebutuhan industri dan riset.
            </p>
            {{-- <div class="footer-badges">
                <span class="footer-badge">
                    <i class="ti ti-shield-check" aria-hidden="true"></i>
                    SNI ISO 17025
                </span>
                <span class="footer-badge">
                    <i class="ti ti-certificate" aria-hidden="true"></i>
                    KAN Terakreditasi
                </span>
            </div> --}}
        </div>

        <!-- Perusahaan -->
        <div class="footer-col">
            <h4>Perusahaan</h4>
            <ul>
                <li><a href="{{ route('landing') }}">Beranda</a></li>
                <li><a href="{{ route('layanan') }}">Layanan</a></li>
                <li><a href="{{ route('tentang') }}">Tentang Kami</a></li>
                <li><a href="{{ route('kontak') }}">Kontak</a></li>
                <li><a href="{{ route('user-orders.index') }}">Pesanan Saya</a></li>
            </ul>
        </div>

        <!-- Kontak -->
        <div class="footer-col">
            <h4>Hubungi Kami</h4>
            <ul>
                <li>
                    <a href="tel:+622112345678" style="display:flex;align-items:center;gap:6px;">
                        <i class="ti ti-phone" style="color:var(--orange-accent)" aria-hidden="true"></i>
                        +62 271-714466
                    </a>
                </li>
                <li>
                    <a href="mailto:pm@atmi.ac.id" style="display:flex;align-items:center;gap:6px;">
                        <i class="ti ti-mail" style="color:var(--orange-accent)" aria-hidden="true"></i>
                        pm@atmi.ac.id
                    </a>
                </li>
                <li>
                    <a href="{{ route('kontak') }}" style="display:flex;align-items:flex-start;gap:6px;">
                        <i class="ti ti-map-pin" style="color:var(--orange-accent);margin-top:1px" aria-hidden="true"></i>
                        Jl. Adisucipto (Mojo) No. 01, Karangasem, Laweyan, Surakarta 57145
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <!-- Bottom bar -->
    <div style="border-top:1px solid var(--divider)">
        <div class="footer-bottom">
            <p>© {{ date('Y') }} PM-PUTP - IT YKBS. Hak cipta dilindungi undang-undang.</p>
            <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                <a href="#" style="font-size:12px;color:var(--text-muted);text-decoration:none;">Kebijakan Privasi</a>
                <a href="#" style="font-size:12px;color:var(--text-muted);text-decoration:none;">Syarat & Ketentuan</a>
                <div class="footer-socials">
                    <a href="#" class="social-btn" aria-label="Instagram">
                        <i class="ti ti-brand-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="#" class="social-btn" aria-label="YouTube">
                        <i class="ti ti-brand-youtube" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</footer>