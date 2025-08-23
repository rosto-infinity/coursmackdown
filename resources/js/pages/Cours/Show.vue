<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import MarkdownRenderer from '../../components/MarkdownRenderer.vue';

defineProps<{
  titre: string;
  contenu: string;
  cours: { slug: string; titre: string }[];
}>()


</script>

<template>
  <div class="flex flex-col min-h-screen">
    <!-- === Barre de sommaire horizontale (défilable) === -->
    <nav class="bg-slate-50 border-b border-slate-200 sticky top-0 z-20">
      <!-- Conteneur défilable sur mobile -->
      <div class="flex overflow-x-auto scrollbar-hide sm:scrollbar-auto py-2 px-2 sm:px-4">
        <ul class="flex space-x-1 min-w-full sm:min-w-0">
          <li v-for="c in cours" :key="c.slug">
            <Link
              :href="route('cours.show', c.slug)"
              class="px-3 py-2 text-sm whitespace-nowrap rounded hover:bg-slate-200 transition-colors"
              :class="{
                'bg-emerald-600 text-white font-medium hover:bg-emerald-700': c.slug.toLowerCase() === titre.toLowerCase(),
                'text-slate-800 dark:text-slate-200': c.slug.toLowerCase() !== titre.toLowerCase()
              }"
            >
              {{ c.titre }}
            </Link>
          </li>
        </ul>
      </div>
      <AppearanceTabs  />
    </nav>

    <!-- === Contenu du cours === -->
    <main class="flex-1 max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
      <article>
        <header class="mb-8">
          <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ titre }}</h1>
          <p class="text-slate-600 dark:text-slate-400 mt-2">
            {{ cours.filter(c => c.slug.toLowerCase() === titre.toLowerCase())[0]?.titre || '' }}
          </p>
        </header>

        <section class="prose prose-slate max-w-none">
          <MarkdownRenderer :contenu="contenu" />
        </section>
      </article>
    </main>
  </div>
</template>

<style scoped>
/* Cacher la scrollbar sur mobile, mais garder le défilement */
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>