export interface Link {
  active: boolean
  label: string
  url: string | null
}
export interface Pagination<T> {
  current_page: number
  data: Array<T>
  first_page_url: string
  from: number
  last_page: number
  last_page_url: string
  next_page_url: string | null
  path: string
  per_page: number
  prev_page_url: string | null
  to: number
  total: number
  links: Array<Link>
}
