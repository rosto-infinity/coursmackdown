
<template>
  <div class="flex">
    <!-- Sommaire latéral -->
    <aside class="hidden md:block w-64 min-h-screen border-r border-slate-200 bg-slate-50 px-4 py-8 sticky top-0">
      <h2 class="text-lg font-bold mb-4">Sommaire</h2>
      <ul class="space-y-2">
        <li v-for="c in cours" :key="c.slug">
          <Link
            :href="route('cours.show', c.slug)"
            class="block px-3 py-2 rounded hover:bg-slate-200"
            :class="c.slug.toLowerCase() === titre.toLowerCase() ? 'bg-slate-300 font-bold' : ''"
          >
            {{ c.titre }}
          </Link>
        </li>
      </ul>
    </aside>
    <!-- Contenu du cours -->
    <main class="flex-1 max-w-3xl mx-auto py-8 px-4">
      <h1 class="text-3xl font-bold mb-6">{{ titre }}</h1>
      <MarkdownRenderer :contenu="contenu" />
    </main>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import MarkdownRenderer from '../../components/MarkdownRenderer.vue';
defineProps<{ titre: string; contenu: string; cours: { slug: string; titre: string }[] }>()
</script>
