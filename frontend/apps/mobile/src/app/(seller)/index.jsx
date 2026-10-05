import React from "react";
import {
  View,
  Text,
  ScrollView,
  TouchableOpacity,
  Dimensions,
} from "react-native";
import {
  DollarSign,
  ShoppingBag,
  Clock,
  AlertTriangle,
  TrendingUp,
  ArrowUpRight,
  Eye,
  ChevronRight,
  PackageCheck,
} from "lucide-react-native";

const { width } = Dimensions.get("window");

// ডামি মাসভিত্তিক সেলস ডেটা (গ্রাফের জন্য)
const monthlySales = [
  { month: "Jan", amount: 420 },
  { month: "Feb", amount: 680 },
  { month: "Mar", amount: 950 },
  { month: "Apr", amount: 740 },
  { month: "May", amount: 1200 },
  { month: "Jun", amount: 1100 },
];

const maxSales = Math.max(...monthlySales.map((d) => d.amount));

// সাম্প্রতিক অর্ডার ডেটা
const recentOrders = [
  {
    id: "#ORD-9482",
    customer: "Tanvir Hasan",
    items: "2 Items",
    total: "৳ 2,450",
    status: "Pending",
    date: "10 mins ago",
  },
  {
    id: "#ORD-9481",
    customer: "Rahim Ahmed",
    items: "1 Item",
    total: "৳ 1,200",
    status: "Processing",
    date: "45 mins ago",
  },
  {
    id: "#ORD-9480",
    customer: "Nusrat Jahan",
    items: "3 Items",
    total: "৳ 4,800",
    status: "Delivered",
    date: "2 hours ago",
  },
];

// লো স্টক অ্যালার্ট ডেটা
const lowStockItems = [
  { id: "1", name: "Wireless Earbuds G2", stock: 3, category: "Audio" },
  { id: "2", name: "Leather Wallet - Black", stock: 2, category: "Fashion" },
];

