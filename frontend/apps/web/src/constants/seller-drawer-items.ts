import { SellerDrawerItem } from "@/features/seller/types";
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
  Users,
  Wallet,
  Store,
  Contact,
  MapPin,
  RotateCcw,
  WalletCards,
  ShieldCheck,
  Truck,
} from "lucide-react";

export const sellerDrawerItems: SellerDrawerItem[] = [
  {
    key: "dashboard",
    title: "Dashboard",
    icon: LayoutDashboard,
    route: "/seller/dashboard",
  },

  {
    key: "catalog",
    title: "Catalog",
    icon: Package,
    children: [
      {
        key: "products",
        title: "Products",
        icon: List,
        route: "/seller/catalog/products",
      },
      {
        key: "categories",
        title: "Categories",
        icon: Tags,
        route: "/seller/catalog/categories",
      },
      {
        key: "brands",
        title: "Brands",
        icon: Bookmark,
        route: "/seller/catalog/brands",
      },
      {
        key: "pending",
        title: "Pending Approval",
        icon: Clock,
        route: "/seller/catalog/products/pending",
      },
      {
        key: "rejected",
        title: "Rejected",
        icon: CircleX,
        route: "/seller/catalog/products/rejected",
      },
    ],
  },

  {
    key: "orders",
    title: "Orders",
    icon: ShoppingBag,
    children: [
      {
        key: "new-orders",
        title: "New",
        icon: Bell,
        route: "/seller/orders/new",
      },
      {
        key: "processing-orders",
        title: "Processing",
        icon: RefreshCw,
        route: "/seller/orders/processing",
      },
      {
        key: "shipped-orders",
        title: "Shipped",
        icon: Truck,
        route: "/seller/orders/shipped",
      },
      {
        key: "delivered-orders",
        title: "Delivered",
        icon: CircleCheck,
        route: "/seller/orders/delivered",
      },
      {
        key: "cancelled-orders",
        title: "Cancelled",
        icon: CircleX,
        route: "/seller/orders/cancelled",
      },
    ],
  },

  {
    key: "inventory",
    title: "Inventory",
    icon: Layers,
    route: "/seller/inventory",
  },

  {
    key: "customers",
    title: "Customers",
    icon: Users,
    route: "/seller/customers",
  },

  {
    key: "finance",
    title: "Finance",
    icon: Wallet,
    children: [
      {
        key: "sales",
        title: "Sales",
        icon: TrendingUp,
        route: "/seller/finance/sales",
      },
      {
        key: "commission",
        title: "Commission",
        icon: Calculator,
        route: "/seller/finance/commission",
      },
      {
        key: "balance",
        title: "Balance",
        icon: Banknote,
        route: "/seller/finance/balance",
      },
      {
        key: "withdrawals",
        title: "Withdrawals",
        icon: ArrowUpRight,
        route: "/seller/finance/withdrawals",
      },
    ],
  },

  {
    key: "reviews",
    title: "Reviews",
    icon: Star,
    route: "/seller/reviews",
  },

  {
    key: "messages",
    title: "Messages",
    icon: MessageSquareText,
    route: "/seller/messages",
  },

  {
    key: "store-settings",
    title: "Store Settings",
    icon: Settings,
    route: "/seller/store-settings",
    children: [
      {
        key: "shop-information",
        title: "Shop Information",
        icon: Store,
        route: "/seller/store-settings/shop-information",
      },
      {
        key: "contact-information",
        title: "Contact Information",
        icon: Contact,
        route: "/seller/store-settings/contact-information",
      },
      {
        key: "pickup-address",
        title: "Pickup Address",
        icon: MapPin,
        route: "/seller/store-settings/pickup-address",
      },
      {
        key: "return-address",
        title: "Return Address",
        icon: RotateCcw,
        route: "/seller/store-settings/return-address",
      },
      {
        key: "payment-payout",
        title: "Payment / Payout",
        icon: WalletCards,
        route: "/seller/store-settings/payment-payout",
      },
      {
        key: "verification",
        title: "Verification",
        icon: ShieldCheck,
        route: "/seller/store-settings/verification",
      },
      {
        key: "shipping",
        title: "Shipping",
        icon: Truck,
        route: "/seller/store-settings/shipping",
      },
    ],
  },
];
