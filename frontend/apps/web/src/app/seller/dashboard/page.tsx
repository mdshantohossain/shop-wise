"use client";

import React from "react";
import {
  Banknote,
  BadgeDollarSign,
  Bell,
  Clock,
  Layers,
  Package,
  PlusCircle,
  RefreshCw,
  ShoppingBag,
  TrendingUp,
  Users,
} from "lucide-react";

import { Button } from "@/components/ui/button";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";

import type { LucideIcon } from "lucide-react";

const stats = [
  {
    title: "Total Sales",
    value: "$24,680",
    change: "+12.5%",
    description: "vs. last month",
    icon: TrendingUp,
  },
  {
    title: "Total Orders",
    value: "1,248",
    change: "+8.2%",
    description: "vs. last month",
    icon: ShoppingBag,
  },
  {
    title: "Products",
    value: "384",
    change: "+24",
    description: "this month",
    icon: Package,
  },
  {
    title: "Customers",
    value: "8,492",
    change: "+18.4%",
    description: "vs. last month",
    icon: Users,
  },
];

const recentOrders = [
  {
    id: "#ORD-10482",
    customer: "Rahim Ahmed",
    date: "Sep 26, 2026",
    amount: "$245.00",
    status: "Delivered",
  },
  {
    id: "#ORD-10481",
    customer: "Nusrat Jahan",
    date: "Sep 26, 2026",
    amount: "$128.50",
    status: "Processing",
  },
  {
    id: "#ORD-10480",
    customer: "Tanvir Hasan",
    date: "Sep 25, 2026",
    amount: "$89.00",
    status: "Shipped",
  },
  {
    id: "#ORD-10479",
    customer: "Sadia Islam",
    date: "Sep 25, 2026",
    amount: "$320.00",
    status: "Pending",
  },
  {
    id: "#ORD-10478",
    customer: "Arif Hossain",
    date: "Sep 24, 2026",
    amount: "$74.50",
    status: "Delivered",
  },
];

const topProducts = [
  {
    name: "Premium Wireless Headphone",
    sales: 248,
    revenue: "$8,920",
  },
  {
    name: "Smart Watch Series 5",
    sales: 186,
    revenue: "$6,480",
  },
  {
    name: "Men's Casual T-Shirt",
    sales: 164,
    revenue: "$4,920",
  },
  {
    name: "Running Shoes",
    sales: 132,
    revenue: "$4,210",
  },
];

