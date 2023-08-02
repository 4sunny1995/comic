import axios from 'axios'

export default axios.create({
  headers: {
    // Authorization: `Bear ${import.meta.env.VITE_APP_TOKEN}`
  },
  baseURL: import.meta.env.VITE_API_URL,
  params: {
    // page: 1,
  }
})
