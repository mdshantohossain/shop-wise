"use client";

import React, { PropsWithChildren, useEffect, useState } from "react";

import {
  ArrowUpRight,
  Banknote,
  Bell,
  Bookmark,
  Calculator,
  CircleCheck,
  CircleX,
  Clock,
  Layers,
  LayoutDashboard,
  List,
  MessageSquareText,
  Package,
  RefreshCw,
  Settings,
  ShoppingBag,
  Star,
  Tags,
  TrendingUp,
  Truck,
  Users,
  Wallet,
  X,
} from "lucide-react";

import { Button } from "@/components/ui/button";
import SidebarItem from "@/features/seller/components/SidebarItem";
import Notification from "@/features/seller/components/Notification";
import SidebarFooter from "@/features/seller/components/SidebarFooter";
import { sellerDrawerItems } from "@/constants";



export default function SellerLayout({ children }: PropsWithChildren) {
  const [expandedMenus, setExpandedMenus] = useState("");
  const [mobileSidebarOpen, setMobileSidebarOpen] = useState(false);

  const toggleMenu = (key: string) => {
    console.log(key);
    setExpandedMenus((current) => (current === key ? "" : key));
  };

  // Prevent the page behind the mobile sidebar from scrolling.
  useEffect(() => {
    if (mobileSidebarOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }

    return () => {
      document.body.style.overflow = "";
    };
  }, [mobileSidebarOpen]);

  return (
    <div className="min-h-screen bg-muted/30">
      {/* Mobile overlay */}
      {mobileSidebarOpen && (
        <button
          type="button"
          aria-label="Close sidebar"
          onClick={() => setMobileSidebarOpen(false)}
          className="fixed inset-0 z-40 bg-black/40 lg:hidden"
        />
      )}

      {/* Sidebar */}
      <aside
        className={`
    fixed inset-y-0 left-0 z-50
    grid h-dvh w-72
    grid-rows-[auto_minmax(0,1fr)_auto]
    border-r bg-background
    transition-transform duration-200
    lg:translate-x-0
    ${mobileSidebarOpen ? "translate-x-0" : "-translate-x-full"}
  `}>
        {/* Header */}
        <div className="flex h-16 items-center justify-between border-b px-5">
          <div>
            <h1 className="text-lg font-bold tracking-tight">Shop Wise</h1>

            <p className="text-xs text-muted-foreground">Seller Center</p>
          </div>

          <Button
            variant="ghost"
            size="icon"
            className="lg:hidden"
            onClick={() => setMobileSidebarOpen(false)}>
            <X className="h-5 w-5" />
          </Button>
        </div>

        {/* Navigation - ONLY SCROLLABLE AREA */}
        <nav className="min-h-0 overflow-y-auto p-4">
          <div className="space-y-1">
            {sellerDrawerItems.map((item) => (
              <SidebarItem
                key={item.key}
                item={item}
                expanded={expandedMenus === item.key}
                onToggle={() => toggleMenu(item.key)}
              />
            ))}
          </div>
        </nav>

        {/* Footer - NEVER SCROLLS */}
        <div className="border-t bg-background">
          <SidebarFooter />
        </div>
      </aside>

      {/* Main */}
      <div className="lg:pl-72">
        {/* Header */}
        <header className="sticky top-0 z-30 flex h-16 items-center justify-between border-b bg-background/95 px-4 backdrop-blur md:px-6">
          <div className="flex items-center gap-3">
            <Button
              variant="ghost"
              size="icon"
              className="lg:hidden"
              onClick={() => setMobileSidebarOpen(true)}>
              <List className="h-5 w-5" />
            </Button>

            <h2 className="text-lg font-semibold">Dashboard</h2>
          </div>

          <Notification />
        </header>

        <main className="p-4 md:p-6 lg:p-8">{children}</main>
      </div>
    </div>
  );
}
