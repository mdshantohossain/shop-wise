import { Drawer } from "expo-router/drawer";

import SellerDrawer from "@/features/seller/components/drawer/SellerDrawer";
import HeaderRightIcon from "@/features/seller/components/header-right";

export default function SellerLayout() {
  return (
    <Drawer
      drawerContent={() => <SellerDrawer />}
      screenOptions={{
        drawerStyle: {
          width: 320,
        },
        headerRight: () => <HeaderRightIcon />,
      }}>
      <Drawer.Screen name="index" options={{ title: "Dashboard" }} />
      <Drawer.Screen
        name="notifications"
        options={{ title: "Notifications" }}
      />

      {/* Catalog */}
      <Drawer.Screen
        name="catalog/products"
        options={{ title: "All Products" }}
      />
      <Drawer.Screen
        name="catalog/products/create"
        options={{ title: "Product Create" }}
      />
      <Drawer.Screen
        name="catalog/products/edit"
        options={{ title: "Product Edit" }}
      />

      {/* category */}
      <Drawer.Screen
        name="catalog/categories"
        options={{ title: "All Categories" }}
      />
      <Drawer.Screen
        name="catalog/categories/create"
        options={{ title: "Category Create" }}
      />
      <Drawer.Screen
        name="catalog/categories/edit"
        options={{ title: "Category Edit" }}
      />

      {/* brands */}
      <Drawer.Screen name="catalog/brands" options={{ title: "All Brands" }} />
      <Drawer.Screen
        name="catalog/brands/create"
        options={{ title: "Brand Create" }}
      />
      <Drawer.Screen
        name="catalog/brands/edit"
        options={{ title: "Brand Edit" }}
      />

      <Drawer.Screen
        name="catalog/pending"
        options={{ title: "Pending Approval Products" }}
      />
      <Drawer.Screen
        name="catalog/rejected/index"
        options={{ title: "Rejected Products" }}
      />

      {/* Orders */}
      <Drawer.Screen name="orders" options={{ title: "Orders" }} />
      <Drawer.Screen
        name="orders/processing"
        options={{ title: "Processing Orders" }}
      />
      <Drawer.Screen
        name="orders/shipped"
        options={{ title: "Shipped Orders" }}
      />
      <Drawer.Screen
        name="orders/delivered"
        options={{ title: "Delivered Orders" }}
      />
      <Drawer.Screen
        name="orders/cancelled"
        options={{ title: "Canceled Orders" }}
      />

      {/* Invertory */}
      <Drawer.Screen name="inventory" options={{ title: "Inventory" }} />

      {/* Customers */}
      <Drawer.Screen name="customers" options={{ title: "Customers" }} />

      {/* finance */}
      <Drawer.Screen name="finance/sales" options={{ title: "Sales" }} />
      <Drawer.Screen name="finance/balance" options={{ title: "Balance" }} />
      <Drawer.Screen
        name="finance/commission"
        options={{ title: "Commission" }}
      />
      <Drawer.Screen
        name="finance/withdrawals"
        options={{ title: "Withdrawals" }}
      />

      {/* Reviews */}
      <Drawer.Screen name="reviews" options={{ title: "Reviews" }} />

      {/* Messages */}
      <Drawer.Screen name="messages" options={{ title: "Messages" }} />

      {/* Settings */}
      <Drawer.Screen
        name="store-settings"
        options={{ title: "Store Settings" }}
      />

      <Drawer.Screen name="settings" options={{ title: "General Settings" }} />
    </Drawer>
  );
}
