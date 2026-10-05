import type { LucideIcon } from "lucide-react-native";

import {
  LayoutDashboard,
  Package,
  List,
  PlusCircle,
  Tags,
  Bookmark,
  Clock,
  CircleX,
  ShoppingBag,
  Bell,
  RefreshCw,
  Truck,
  CircleCheck,
  Layers,
  Users,
  Wallet,
  TrendingUp,
  Calculator,
  Banknote,
  ArrowUpCircle,
  Settings,
  Star,
  MessageSquareText,
} from "lucide-react-native";

export type SellerDrawerItem = {
  key: string;
  title: string;
  icon: LucideIcon;
  route?: string;
  children?: SellerDrawerItem[];
};

export const sellerDrawerItems: SellerDrawerItem[] = [
  // Dashboard
  {
    key: "dashboard",
    title: "Dashboard",
    icon: LayoutDashboard,
    route: "/",
  },

  // Products
  {
    key: "catalog",
    title: "Catalog",
    icon: Package,
    children: [
      {
        key: "products",
        title: "Products",
        icon: List,
        route: "/catelog/products",
      },
      {
        key: "categories",
        title: "Categories",
        icon: Tags,
        route: "/products/categories",
      },
      {
        key: "brands",
        title: "Brands",
        icon: Bookmark,
        route: "/products/brands",
      },
      {
        key: "pending",
        title: "Pending Approval",
        icon: Clock,
        route: "/products/pending",
      },
      {
        key: "rejected",
        title: "Rejected",
        icon: CircleX,
        route: "/products/rejected",
      },
    ],
  },

  // Orders
  {
    key: "orders",
    title: "Orders",
    icon: ShoppingBag,
    children: [
      {
        key: "new-orders",
        title: "New",
        icon: Bell,
        route: "/orders/new",
      },
      {
        key: "processing-orders",
        title: "Processing",
        icon: RefreshCw,
        route: "/orders/processing",
      },
      {
        key: "shipped-orders",
        title: "Shipped",
        icon: Truck,
        route: "/orders/shipped",
      },
      {
        key: "delivered-orders",
        title: "Delivered",
        icon: CircleCheck,
        route: "/orders/delivered",
      },
      {
        key: "cancelled-orders",
        title: "Cancelled",
        icon: CircleX,
        route: "/orders/cancelled",
      },
    ],
  },

  // Inventory
  {
    key: "inventory",
    title: "Inventory",
    icon: Layers,
    route: "/inventory",
  },

  // Customers
  {
    key: "customers",
    title: "Customers",
    icon: Users,
    route: "/customers",
  },

  // Finance
  {
    key: "finance",
    title: "Finance",
    icon: Wallet,
    children: [
      {
        key: "sales",
        title: "Sales",
        icon: TrendingUp,
        route: "/finance/sales",
      },
      {
        key: "commission",
        title: "Commission",
        icon: Calculator,
        route: "/finance/commission",
      },
      {
        key: "balance",
        title: "Balance",
        icon: Banknote,
        route: "/finance/balance",
      },
      {
        key: "withdrawals",
        title: "Withdrawals",
        icon: ArrowUpCircle,
        route: "/finance/withdrawals",
      },
    ],
  },
  // Reviews
  {
    key: "reviews",
    title: "Reviews",
    icon: Star,
    route: "/reviews",
  },

   // Store Settings
  {
    key: "messages",
    title: "Messages",
    icon: MessageSquareText,
    route: "/messages",
  },

  // Store Settings
  {
    key: "store-settings",
    title: "Settings",
    icon: Settings,
    route: "/store-settings",
  },
];