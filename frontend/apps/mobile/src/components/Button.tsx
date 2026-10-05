import { Text, TouchableHighlight, View } from "react-native";
import { Loading } from "./Loading";

type Props = {
  label: string;
  className?: string;
  onPress: () => void;
  type?: "default" | "outline";
  isLoading?: boolean;
};

export default function Button({
  label,
  className = "",
  onPress,
  type = "default",
  isLoading = false,
}: Props) {
  const containerStyle =
    type === "default"
      ? "bg-app-color"
      : "bg-transparent border-[1.5px] border-app-color";

  const textStyle = type === "default" ? "text-white" : "text-app-color";

  return (
    <TouchableHighlight
      disabled={isLoading}
      activeOpacity={0.6}
      onPress={onPress}
      underlayColor={type === "default" ? "#0c9289" : "#e0fffd"}
      className={`p-4 items-center justify-center rounded-lg ${containerStyle} ${className}`}
    >
      <View className="flex-row items-center justify-center gap-2">
        <Text className={`font-bold text-[14px] ${textStyle}`}>{label}</Text>

        {isLoading && <Loading color={type === "default" ? "text-white" : "text-app-color"} />}
      </View>
    </TouchableHighlight>
  );
}