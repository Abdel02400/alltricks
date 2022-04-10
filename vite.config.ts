import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  root: './assets',
  base: '/assets/',
  build: {
    manifest: true,
    assetsDir: '',
    outDir: '../public/build/',
    rollupOptions: {
      output: {
        // manualChunks: undefined
      },
      input: {
        'main.tsx': './assets/main.tsx'
      }
    }
  },
})
