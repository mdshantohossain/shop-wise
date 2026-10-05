import { RelativePathString, usePathname, useRouter } from "expo-router";
import { Bell } from "lucide-react-native";
import { Pressable, Text, View } from "react-native";

export default function HeaderRightIcon() {
  const router = useRouter();
  const pathname = usePathname();


  if(pathname === "/notifications") {
    return null;
  };

  const handlePress = () => {
    router.push("/notifications" as RelativePathString);
  };

  return (
    <Pressable 
      onPress={handlePress} 
      className="p-2 justify-center items-center mr-3"
      style={{ position: "relative" }}
    >
      <Bell size={24} color="#334155" />

      {/* Notification Badge */}
      <View
        className="bg-red-500 items-center justify-center rounded-full"
        style={{
          position: "absolute",
          top: -1,
          right: 2,
          minWidth: 18,
          height: 18,
          paddingHorizontal: 3,
          backgroundColor: 'red',
          borderRadius: 50
        }}
      >
        <Text className="text-white font-bold" style={{ fontSize: 11 }}>
          14
        </Text>
      </View>
    </Pressable>
  );
}