export default function SellerDashboard() {
  return (
    <ScrollView className="flex-1 bg-slate-50 p-4" showsVerticalScrollIndicator={false}>
      
      {/* 1. Header */}
      <View className="mb-5 flex-row items-center justify-between">
        <View>
          <Text className="text-2xl font-bold text-slate-900">Dashboard</Text>

        </View>
        <TouchableOpacity className="bg-white border border-slate-200 px-3 py-2 rounded-xl flex-row items-center shadow-sm">
          <Clock size={16} color="#64748b" />
          <Text className="text-xs font-semibold text-slate-600 ml-1.5">This Month</Text>
        </TouchableOpacity>
      </View>

      {/* 2. Top Stats Grid (4 Key Metrics) */}
      <View className="flex-row flex-wrap justify-between gap-y-3 mb-6">
        
        {/* Total Revenue */}
        <View className="w-[48%] bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
          <View className="flex-row justify-between items-center mb-2">
            <View className="w-10 h-10 bg-emerald-50 rounded-xl items-center justify-center">
              <DollarSign size={20} color="#10b981" />
            </View>
            <View className="flex-row items-center bg-emerald-50 px-2 py-0.5 rounded-full">
              <ArrowUpRight size={12} color="#10b981" />
              <Text className="text-[10px] font-bold text-emerald-600 ml-0.5">+12.5%</Text>
            </View>
          </View>
          <Text className="text-xs text-slate-400 font-medium">Total Revenue</Text>
          <Text className="text-xl font-bold text-slate-900 mt-1">৳ 1,48,500</Text>
        </View>

        {/* Total Orders */}
        <View className="w-[48%] bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
          <View className="flex-row justify-between items-center mb-2">
            <View className="w-10 h-10 bg-blue-50 rounded-xl items-center justify-center">
              <ShoppingBag size={20} color="#3b82f6" />
            </View>
            <View className="flex-row items-center bg-blue-50 px-2 py-0.5 rounded-full">
              <ArrowUpRight size={12} color="#3b82f6" />
              <Text className="text-[10px] font-bold text-blue-600 ml-0.5">+8.2%</Text>
            </View>
          </View>
          <Text className="text-xs text-slate-400 font-medium">Total Orders</Text>
          <Text className="text-xl font-bold text-slate-900 mt-1">342</Text>
        </View>

        {/* Pending Orders */}
        <View className="w-[48%] bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
          <View className="flex-row justify-between items-center mb-2">
            <View className="w-10 h-10 bg-amber-50 rounded-xl items-center justify-center">
              <Clock size={20} color="#f59e0b" />
            </View>
          </View>
          <Text className="text-xs text-slate-400 font-medium">Pending Orders</Text>
          <Text className="text-xl font-bold text-slate-900 mt-1">18</Text>
        </View>

        {/* Low Stock Items */}
        <View className="w-[48%] bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
          <View className="flex-row justify-between items-center mb-2">
            <View className="w-10 h-10 bg-rose-50 rounded-xl items-center justify-center">
              <AlertTriangle size={20} color="#f43f5e" />
            </View>
          </View>
          <Text className="text-xs text-slate-400 font-medium">Low Stock Alerts</Text>
          <Text className="text-xl font-bold text-rose-600 mt-1">5 Items</Text>
        </View>

      </View>

      {/* 3. Monthly Selling Graph (Bar Chart Representation) */}
      <View className="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6">
        <View className="flex-row justify-between items-center mb-4">
          <View className="flex-row items-center gap-2">
            <TrendingUp size={18} color="#3b82f6" />
            <Text className="text-base font-bold text-slate-800">Monthly Sales Trend</Text>
          </View>
          <Text className="text-xs font-semibold text-slate-400">2026</Text>
        </View>

        {/* Bar Chart View */}
        <View className="flex-row items-end justify-between h-40 pt-6 px-2 border-b border-slate-100">
          {monthlySales.map((item, index) => {
            const barHeight = (item.amount / maxSales) * 100;
            return (
              <View key={index} className="items-center flex-1">
                {/* Value tooltip label */}
                <Text className="text-[10px] text-slate-400 font-medium mb-1">
                  ৳{item.amount}
                </Text>
                {/* Bar */}
                <View className="w-6 bg-slate-100 rounded-t-lg overflow-hidden justify-end h-full">
                  <View
                    style={{ height: `${barHeight}%` }}
                    className={`w-full rounded-t-lg ${
                      index === monthlySales.length - 1
                        ? "bg-blue-600"
                        : "bg-blue-300"
                    }`}
                  />
                </View>
                {/* Month Name */}
                <Text className="text-xs font-semibold text-slate-500 mt-2">
                  {item.month}
                </Text>
              </View>
            );
          })}
        </View>
      </View>

      {/* 4. Low Stock Alert Section */}
      <View className="bg-rose-50/60 p-4 rounded-2xl border border-rose-100 mb-6">
        <View className="flex-row justify-between items-center mb-3">
          <View className="flex-row items-center gap-2">
            <AlertTriangle size={18} color="#e11d48" />
            <Text className="text-base font-bold text-rose-950">Needs Restock</Text>
          </View>
          <TouchableOpacity>
            <Text className="text-xs font-bold text-rose-600">Restock All</Text>
          </TouchableOpacity>
        </View>

        {lowStockItems.map((item) => (
          <View key={item.id} className="bg-white p-3 rounded-xl flex-row justify-between items-center mb-2 last:mb-0 shadow-sm border border-rose-100/50">
            <View>
              <Text className="text-sm font-semibold text-slate-800">{item.name}</Text>
              <Text className="text-xs text-slate-400">{item.category}</Text>
            </View>
            <View className="bg-rose-100 px-3 py-1 rounded-full">
              <Text className="text-xs font-bold text-rose-700">{item.stock} left</Text>
            </View>
          </View>
        ))}
      </View>

      {/* 5. Recent Orders List */}
      <View className="mb-8">
        <View className="flex-row justify-between items-center mb-3">
          <Text className="text-lg font-bold text-slate-800">Recent Orders</Text>
          <TouchableOpacity className="flex-row items-center">
            <Text className="text-blue-600 font-semibold text-sm">See All</Text>
            <ChevronRight size={16} color="#2563eb" />
          </TouchableOpacity>
        </View>

        <View className="bg-white rounded-2xl border border-slate-100 shadow-sm p-2">
          {recentOrders.map((order) => (
            <View
              key={order.id}
              className="flex-row items-center justify-between p-3 border-b border-slate-100 last:border-b-0"
            >
              <View className="flex-row items-center gap-3">
                <View className="w-10 h-10 bg-slate-100 rounded-xl items-center justify-center">
                  <PackageCheck size={20} color="#64748b" />
                </View>
                <View>
                  <Text className="font-bold text-slate-900 text-sm">{order.id}</Text>
                  <Text className="text-xs text-slate-500 mt-0.5">
                    {order.customer} • {order.items}
                  </Text>
                </View>
              </View>

              <View className="items-end">
                <Text className="text-sm font-bold text-slate-900">{order.total}</Text>
                <View
                  className={`px-2 py-0.5 rounded-md mt-1 ${
                    order.status === "Pending"
                      ? "bg-amber-100"
                      : order.status === "Processing"
                      ? "bg-blue-100"
                      : "bg-emerald-100"
                  }`}
                >
                  <Text
                    className={`text-[10px] font-bold ${
                      order.status === "Pending"
                        ? "text-amber-700"
                        : order.status === "Processing"
                        ? "text-blue-700"
                        : "text-emerald-700"
                    }`}
                  >
                    {order.status}
                  </Text>
                </View>
              </View>
            </View>
          ))}
        </View>
      </View>

    </ScrollView>
  );
}