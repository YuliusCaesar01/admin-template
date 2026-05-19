<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 rounded-xl bg-[#1e3a5f] px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#16304f] transition']) }}>
    {{ $slot }}
</button>
