import { Geist, Geist_Mono, Varela_Round } from "next/font/google";
import "./globals.css";
import { ToastContainer } from "react-toastify";
import { API_URL, APP_NAME } from "@/config/env";
import { AppProvider } from "@/providers/AppProvider";

const _geist = Geist({ subsets: ["latin"] });
const _geistMono = Geist_Mono({ subsets: ["latin"] });
const _varelaRound = Varela_Round({ weight: "400", subsets: ["latin"] });


export const generateMetadata = async (): Promise<{
  title: string;
  description: string;
}> => {
  const res = await fetch(`${API_URL}/app-info`);
  const { data: app } = await res.json();

  return {
    title: app?.name || `${APP_NAME}`,
    description:
      app?.description ||
      "Look Mart BD offers the best products in Electronics, Fashion, Home Appliances, and more. Official warranty & fast delivery.",
  };
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {



  return (
    <html lang="en">
      <head>
        <link rel="icon" href="./icon.png" sizes="32x32" />
      </head>
      <body className="font-sans antialiased">
        <AppProvider>
          <main className="flex-1">{children}</main>
          <ToastContainer position="bottom-left" />
        </AppProvider>
      </body>
    </html>
  );
}
