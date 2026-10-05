export interface Product {
  id: number;
  name: string;
  price: number;
  stock: number;
  status: "active" | "pending" | "rejected";
}

export interface ProductListResponse {
  data: Product[];
  meta: {
    current_page: number;
    last_page: number;
    total: number;
  };
}

export interface CreateProductInput {
  name: string;
  price: number;
  stock: number;
}