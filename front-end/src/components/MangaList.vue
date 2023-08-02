<template>
  <div>
    <v-card elevation="4">
      <v-card-title>Danh sách truyện</v-card-title>
    </v-card>
    <v-card-text>
      <v-row>
        <template v-for="(item, index) in mangas" :key="index">
          <v-col cols="12" md="3">
            <MangaItem :manga="item"></MangaItem>
          </v-col>
        </template>
      </v-row>
    </v-card-text>
  </div>
</template>

<script setup lang="ts">
import MangaItem from '@/components/items/MangaItem.vue'
import { type MangaInterface as Manga } from '../instances/manga.js'
import { ref } from 'vue'
import { onMounted } from 'vue'
import { useMangaStore } from '@/stores/manga.js'
import { computed } from 'vue'

// const mangas = ref<Manga[]>()
const mangaStore = useMangaStore()
const isLoading = ref(false)

const mangas = computed<Manga[]>(() => mangaStore.mangas)
const fetchMangas = (params: Object | null = null) => {
  isLoading.value = true
  mangaStore.fetchManga(params)
  isLoading.value = false
}

onMounted(() => {
  fetchMangas()
})
</script>

<style scoped></style>
