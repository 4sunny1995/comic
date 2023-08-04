<template>
  <v-card height="100%">
    <v-card-text>
      <v-img :src="item.thumb ? imgURL(item.thumb) : ''" class="ma-2" :lazy-src="defaultImage" />
    </v-card-text>
    <v-card-title :title="item.title">
      <router-link :to="`/mangas/${item.id}`">{{ item.title }}</router-link>
    </v-card-title>
    <v-card-text>
      <v-label :title="item.summary">{{ item.summary }}</v-label>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
import { type MangaInterface as MangaItem } from '@/instances/manga.js'
import { computed } from 'vue'
import { imgURL } from '@/common/index.js'
import defaultImage from '@/assets/imgs/loading-buffering.gif'

const props = defineProps({
  manga: {
    type: Object as () => MangaItem,
    required: true
  }
})

// const { imgURL } = common
const item = computed<MangaItem>(() => props.manga)
</script>

<style scoped></style>
