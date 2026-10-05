"use client";
import { AuthProvider } from "@/context/AuthModalContext";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { PropsWithChildren } from "react";
import { Provider } from "react-redux";
import { PersistGate } from "redux-persist/integration/react";
import { GoogleOAuthProvider } from "@react-oauth/google";
import { GOOGLE_CLIENT_ID } from "@/config/env";
import { persistor, store } from "@/features/store";

export const AppProvider = ({ children }: PropsWithChildren) => {
  const queryClient = new QueryClient();

  return (
    <AuthProvider>
      <Provider store={store}>
        <PersistGate loading={null} persistor={persistor}>
          <QueryClientProvider client={queryClient}>
            <GoogleOAuthProvider clientId={GOOGLE_CLIENT_ID!}>
              {children}
            </GoogleOAuthProvider>
          </QueryClientProvider>
        </PersistGate>
      </Provider>
    </AuthProvider>
  );
};
