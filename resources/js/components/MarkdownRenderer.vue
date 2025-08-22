<template>
  <div
    ref="container"
    class="prose prose-slate max-w-none"
    v-html="html"
  />
</template>

<script setup lang="ts">
import hljs from 'highlight.js'
import 'highlight.js/styles/github-dark.css'
import MarkdownIt from 'markdown-it'
import { onMounted, ref, watch } from 'vue'

// SVG pour "Copier" et "Copié"
const copySvg = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="9" y="9" width="13" height="13" rx="2"/><rect x="3" y="3" width="13" height="13" rx="2"/></svg>`
const checkSvg = `<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`

// Props
const props = defineProps<{ contenu: string }>()

const html = ref('')
const container = ref<HTMLElement | null>(null)

// Configuration markdown-it + highlight.js
const md = new MarkdownIt({
  html: false,
  linkify: true,
  typographer: true,
  highlight: (str: string, lang?: string): string => {
    if (lang && hljs.getLanguage(lang)) {
      return `<pre><code class="hljs language-${lang}">${hljs.highlight(str, { language: lang }).value}</code></pre>`
    }
    return `<pre><code class="hljs">${hljs.highlightAuto(str).value}</code></pre>`
  }
})

// Ajouter les boutons "Copier"
const addCopyButtons = () => {
  const blocks = container.value?.querySelectorAll('pre') || []
  blocks.forEach((block) => {
    if (block.querySelector('.copy-btn')) return

    const btn = document.createElement('button')
    btn.className = 'copy-btn flex items-center gap-2 absolute right-5 top-4 px-3 py-1 text-xs font-semibold bg-slate-700 text-white rounded shadow hover:bg-slate-700 active:scale-95 transition-all duration-150'
    btn.type = 'button'
    btn.innerHTML = `<span class="icon">${copySvg}</span> <span>Copier</span>`

    btn.onclick = () => {
      const code = block.querySelector('code')
      if (!code) return
      const codeText = code.textContent || ''
      navigator.clipboard.writeText(codeText).catch(console.error)

      const icon = btn.querySelector('.icon')
      const label = btn.querySelector('span:last-child')
      if (icon) icon.innerHTML = checkSvg
      if (label) label.textContent = 'Copié !'

      setTimeout(() => {
        if (icon) icon.innerHTML = copySvg
        if (label) label.textContent = 'Copier'
      }, 1200)
    }

    block.classList.add('relative')
    block.appendChild(btn)
  })
}

// Rendu du Markdown
const renderMarkdown = () => {
  if (!props.contenu) {
    html.value = ''
    return
  }
  html.value = md.render(props.contenu)
  // Attendre que le DOM soit mis à jour
  setTimeout(addCopyButtons, 50)
}

onMounted(renderMarkdown)
watch(() => props.contenu, renderMarkdown)
</script>

<style scoped>
.prose pre {
  background: transparent !important;
  border: none !important;
  box-shadow: none !important;
  border-radius: 8.5rem !important;
  padding: 1rem !important;
}
.copy-btn {
  opacity: 0.8;
  transition: opacity 0.2s ease, transform 0.1s ease;
}
.copy-btn:hover {
  opacity: 1;
}
.copy-btn:active {
  transform: scale(0.95);
}
</style>

