import type { Pagination } from './response.js'

export interface MangaInterface {
  id?: number
  manga_id?: string
  title: string | null
  sub_title: string | null
  status: string | null
  thumb: string | null
  summary: string | null
  nsfw: string | null
  active: string | null
  type: string | null
  genres: string | null
  authors: string | null
}

export interface MangaResponse extends Pagination<MangaInterface> {}
