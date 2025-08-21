<template>
  <div
    ref="container"
    class="prose prose-slate max-w-none prose-h1:text-4xl prose-h1:font-extrabold prose-h2:text-2xl prose-h2:font-bold prose-h3:text-xl prose-h3:font-semibold prose-p:leading-relaxed prose-p:text-lg prose-code:text-base prose-code:bg-slate-100 dark:prose-code:bg-slate-800 prose-code:rounded prose-code:px-1.5 prose-code:py-0.5 prose-pre:bg-slate-900 prose-pre:text-slate-100 prose-pre:rounded-lg prose-pre:p-4 prose-pre:overflow-x-auto prose-pre:relative"
    v-html="html"
  />
</template>

<script setup lang="ts">
import hljs from 'highlight.js'
import 'highlight.js/styles/github-dark.css'
import MarkdownIt from 'markdown-it'
import { ref, onMounted, watch } from 'vue'

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
      return `<pre><code class="hljs language-${lang}">` +
        hljs.highlight(str, { language: lang }).value +
        '</code></pre>'
    }
    return '<pre><code class="hljs">' + hljs.highlightAuto(str).value + '</code></pre>'
  }
})

// Fonction pour ajouter les boutons "Copier"
const addCopyButtons = () => {
  const blocks = container.value?.querySelectorAll('pre') || []
  blocks.forEach((block) => {
    if (block.querySelector('.copy-btn')) return
    const btn = document.createElement('button')
    btn.textContent = 'Copier'
    btn.className =
      'copy-btn absolute right-3 top-3 px-3 py-1 text-xs font-semibold bg-slate-800 text-white rounded shadow hover:bg-slate-700 active:scale-95 transition-all duration-150'
    btn.type = 'button'
    btn.onclick = () => {
      const code = block.querySelector('code')
      if (!code) return
      const codeText = code.textContent || ''
      navigator.clipboard.writeText(codeText).catch(console.error)
      btn.textContent = 'Copié !'
      setTimeout(() => {
        btn.textContent = 'Copier'
      }, 1200)
    }
    block.style.position = 'relative'
    block.appendChild(btn)
  })
}

// Fonction de rendu
const renderMarkdown = () => {
  if (!props.contenu) {
    html.value = ''
    return
  }
  html.value = md.render(props.contenu)
  setTimeout(addCopyButtons, 50)
}

onMounted(renderMarkdown)
watch(() => props.contenu, renderMarkdown)
</script>

<style scoped>
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
.prose pre {
  font-family: 'Fira Mono', 'Consolas', 'Menlo', monospace;
  font-size: 0.95rem;
  line-height: 1.5;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  overflow-x: auto;
  scrollbar-width: thin;
}
.prose code {
  font-size: 0.9em;
  padding: 0.2em 0.4em;
  border-radius: 0.375rem;
}
</style>