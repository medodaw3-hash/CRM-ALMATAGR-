/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        // Bilingual stack: Inter for Latin, IBM Plex Sans Arabic for Arabic.
        // Browsers pick the right font per character thanks to font fallback.
        sans:   ['Inter', 'IBM Plex Sans Arabic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        arabic: ['IBM Plex Sans Arabic', 'Inter', 'ui-sans-serif', 'sans-serif'],
        mono:   ['JetBrains Mono', 'ui-monospace', 'monospace'],
      },
      colors: {
        ink: {
          50:  '#f7f8f9',
          100: '#eef0f2',
          200: '#dde0e5',
          300: '#c2c7cf',
          400: '#9ba1ac',
          500: '#6b7280',
          600: '#4b5159',
          700: '#363a41',
          800: '#22252b',
          900: '#14161a',
          950: '#0b0c0f',
        },
        brand: {
          50:  '#eef4ff',
          100: '#dce8ff',
          500: '#3b6ef5',
          600: '#2c57db',
          700: '#1f43b3',
        },
      },
      boxShadow: {
        'soft': '0 1px 2px rgba(16,24,40,0.04), 0 1px 3px rgba(16,24,40,0.06)',
        'card': '0 1px 2px rgba(16,24,40,0.04), 0 4px 12px rgba(16,24,40,0.04)',
        'pop':  '0 8px 28px rgba(16,24,40,0.10), 0 2px 6px rgba(16,24,40,0.06)',
      },
      borderRadius: {
        'xl': '0.75rem',
        '2xl': '1rem',
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
