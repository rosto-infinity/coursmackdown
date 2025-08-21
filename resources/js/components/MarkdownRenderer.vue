
<template>
  <div v-html="html" class="prose prose-slate max-w-none prose-h1:text-4xl prose-h1:font-extrabold prose-h2:text-2xl prose-h2:font-bold prose-h3:text-xl prose-h3:font-semibold prose-p:leading-relaxed prose-p:text-lg prose-code:text-base prose-code:bg-slate-100 prose-code:rounded prose-code:px-1 prose-code:py-0.5 prose-pre:bg-slate-900 prose-pre:text-slate-100 prose-pre:rounded-lg prose-pre:p-4 prose-pre:overflow-x-auto prose-pre:relative" />
</template>


<script setup lang="ts">
import hljs from 'highlight.js';
import 'highlight.js/styles/github-dark.css';
import { marked, Renderer } from 'marked';
import { onMounted, ref, watch } from 'vue';


const props = defineProps<{ contenu: string }>()
const html = ref('')


// Configure marked to use highlight.js for code blocks (compatible v5+)
const renderer = new Renderer();
renderer.code = ({ text, lang }) => {
  let highlighted;
  if (lang && hljs.getLanguage(lang)) {
    highlighted = hljs.highlight(text, { language: lang }).value;
  } else {
    highlighted = hljs.highlightAuto(text).value;
  }
  return `<pre><code class=\"hljs language-${lang || ''}\">${highlighted}</code></pre>`;
};
marked.use({ renderer });

function addCopyButtons() {
  const blocks = document.querySelectorAll('.prose pre')
  blocks.forEach(block => {
    if (!block.querySelector('.copy-btn')) {
      const btn = document.createElement('button')
      btn.textContent = 'Copier'
  btn.className = 'copy-btn absolute right-3 top-3 px-3 py-1 text-xs font-semibold bg-slate-800 text-white rounded shadow hover:bg-slate-700 transition-all duration-150'
      btn.onclick = () => {
        const code = block.querySelector('code')?.innerText || ''
        navigator.clipboard.writeText(code)
        btn.textContent = 'Copié !'
        setTimeout(() => (btn.textContent = 'Copier'), 1200)
      }
      (block as HTMLElement).style.position = 'relative'
      block.appendChild(btn)
    }
  })
}


watch(() => props.contenu, async (val) => {
  const result = marked(val)
  html.value = typeof result === 'string' ? result : await result
  onMounted(() => setTimeout(addCopyButtons, 100))
})


onMounted(async () => {
  const result = marked(props.contenu)
  html.value = typeof result === 'string' ? result : await result
  setTimeout(addCopyButtons, 100)
})
</script>

<style scoped>

.copy-btn {
  position: absolute;
  right: 0.75rem;
  top: 0.75rem;
  z-index: 10;
  opacity: 0.8;
  cursor: pointer;
}
.copy-btn:hover {
  opacity: 1;
}
.prose pre {
  position: relative;
  background: #0f172a;
  color: #f1f5f9;
  border-radius: 0.75rem;
  padding: 1rem;
  font-size: 1rem;
  font-family: 'Fira Mono', 'Consolas', 'Menlo', monospace;
  box-shadow: 0 2px 8px 0 #0002;
}
.prose code {
  background: #f1f5f9;
  color: #334155;
  border-radius: 0.25rem;
  padding: 0.2em 0.4em;
  font-size: 1em;
  font-family: 'Fira Mono', 'Consolas', 'Menlo', monospace;
}
.prose h1 {
  margin-bottom: 1.5rem;
}
.prose h2 {
  margin-top: 2rem;
  margin-bottom: 1rem;
}
.prose h3 {
  margin-top: 1.5rem;
  margin-bottom: 0.75rem;
}
.prose p {
  margin-bottom: 1.25rem;
}
</style>
