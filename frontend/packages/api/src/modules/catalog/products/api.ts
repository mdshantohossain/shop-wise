
import { apiClient } from "../../../client/api-client";
import {
  CreateProductInput,
  Product,
  ProductListResponse,
} from "./types";

export async function getProducts() {
  const response = await apiClient.get<ProductListResponse>(
    "/products"
  );

  return response.data;
}

export async function getProduct(id: number) {
  const response = await apiClient.get<Product>(
    `/products/${id}`
  );

  return response.data;
}

export async function createProduct(
  data: CreateProductInput
) {
  const response = await apiClient.post<Product>(
    "/products",
    data
  );

  return response.data;
}

export async function deleteProduct(id: number) {
  await apiClient.delete(`/products/${id}`);
}