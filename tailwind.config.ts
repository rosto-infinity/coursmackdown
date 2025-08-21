import typography from '@tailwindcss/typography'
import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
     "./resources/**/*.{vue,js,ts,jsx,tsx,md}",
  ],
  theme: {
    extend: {},
  },
  plugins: [typography],
}
export default config
