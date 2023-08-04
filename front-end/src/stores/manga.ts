import type { MangaInterface, MangaResponse } from '@/instances/manga.js'
import manga from '@/services/manga.js'
import { defineStore } from 'pinia'
import qs from 'qs'

export const useMangaStore = defineStore('manga', {
  state() {
    return {
      data: {} as MangaResponse
    }
  },
  getters: {
    mangas(): Array<MangaInterface> {
      return this.data.data
    },
    pagination(): MangaResponse {
      return this.data
    }
  },
  actions: {
    fetchManga(params: Object | null) {
      const paramString = qs.stringify(params)

      manga.fetchAll(paramString).then((res) => {
        this.data = res.data
      })
    }
  }
})
