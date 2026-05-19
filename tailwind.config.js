import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['DM Sans', ...defaultTheme.fontFamily.sans],
            },
            transitionDuration: {
                '250': '250ms',
            },
            colors: {
                // Biru tua khusus (#1e3a5f) dipakai langsung via arbitrary value
                // slate & blue dari Tailwind default sudah cukup untuk tema terang
            },
            keyframes: {
                'fade-in-up': {
                    '0%':   { opacity: '0', transform: 'translateY(6px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.2s ease-out',
            },
        },
    },
    plugins: [
        forms,
        function({ addUtilities }) {
            addUtilities({
                '.scrollbar-hide': {
                    '-ms-overflow-style': 'none',
                    'scrollbar-width': 'none',
                    '&::-webkit-scrollbar': { display: 'none' },
                },
            })
        },
    ],
}
