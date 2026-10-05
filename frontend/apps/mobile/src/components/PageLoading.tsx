import { LoaderCircle } from "lucide-react-native";
import { Text, View } from "react-native";
import { cssInterop } from "nativewind";

export function Loading() {
  return (
    <View className="flex-row items-center justify-center gap-2">
      <View className="animate-spin">
        <LoaderCircle color="#088178" size={20} />
      </View>
      <Text className="text-gray-700">Please wait...</Text>
    </View>
  );
}

cssInterop(LoaderCircle, {
  className: {
    target: "style",
    nativeStyleToProp: {
      color: true,
    },
  },
});
