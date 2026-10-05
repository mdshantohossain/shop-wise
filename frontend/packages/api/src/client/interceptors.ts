import { apiClient } from "./api-client";


apiClient.interceptors.request.use((config) => {
  const token = "YOUR_TOKEN";

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
});