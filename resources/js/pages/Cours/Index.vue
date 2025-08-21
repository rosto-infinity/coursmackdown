<template>
  <div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Liste des cours</h1>
    <ul class="space-y-2">
      <li v-for="c in cours" :key="c.slug">
        <Link
          :href="route('cours.show', c.slug)" prefetch
          class="block px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded"
        >
          {{ c.titre }}
        </Link>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{ cours: { slug: string; titre: string }[] }>()
</script>
