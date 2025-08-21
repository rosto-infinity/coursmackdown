<template>
  <div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">{{ titre }}</h1>
    <MarkdownRenderer :contenu="contenu" />
  </div>
</template>

<script setup lang="ts">
import MarkdownRenderer from '../../components/MarkdownRenderer.vue';
defineProps<{ titre: string; contenu: string }>()
</script>
