<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#E67E22] transition']) }}>
    {{ $slot }}
</button>
