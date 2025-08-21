<!-- resources/js/pages/Cours/Show.vue -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import MarkdownRenderer from '../../components/MarkdownRenderer.vue';
defineProps<{ titre: string; contenu: string; cours: { slug: string; titre: string }[] }>()

const showMenu = ref(false);
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>

<template>
  <div class="flex">
    <!-- Sommaire latéral desktop -->
    <aside class="hidden md:block w-64 min-h-screen border-r border-slate-200 bg-slate-50 px-4 py-8 sticky top-0">
      <h2 class="text-lg font-bold mb-4">Sommaire</h2>
      <ul class="space-y-2">
        <li v-for="c in cours" :key="c.slug">
          <Link
            :href="route('cours.show', c.slug)" prefetch
            class="block px-3 py-2 rounded hover:bg-slate-200"
            :class="c.slug.toLowerCase() === titre.toLowerCase() ? 'bg-slate-300 font-bold' : ''"
          >
            {{ c.titre }}
          </Link>
        </li>
      </ul>
    </aside>

    <!-- Bouton menu mobile -->
    <button @click="showMenu = true" class="md:hidden fixed top-4 left-4 z-30 bg-slate-800 text-white px-3 py-2 rounded shadow-lg">
      ☰ Sommaire
    </button>

    <!-- Drawer mobile -->
    <transition name="fade">
      <div v-if="showMenu" class="fixed inset-0 z-40 bg-black/40" @click.self="showMenu = false">
        <aside class="absolute left-0 top-0 h-full w-64 bg-slate-50 border-r border-slate-200 px-4 py-8 shadow-xl">
          <button @click="showMenu = false" class="absolute top-2 right-2 text-slate-500 hover:text-slate-800 text-xl">×</button>
          <h2 class="text-lg font-bold mb-4">Sommaire</h2>
          <ul class="space-y-2">
            <li v-for="c in cours" :key="c.slug">
              <Link
                :href="route('cours.show', c.slug)"
                class="block px-3 py-2 rounded hover:bg-slate-200"
                :class="c.slug.toLowerCase() === titre.toLowerCase() ? 'bg-slate-300 font-bold' : ''"
                @click="showMenu = false"
              >
                {{ c.titre }}
              </Link>
            </li>
          </ul>
        </aside>
      </div>
    </transition>

    <!-- Contenu du cours -->
    <main class="flex-1 max-w-5xl mx-auto py-8 px-4">
      <h1 class="text-3xl font-bold mb-6">{{ titre }}</h1>
      <MarkdownRenderer :contenu="contenu" />
    </main>
  </div>
</template>
