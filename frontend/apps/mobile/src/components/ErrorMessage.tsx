import { Text, View } from "react-native";

type Props = {
  message: string;
};
export default function ErrorMessage({ message }: Props) {
  return (
    <View>
      <Text className="text-red-600 text-md">{message}</Text>
    </View>
  );
}
