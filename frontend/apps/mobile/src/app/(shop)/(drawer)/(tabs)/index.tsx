import { Link } from "expo-router";
import { Text, View } from "react-native";

export default function HomeScreen() {
  return (
    <View className="flex-1 justify-center items-center">
      <Text className="text-red-800 text-3xl font-bold">Home Screen</Text>

      <Link href="/(seller)" className="bg-red-800 p-4 mt-4 text-white">Go to Dashboard</Link>

      <Link href="/seller/register" className="bg-red-800 p-4 mt-4 text-white">Seller Register</Link>
    </View>
  );
}
