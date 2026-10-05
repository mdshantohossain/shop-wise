import Footer from "@/layouts/Footer";
import Header from "@/layouts/Header";
import React, { PropsWithChildren } from "react";

export default function ShopLayout({ children }: PropsWithChildren) {
  return (
    <div>
      <Header />
      <main className="flex-1">{children}</main>
      <Footer />
    </div>
  );
}
