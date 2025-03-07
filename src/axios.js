// src/axios.js
import axios from 'axios';

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'; // Adjust if different
axios.defaults.headers.common['Accept'] = 'application/json';

axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;  
  },
  (error) => Promise.reject(error)
);

export default axios;
