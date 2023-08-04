const imgURL = (path: string) => {
  return import.meta.env.VITE_IMG_PREFIX + path
}
export { imgURL }
