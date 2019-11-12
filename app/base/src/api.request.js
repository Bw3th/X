import HttpRequest from './axios'
const baseUrl = process.env.NODE_ENV === 'development' ? '/api' : "/"

const axios = new HttpRequest(baseUrl)
export default axios
