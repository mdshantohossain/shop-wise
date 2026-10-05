import { ScrollView } from "react-native-gesture-handler";
import { SafeAreaView } from "react-native-safe-area-context";

type Props = {
  children: React.ReactNode;
  shownScrollBar?: boolean;
};

export default function Container({ children, shownScrollBar = false }: Props) {
  return (
    <>
      <SafeAreaView style={{ flex: 1 }}>
        <ScrollView
          className="flex-1"
          showsVerticalScrollIndicator={shownScrollBar}
          contentContainerClassName="px-4 py-5">
          {children}
        </ScrollView>
      </SafeAreaView>
    </>
  );
}
