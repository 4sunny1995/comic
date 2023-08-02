import axios from '@/plugins/axios.js'
import { ROUTER_PATH } from '@/router/name.js'

const fetchAll = (params: string) => {
  return axios.get(`${ROUTER_PATH.FETCH_MANGA}?${params}`)
}

export default {
  fetchAll
}
