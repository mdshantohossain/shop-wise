import { Stack } from "expo-router";
import { GestureHandlerRootView } from "react-native-gesture-handler";
import "../../global.css";
import { StatusBar } from "react-native";
import AppProvider from "@/providers/app-provider";

export default function RootLayout() {
  return (
    <GestureHandlerRootView
      style={{
        flex: 1,
      }}>
      <>
        <StatusBar translucent backgroundColor="red" />

        <AppProvider>
          <Stack
            screenOptions={{
              headerShown: false,
            }}>
            <Stack.Screen name="(shop)" />
            <Stack.Screen name="(seller)" />
            <Stack.Screen name="(auth)" />
          </Stack>
        </AppProvider>
      </>
    </GestureHandlerRootView>
  );
}
