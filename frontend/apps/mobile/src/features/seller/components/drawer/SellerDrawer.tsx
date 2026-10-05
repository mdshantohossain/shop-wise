import {
  Pressable,
  ScrollView,
  Text,
  View,
} from "react-native";

import {
  ChevronDown,
  ChevronUp,
  LogOut,
  Store,
} from "lucide-react-native";

import {
  usePathname,
  useRouter,
} from "expo-router";

import { useState } from "react";

import {
  sellerDrawerItems,
} from "./drawer-items";

export default function SellerDrawer() {
  const router = useRouter();
  const pathname = usePathname();

  const [expanded, setExpanded] = useState<string>('');

  const toggleSection = (key: string) => {
    setExpanded(key === expanded ? '' : key);
  };

  const isActive = (route?: string) => {
    if (!route) return false;

    if (route === "/") {
      return pathname === "/";
    }

    return (
      pathname === route ||
      pathname.startsWith(`${route}/`)
    );
  };

  const navigate = (route?: string) => {
    if (!route) return;

    router.push(route as never);
  };

  return (
    <View className="flex-1">

      {/* =========================
          Header
      ========================== */}

      <View className="flex-row items-center gap-3 border-b border-gray-100 px-5 pb-5 pt-14">

        <View className="h-11 w-11 items-center justify-center rounded-xl bg-gray-900">
          <Store
            size={22}
            color="white"
          />
        </View>

        <View>
          <Text className="text-base font-bold text-gray-900">
            My Store
          </Text>

          <Text className="mt-0.5 text-xs text-gray-500">
            Seller Panel
          </Text>
        </View>

      </View>


      {/* =========================
          Menu
      ========================== */}

      <ScrollView
        showsVerticalScrollIndicator={false}
        className="flex-1"
        contentContainerClassName="py-3"
      >

        {sellerDrawerItems.map((item) => {

          const Icon = item.icon;

          const hasChildren =
            Boolean(item.children?.length);

          const active =
            isActive(item.route);

          const parentActive =
            item.children?.some(
              (child) => isActive(child.route)
            );

          const isExpanded =
            expanded.includes(item.key);


          /*
           * =================================
           * Normal Item
           * =================================
           */

          if (!hasChildren) {
            return (
              <Pressable
                key={item.key}
                onPress={() =>
                  navigate(item.route)
                }
                className={`mx-3 my-0.5 h-12 flex-row items-center rounded-lg px-3 ${
                  active
                    ? "bg-gray-100"
                    : ""
                }`}
              >

                <Icon
                  size={20}
                  color={
                    active
                      ? "#111827"
                      : "#6b7280"
                  }
                  strokeWidth={1.8}
                />

                <Text
                  className={`ml-3 text-[15px] ${
                    active
                      ? "font-semibold text-gray-900"
                      : "text-gray-700"
                  }`}
                >
                  {item.title}
                </Text>

              </Pressable>
            );
          }


          /*
           * =================================
           * Module
           * =================================
           */

          return (
            <View key={item.key}>

              <Pressable
                onPress={() =>
                  toggleSection(item.key)
                }
                className={`mx-3 my-0.5 h-12 flex-row items-center justify-between rounded-lg px-3 ${
                  parentActive
                    ? "bg-gray-100"
                    : ""
                }`}
              >

                <View className="flex-row items-center">

                  <Icon
                    size={20}
                    color={
                      parentActive
                        ? "#111827"
                        : "#6b7280"
                    }
                    strokeWidth={1.8}
                  />

                  <Text
                    className={`ml-3 text-[15px] ${
                      parentActive
                        ? "font-semibold text-gray-900"
                        : "text-gray-700"
                    }`}
                  >
                    {item.title}
                  </Text>

                </View>


                {isExpanded ? (
                  <ChevronUp
                    size={16}
                    color="#9ca3af"
                  />
                ) : (
                  <ChevronDown
                    size={16}
                    color="#9ca3af"
                  />
                )}

              </Pressable>


              {/* =========================
                  Sub Modules
              ========================== */}

              {isExpanded && (
                <View className="mb-1 ml-12 mr-3">

                  {item.children?.map((child) => {

                    const ChildIcon =
                      child.icon;

                    const childActive =
                      isActive(child.route);

                    return (
                      <Pressable
                        key={child.key}
                        onPress={() =>
                          navigate(child.route)
                        }
                        className={`h-10 flex-row items-center rounded-lg px-3 ${
                          childActive
                            ? "bg-gray-50"
                            : ""
                        }`}
                      >

                        <ChildIcon
                          size={17}
                          color={
                            childActive
                              ? "#111827"
                              : "#9ca3af"
                          }
                          strokeWidth={1.8}
                        />

                        <Text
                          className={`ml-3 text-sm ${
                            childActive
                              ? "font-semibold text-gray-900"
                              : "text-gray-500"
                          }`}
                        >
                          {child.title}
                        </Text>

                      </Pressable>
                    );
                  })}

                </View>
              )}

            </View>
          );
        })}

      </ScrollView>


      {/* =========================
          Footer
      ========================== */}

      <View className="border-t border-gray-100 py-2">

        <Pressable
          onPress={() => {
            // logout logic
          }}
          className="mx-3 h-12 flex-row items-center gap-3 rounded-lg px-3"
        >

          <LogOut
            size={20}
            color="#6b7280"
            strokeWidth={1.8}
          />

          <Text className="text-[15px] text-gray-700">
            Logout
          </Text>

        </Pressable>

      </View>

    </View>
  );
}