import { LoaderCircle } from "lucide-react-native";
import { View } from "react-native";
import { cssInterop } from "nativewind";

export function Loading({
  size = 20,
  color = "text-app-color",
}: {
  size?: number;
  color?: string;
}) {
  return (
    <View className="justify-center items-center">
      <View className="animate-spin">
        <LoaderCircle size={size} className={color} />
      </View>
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
