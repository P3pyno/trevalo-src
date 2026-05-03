import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

const isLaravel = process.env.LARAVEL === '1'

export default defineConfig(async () => {
  const plugins = [vue()]

  if (isLaravel) {
    const { default: laravel } = await import('laravel-vite-plugin')
    plugins.unshift(laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }))
  }

  return {
    plugins,
    css: {
      postcss: './postcss.config.js',
    },
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './resources/js'),
      },
    },
  }
})