export default function SellerDashboardPage() {
  return (
    <section className="w-full min-w-0">
      {/* =========================
          Page Heading
      ========================== */}
      <div className="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div className="min-w-0">
          <h1 className="text-2xl font-bold tracking-tight">
            Good afternoon, Shanto 👋
          </h1>

          <p className="mt-1 text-sm text-muted-foreground">
            Here&apos;s what&apos;s happening with your store today.
          </p>
        </div>

        <Button className="shrink-0">
          <PlusCircle className="mr-2 h-4 w-4" />
          Add Product
        </Button>
      </div>

      {/* =========================
          Main Stats
      ========================== */}
      <div className="grid min-w-0 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        {stats.map((stat) => {
          const Icon = stat.icon;

          return (
            <Card key={stat.title} className="min-w-0">
              <CardContent className="p-5">
                <div className="flex items-start justify-between gap-4">
                  <div className="min-w-0">
                    <p className="text-sm text-muted-foreground">
                      {stat.title}
                    </p>

                    <p className="mt-2 truncate text-2xl font-bold">
                      {stat.value}
                    </p>
                  </div>

                  <div className="shrink-0 rounded-lg bg-primary/10 p-2.5">
                    <Icon className="h-5 w-5 text-primary" />
                  </div>
                </div>

                <div className="mt-4 flex flex-wrap items-center gap-2 text-xs">
                  <span className="flex items-center gap-1 font-medium text-green-600">
                    <TrendingUp className="h-3.5 w-3.5" />
                    {stat.change}
                  </span>

                  <span className="text-muted-foreground">
                    {stat.description}
                  </span>
                </div>
              </CardContent>
            </Card>
          );
        })}
      </div>

      {/* =========================
          Recent Orders + Top Products
      ========================== */}
      <div className="mt-6 grid min-w-0 gap-6 xl:grid-cols-3">
        {/* =====================
            Recent Orders
        ====================== */}
        <Card className="min-w-0 overflow-hidden xl:col-span-2">
          <CardHeader className="flex flex-row items-center justify-between gap-3">
            <div className="min-w-0">
              <CardTitle>Recent Orders</CardTitle>

              <p className="mt-1 text-sm text-muted-foreground">
                Latest orders from your customers
              </p>
            </div>

            <Button
              variant="outline"
              size="sm"
              className="shrink-0"
            >
              View all
            </Button>
          </CardHeader>

          <CardContent className="p-0">
            {/* =====================
                Desktop / Tablet
            ====================== */}
            <div className="hidden md:block">
              <div className="w-full overflow-x-auto">
                <table className="w-full text-sm">
                  <thead>
                    <tr className="border-b bg-muted/30 text-left text-xs text-muted-foreground">
                      <th className="whitespace-nowrap px-6 py-3 font-medium">
                        Order
                      </th>

                      <th className="whitespace-nowrap px-4 py-3 font-medium">
                        Customer
                      </th>

                      <th className="whitespace-nowrap px-4 py-3 font-medium">
                        Date
                      </th>

                      <th className="whitespace-nowrap px-4 py-3 font-medium">
                        Amount
                      </th>

                      <th className="whitespace-nowrap px-6 py-3 font-medium">
                        Status
                      </th>
                    </tr>
                  </thead>

                  <tbody>
                    {recentOrders.map((order) => (
                      <tr
                        key={order.id}
                        className="border-b last:border-0 hover:bg-muted/20"
                      >
                        <td className="whitespace-nowrap px-6 py-4 font-medium">
                          {order.id}
                        </td>

                        <td className="whitespace-nowrap px-4 py-4">
                          {order.customer}
                        </td>

                        <td className="whitespace-nowrap px-4 py-4 text-muted-foreground">
                          {order.date}
                        </td>

                        <td className="whitespace-nowrap px-4 py-4 font-medium">
                          {order.amount}
                        </td>

                        <td className="whitespace-nowrap px-6 py-4">
                          <OrderStatus status={order.status} />
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>

            {/* =====================
                Mobile
            ====================== */}
            <div className="space-y-3 p-4 md:hidden">
              {recentOrders.map((order) => (
                <MobileOrderCard
                  key={order.id}
                  order={order}
                />
              ))}
            </div>
          </CardContent>
        </Card>

        {/* =====================
            Top Products
        ====================== */}
        <Card className="min-w-0 overflow-hidden">
          <CardHeader>
            <CardTitle>Top Products</CardTitle>

            <p className="text-sm text-muted-foreground">
              Best performing products
            </p>
          </CardHeader>

          <CardContent className="space-y-5">
            {topProducts.map((product, index) => (
              <div
                key={product.name}
                className="flex min-w-0 items-center gap-3"
              >
                {/* Ranking */}
                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-muted text-sm font-semibold">
                  {index + 1}
                </div>

                {/* Product Info */}
                <div className="min-w-0 flex-1">
                  <p className="truncate text-sm font-medium">
                    {product.name}
                  </p>

                  <p className="mt-1 text-xs text-muted-foreground">
                    {product.sales} sales
                  </p>
                </div>

                {/* Revenue */}
                <div className="shrink-0 text-right">
                  <p className="text-sm font-semibold">
                    {product.revenue}
                  </p>

                  <p className="text-[11px] text-muted-foreground">
                    Revenue
                  </p>
                </div>
              </div>
            ))}
          </CardContent>
        </Card>
      </div>

      {/* =========================
          Bottom Quick Stats
      ========================== */}
      <div className="mt-6 grid min-w-0 gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <QuickStat
          title="Pending Products"
          value="18"
          icon={Clock}
          description="Waiting for approval"
        />

        <QuickStat
          title="Low Stock"
          value="12"
          icon={Layers}
          description="Products need restock"
        />

        <QuickStat
          title="Pending Orders"
          value="24"
          icon={RefreshCw}
          description="Need processing"
        />

        <QuickStat
          title="Available Balance"
          value="$12,480"
          icon={Banknote}
          description="Ready for withdrawal"
        />
      </div>
    </section>
  );
}

/* =========================================
   Order Status
========================================= */

function OrderStatus({ status }: { status: string }) {
  const statusConfig: Record<
    string,
    {
      label: string;
      className: string;
    }
  > = {
    Delivered: {
      label: "Delivered",
      className:
        "bg-green-100 text-green-700 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400",
    },

    Processing: {
      label: "Processing",
      className:
        "bg-blue-100 text-blue-700 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400",
    },

    Shipped: {
      label: "Shipped",
      className:
        "bg-purple-100 text-purple-700 hover:bg-purple-100 dark:bg-purple-900/30 dark:text-purple-400",
    },

    Pending: {
      label: "Pending",
      className:
        "bg-yellow-100 text-yellow-700 hover:bg-yellow-100 dark:bg-yellow-900/30 dark:text-yellow-400",
    },
  };

  const config = statusConfig[status] ?? {
    label: status,
    className: "",
  };

  return (
    <Badge
      variant="secondary"
      className={`border-0 ${config.className}`}
    >
      {config.label}
    </Badge>
  );
}

/* =========================================
   Quick Stat
========================================= */

function QuickStat({
  title,
  value,
  description,
  icon: Icon,
}: {
  title: string;
  value: string;
  description: string;
  icon: LucideIcon;
}) {
  return (
    <Card className="min-w-0">
      <CardContent className="flex items-center gap-4 p-5">
        <div className="shrink-0 rounded-lg bg-muted p-3">
          <Icon className="h-5 w-5" />
        </div>

        <div className="min-w-0">
          <p className="truncate text-sm text-muted-foreground">
            {title}
          </p>

          <p className="mt-1 text-xl font-bold">
            {value}
          </p>

          <p className="mt-1 truncate text-xs text-muted-foreground">
            {description}
          </p>
        </div>
      </CardContent>
    </Card>
  );
}

/* =========================================
   Mobile Order Card
========================================= */

function MobileOrderCard({
  order,
}: {
  order: {
    id: string;
    customer: string;
    date: string;
    amount: string;
    status: string;
  };
}) {
  return (
    <div className="rounded-lg border bg-background p-4">
      {/* Top */}
      <div className="flex items-start justify-between gap-3">
        <div className="min-w-0">
          <p className="text-sm font-semibold">
            {order.id}
          </p>

          <p className="mt-1 truncate text-sm text-muted-foreground">
            {order.customer}
          </p>
        </div>

        <div className="shrink-0">
          <OrderStatus status={order.status} />
        </div>
      </div>

      {/* Bottom */}
      <div className="mt-4 flex items-end justify-between gap-3 border-t pt-3">
        <div className="min-w-0">
          <p className="text-[11px] text-muted-foreground">
            Date
          </p>

          <p className="mt-0.5 truncate text-xs font-medium">
            {order.date}
          </p>
        </div>

        <div className="shrink-0 text-right">
          <p className="text-[11px] text-muted-foreground">
            Amount
          </p>

          <p className="mt-0.5 text-sm font-semibold">
            {order.amount}
          </p>
        </div>
      </div>
    </div>
  );
}