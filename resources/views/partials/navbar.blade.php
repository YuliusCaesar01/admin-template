<div class="nav-wrapper">
    <nav class="navbar" aria-label="Navigasi utama">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <img src="{{ asset('logopoltek.png') }}" alt="Logo Poltek" class="nav-logo-image">
            </div>
            <span class="nav-logo-text">PM-PUTP</span>
        </a>

        <!-- Links -->
        <ul class="nav-links" role="list">
            <li>
                <a href="{{ route('landing') }}"
                   class="{{ request()->routeIs('landing') ? 'active' : '' }}">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('layanan') }}"
                   class="{{ request()->routeIs('layanan') ? 'active' : '' }}">
                    Layanan
                </a>
            </li>
            <li>
                <a href="{{ route('tentang') }}"
                   class="{{ request()->routeIs('tentang') ? 'active' : '' }}">
                    Tentang Kami
                </a>
            </li>
            <li>
                <a href="{{ route('kontak') }}"
                   class="{{ request()->routeIs('kontak') ? 'active' : '' }}">
                    Kontak
                </a>
            </li>
            <li>
                <a href="{{ route('user-orders.index') }}"
                    class="{{ request()->routeIs('user-orders.*') ? 'active' : '' }}">
                        Pesanan Saya
                </a>
            </li>
        </ul>

        <!-- Actions -->
        <div class="nav-actions">
            @auth
                <div class="profile-dropdown">
                    <button class="profile-btn" id="profileToggle">
                        <div class="profile-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <i class="ti ti-chevron-down profile-arrow"></i>
                    </button>

                    <div class="profile-menu" id="profileMenu">
                        <div class="profile-header">
                            <strong>{{ auth()->user()->name }}</strong>
                            <small>{{ auth()->user()->email }}</small>
                        </div>

                        @can('dashboard.view')
                        <a href="{{ url('/dashboard') }}">
                            <i class="ti ti-layout-dashboard"></i>
                            Dashboard
                        </a>
                        @endcan

                        <a href="{{ route('profile.edit') }}">
                            <i class="ti ti-user"></i>
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">
                                <i class="ti ti-logout"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    <i class="ti ti-login"></i>
                    Login
                </a>
            @endauth

            <button class="nav-mobile-toggle"
                    id="mobileToggle"
                    aria-expanded="false"
                    aria-controls="mobileMenu">
                <i class="ti ti-menu-2" id="mobileToggleIcon"></i>
            </button>
        </div>

    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Menu mobile">
        <ul class="nav-links" role="list">
            <li>
                <a href="{{ route('layanan') }}"
                   class="{{ request()->routeIs('layanan') ? 'active' : '' }}">
                    Layanan
                </a>
            </li>
            <li>
                <a href="{{ route('tentang') }}"
                   class="{{ request()->routeIs('tentang') ? 'active' : '' }}">
                    Tentang Kami
                </a>
            </li>
            <li>
                <a href="{{ route('kontak') }}"
                   class="{{ request()->routeIs('kontak') ? 'active' : '' }}">
                    Kontak
                </a>
            </li>
            <li>
                <a href="{{ route('user-orders.index') }}"
                    class="{{ request()->routeIs('user-orders.*') ? 'active' : '' }}">
                        Pesanan Saya
                </a>
            </li>
        </ul>
        <div class="mobile-menu-actions">
            @auth
                @can('dashboard.view')
                <a href="{{ url('/dashboard') }}" class="btn-primary">
                    <i class="ti ti-layout-dashboard" aria-hidden="true"></i>
                    Dashboard
                </a>
                @endcan
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    <i class="ti ti-login" aria-hidden="true"></i>
                    Login
                </a>
            @endauth
        </div>
    </div>
</div>

<script>
    const toggle = document.getElementById('mobileToggle');
    const menu   = document.getElementById('mobileMenu');
    const icon   = document.getElementById('mobileToggleIcon');

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.toggle('open');
        toggle.setAttribute('aria-expanded', isOpen);
        icon.className = isOpen ? 'ti ti-x' : 'ti ti-menu-2';
    });

    menu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            menu.classList.remove('open');
            toggle.setAttribute('aria-expanded', false);
            icon.className = 'ti ti-menu-2';
        });
    });
</script>

<script>
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    if (profileToggle) {
        profileToggle.addEventListener('click', () => {
            profileMenu.classList.toggle('show');
        });

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.profile-dropdown')) {
                profileMenu.classList.remove('show');
            }
        });
    }
</script>