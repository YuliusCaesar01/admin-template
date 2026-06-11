@extends('layouts.landing')

@section('title', 'Keranjang Pengujian')
@section('meta_description', 'Tinjau dan kelola paket pengujian yang ingin Anda ajukan.')

@push('styles')
<style>
    .cart-wrapper {
        min-height: calc(100vh - 62px);
        background: var(--page-bg);
    }

    .cart-inner {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 24px 64px;
    }

    .cart-header {
        margin-bottom: 28px;
    }

    .cart-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .cart-header p {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 0;
    }

    /* ── Layout dua kolom ── */
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start;
    }

    /* ── Cart Items ── */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .cart-item {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: border-color 0.15s;
    }

    .cart-item:hover {
        border-color: var(--orange-border);
    }

    .cart-item-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .cart-item-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cart-item-price {
        font-size: 12px;
        color: var(--text-secondary);
        margin: 0;
    }

    /* ── Qty Control ── */
    .qty-control {
        display: flex;
        align-items: center;
        gap: 0;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--page-bg);
        border: none;
        cursor: pointer;
        color: var(--text-secondary);
        font-size: 16px;
        transition: background 0.15s, color 0.15s;
    }

    .qty-btn:hover {
        background: var(--orange-light);
        color: var(--orange-primary);
    }

    .qty-input {
        width: 40px;
        height: 32px;
        border: none;
        border-left: 1px solid var(--border);
        border-right: 1px solid var(--border);
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        background: var(--white);
        -moz-appearance: textfield;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }

    .cart-item-subtotal {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-primary);
        min-width: 90px;
        text-align: right;
        flex-shrink: 0;
    }

    .btn-remove {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid var(--border);
        border-radius: 7px;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 14px;
        transition: all 0.15s;
        flex-shrink: 0;
    }

    .btn-remove:hover {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #EF4444;
    }

    /* ── Summary Card ── */
    .cart-summary {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
        position: sticky;
        top: 80px;
    }

    .cart-summary h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 16px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: var(--text-secondary);
        margin-bottom: 10px;
    }

    .summary-row.total {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        border-top: 1px solid var(--border);
        padding-top: 12px;
        margin-top: 4px;
    }

    .summary-row.total span:last-child {
        color: var(--orange-primary);
    }

    .btn-checkout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 12px;
        background: var(--orange-primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
        margin-top: 16px;
    }

    .btn-checkout:hover { background: #C2410C; color: #fff; }
    .btn-checkout:disabled {
        background: var(--border);
        color: var(--text-muted);
        cursor: not-allowed;
    }

    .btn-clear {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 9px;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s;
        margin-top: 8px;
    }

    .btn-clear:hover {
        background: #FEF2F2;
        border-color: #FECACA;
        color: #EF4444;
    }

    /* ── Login notice ── */
    .login-notice {
        background: #FFF7ED;
        border: 1px solid #FED7AA;
        border-radius: 10px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        font-size: 12.5px;
        color: #92400E;
    }

    .login-notice i { font-size: 16px; flex-shrink: 0; }

    .login-notice a {
        color: var(--orange-primary);
        font-weight: 600;
        text-decoration: none;
    }

    /* ── Empty ── */
    .cart-empty {
        text-align: center;
        padding: 64px 24px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
    }

    .cart-empty-icon { font-size: 42px; color: var(--text-muted); margin-bottom: 16px; }
    .cart-empty h3 { font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0 0 6px; }
    .cart-empty p  { font-size: 13px; color: var(--text-secondary); margin: 0 0 24px; }

    .btn-browse {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: var(--orange-primary);
        color: #fff;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s;
    }

    .btn-browse:hover { background: #C2410C; color: #fff; }

    /* ── Alert ── */
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
    .alert-error   { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

    @media (max-width: 700px) {
        .cart-layout { grid-template-columns: 1fr; }
        .cart-summary { position: static; }
        .cart-item { flex-wrap: wrap; }
        .cart-item-subtotal { min-width: auto; }
    }
</style>
@endpush

@section('content')
<div class="cart-wrapper">
<div class="cart-inner">

    <div class="cart-header animate-in">
        <h1>Keranjang Pengujian</h1>
        <p>Tinjau paket yang dipilih sebelum mengajukan pesanan.</p>
    </div>

    {{-- Alert --}}
    @if (session('cart_success'))
    <div class="alert alert-success animate-in">
        <i class="ti ti-circle-check" aria-hidden="true"></i>
        {{ session('cart_success') }}
    </div>
    @endif

    @if (session('cart_error'))
    <div class="alert alert-error animate-in">
        <i class="ti ti-alert-circle" aria-hidden="true"></i>
        {{ session('cart_error') }}
    </div>
    @endif

    @if (empty($cart))
    {{-- ── Empty State ── --}}
    <div class="cart-empty animate-in">
        <div class="cart-empty-icon"><i class="ti ti-shopping-cart-off" aria-hidden="true"></i></div>
        <h3>Keranjang Masih Kosong</h3>
        <p>Belum ada paket pengujian yang dipilih. Lihat layanan kami dan tambahkan paket yang Anda butuhkan.</p>
        <a href="{{ route('layanan') }}" class="btn-browse">
            <i class="ti ti-test-pipe" aria-hidden="true"></i>
            Lihat Paket Pengujian
        </a>
    </div>

    @else
    {{-- ── Cart Content ── --}}
    <div class="cart-layout animate-in">

        {{-- Kiri: daftar item --}}
        <div class="cart-items">
            @foreach ($cart as $item)
            <div class="cart-item">
                <div class="cart-item-icon">
                    <i class="ti ti-test-pipe" aria-hidden="true"></i>
                </div>

                <div class="cart-item-info">
                    <p class="cart-item-name">{{ $item['name'] }}</p>
                    <p class="cart-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }} / item</p>
                </div>

                {{-- Qty control (update otomatis saat berubah) --}}
                <form method="POST" action="{{ route('cart.update') }}" class="qty-form">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $item['id'] }}">
                    <div class="qty-control">
                        <button type="button" class="qty-btn qty-minus" aria-label="Kurangi">−</button>
                        <input
                            type="number"
                            name="qty"
                            class="qty-input"
                            value="{{ $item['qty'] }}"
                            min="1"
                            max="99"
                        >
                        <button type="button" class="qty-btn qty-plus" aria-label="Tambah">+</button>
                    </div>
                </form>

                <div class="cart-item-subtotal">
                    Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                </div>

                {{-- Hapus item --}}
                <form method="POST" action="{{ route('cart.remove') }}">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $item['id'] }}">
                    <button type="submit" class="btn-remove" aria-label="Hapus item">
                        <i class="ti ti-trash" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        {{-- Kanan: ringkasan & checkout --}}
        <div class="cart-summary">
            <h3>Ringkasan Pesanan</h3>

            @foreach ($cart as $item)
            <div class="summary-row">
                <span>{{ $item['name'] }} ×{{ $item['qty'] }}</span>
            </div>
            @endforeach


            {{-- Peringatan jika belum login --}}
            @guest
            <div class="login-notice">
                <i class="ti ti-info-circle" aria-hidden="true"></i>
                <span>
                    <a href="{{ route('login') }}?redirect={{ urlencode(route('cart.checkout')) }}">Login</a>
                    atau
                    <a href="{{ route('register') }}">daftar</a>
                    untuk melanjutkan pesanan.
                </span>
            </div>
            @endguest

            {{-- Tombol checkout --}}
            @auth
            <form method="POST" action="{{ route('cart.checkout') }}">
                @csrf
                <button type="submit" class="btn-checkout">
                    <i class="ti ti-arrow-right" aria-hidden="true"></i>
                    Lanjut Isi Data Pesanan
                </button>
            </form>
            @else
            <a href="{{ route('login') }}?redirect={{ urlencode(route('cart.checkout')) }}" class="btn-checkout">
                <i class="ti ti-login" aria-hidden="true"></i>
                Login untuk Melanjutkan
            </a>
            @endauth

            {{-- Kosongkan keranjang --}}
            <form method="POST" action="{{ route('cart.clear') }}"
                  onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                @csrf
                <button type="submit" class="btn-clear">
                    <i class="ti ti-trash" aria-hidden="true"></i>
                    Kosongkan Keranjang
                </button>
            </form>
        </div>

    </div>
    @endif

</div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.cart-item').forEach(item => {
    const input  = item.querySelector('.qty-input');
    const form   = item.querySelector('.qty-form');
    const minus  = item.querySelector('.qty-minus');
    const plus   = item.querySelector('.qty-plus');
    const subtotal = item.querySelector('.cart-item-subtotal');
    const price  = parseFloat(item.querySelector('.cart-item-price').textContent.replace(/[^0-9]/g, ''));

    function updateSubtotal() {
        const qty = parseInt(input.value) || 1;
        subtotal.textContent = 'Rp ' + (price * qty).toLocaleString('id-ID');
    }

    minus.addEventListener('click', () => {
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            updateSubtotal();
        }
    });

    plus.addEventListener('click', () => {
        if (parseInt(input.value) < 99) {
            input.value = parseInt(input.value) + 1;
            updateSubtotal();
        }
    });

    input.addEventListener('change', () => {
        let val = parseInt(input.value);
        if (isNaN(val) || val < 1) val = 1;
        if (val > 99) val = 99;
        input.value = val;
        updateSubtotal();
    });

    // Auto-submit form saat qty berubah (debounce 600ms)
    let timer;
    input.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => form.submit(), 600);
    });
});
</script>
@endpush