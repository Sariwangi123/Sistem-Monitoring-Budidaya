import type { Config } from 'tailwindcss';

export default {
  content: ['./index.html', './src/**/*.{ts,tsx}'],
  theme: {
    extend: {
      colors: {
        brand: {
          DEFAULT: '#0f766e',
          dark: '#115e59',
          soft: '#ccfbf1',
        },
      },
    },
  },
  plugins: [],
} satisfies Config;
