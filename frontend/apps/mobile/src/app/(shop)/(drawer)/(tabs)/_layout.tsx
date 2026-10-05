import { Tabs } from "expo-router";
import { DrawerToggleButton } from "expo-router/drawer";
import { House, Search, Heart, ShoppingCart, User } from "lucide-react-native";

export default function TabsLayout() {
  return (
    <Tabs
      screenOptions={{
        tabBarActiveTintColor: "tomato",
        tabBarInactiveTintColor: "gray",
        // headerLeft: () => <DrawerToggleButton />,
      }}>
      <Tabs.Screen
        name="index"
        options={{
          headerLeft: () => <DrawerToggleButton />,
          title: "Home",
          tabBarIcon: ({color, size}) => (
            <House size={size} color={color} />
          )
        }}
      />
      <Tabs.Screen
        name="search"
        options={{
          title: "Search",
          tabBarIcon: ({color, size}) => (
            <Search size={size} color={color} />
          )
        }}
      />
      <Tabs.Screen
        name="wishlist"
        options={{
          title: "Saved",
          tabBarIcon: ({color, size}) => (
            <Heart size={size} color={color} />
          )
        }}
      />
      <Tabs.Screen
        name="cart"
        options={{
          title: "Cart",
          tabBarIcon: ({color, size}) => (
            <ShoppingCart size={size} color={color} />
          )
        }}
      />
      <Tabs.Screen
        name="account"
        options={{
          title: "Account",
          tabBarIcon: ({color, size}) => (
            <User size={24} color={color}/>
          )
        }}
      />
    </Tabs>
  );
}
