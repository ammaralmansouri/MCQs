import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
export default defineConfig({
  resolve: {
    alias: {
      '@': '/src', // This tells Vite that '@' maps to the 'src' directory
    },
  },
  plugins: [vue()],
})
