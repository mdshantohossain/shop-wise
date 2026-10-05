import { useState } from "react";
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  Image,
  Alert,
} from "react-native";
import * as ImagePicker from "expo-image-picker";
import { Image as ImageIcon, UploadCloud } from "lucide-react-native";
import { sellerRegistrationSchema } from "@repo/validation";
import Button from "@/components/Button";
import Container from "@/layouts/Container";

export default function ExpoSellerRegisterScreen() {
  // Form States
  const [sellerName, setSellerName] = useState("");
  const [shopName, setShopName] = useState("");
  const [phone, setPhone] = useState("");
  const [email, setEmail] = useState("");
  const [shopAddress, setShopAddress] = useState("");
  const [businessType, setBusinessType] = useState("");
  const [description, setDescription] = useState("");

  // Image States
  const [logoUri, setLogoUri] = useState<string | null>(null);
  const [bannerUri, setBannerUri] = useState<string | null>(null);

  // Image Picker Handler
  const pickImage = async (type: "logo" | "banner") => {
    // Permission request
    const { status } = await ImagePicker.requestMediaLibraryPermissionsAsync();

    if (status !== "granted") {
      Alert.alert(
        "Permission Denied",
        "Sorry, we need camera roll permissions to make this work!",
      );
      return;
    }

    // Launch image library
    let result = await ImagePicker.launchImageLibraryAsync({
      mediaTypes: ImagePicker.MediaTypeOptions.Images,
      allowsEditing: false,
      aspect: type === "logo" ? [1, 1] : [3, 1], // Logo 1:1 and Banner 3:1 ratio
      quality: 0.8,
    });

    if (!result.canceled && result.assets && result.assets.length > 0) {
      const selectedImage = result.assets[0].uri;
      if (type === "logo") {
        setLogoUri(selectedImage);
      } else {
        setBannerUri(selectedImage);
      }
    }
  };

  const handleSubmit = () => {
    Alert.alert(
      "Registration Info",
      `Seller: ${sellerName}\nShop: ${shopName}\nPhone: ${phone}\nLogo: ${
        logoUri ? "Uploaded" : "No"
      }\nBanner: ${bannerUri ? "Uploaded" : "No"}`,
    );
  };

  return (
    <Container>
    
       <Text className="text-2xl font-bold text-gray-900 mb-6">
          Register as a Seller
        </Text>

        {/* Seller Name */}
        <View className="mb-4">
          <Text className="text-sm font-medium text-gray-700 mb-1">
            Full Name
          </Text>
          <TextInput
            value={sellerName}
            onChangeText={setSellerName}
            placeholder="Enter your full name"
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500"
          />
        </View>

        {/* Shop Name */}
        <View className="mb-4">
          <Text className="text-sm font-medium text-gray-700 mb-1">
            Shop Name
          </Text>
          <TextInput
            value={shopName}
            onChangeText={setShopName}
            placeholder="Enter your shop name"
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500"
          />
        </View>

        {/* Phone & Email Container */}
        <View className="mb-4">
          <Text className="text-sm font-medium text-gray-700 mb-1">
            Phone Number
          </Text>
          <TextInput
            value={phone}
            onChangeText={setPhone}
            placeholder="+880 1700-000000"
            keyboardType="phone-pad"
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500 mb-4"
          />

          <Text className="text-sm font-medium text-gray-700 mb-1">
            Email Address
          </Text>
          <TextInput
            value={email}
            onChangeText={setEmail}
            placeholder="seller@example.com"
            keyboardType="email-address"
            autoCapitalize="none"
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500"
          />
        </View>

        {/* Business Type */}
        <View className="mb-4">
          <Text className="text-sm font-medium text-gray-700 mb-1">
            Business Category / Type
          </Text>
          <TextInput
            value={businessType}
            onChangeText={setBusinessType}
            placeholder="e.g. Clothing, Electronics, Grocery"
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500"
          />
        </View>

        {/* Shop Address */}
        <View className="mb-4">
          <Text className="text-sm font-medium text-gray-700 mb-1">
            Shop Address
          </Text>
          <TextInput
            value={shopAddress}
            onChangeText={setShopAddress}
            placeholder="Enter detailed shop address"
            multiline
            numberOfLines={2}
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500"
          />
        </View>

        {/* Shop Description */}
        <View className="mb-6">
          <Text className="text-sm font-medium text-gray-700 mb-1">
            Shop Description
          </Text>
          <TextInput
            value={description}
            onChangeText={setDescription}
            placeholder="Tell buyers about your shop..."
            multiline
            numberOfLines={3}
            className="border border-gray-300 rounded-xl px-4 py-3 text-base text-gray-800 bg-gray-50 focus:border-indigo-500"
          />
        </View>

        {/* Shop Banner Upload */}
        <View className="mb-6">
          <Text className="text-sm font-medium text-gray-700 mb-2">
            Shop Banner
          </Text>
          <TouchableOpacity
            activeOpacity={0.7}
            onPress={() => pickImage("banner")}
            className="border-2 border-dashed border-gray-300 rounded-2xl h-32 bg-gray-50 items-center justify-center overflow-hidden">
            {bannerUri ? (
              <Image
                source={{ uri: bannerUri }}
                className="w-full h-full"
                resizeMode="cover"
              />
            ) : (
              <View className="items-center">
                <ImageIcon size={24} color="#6B7280" />
                <Text className="text-xs font-medium text-gray-500 mt-1">
                  Upload Shop Banner (3:1)
                </Text>
              </View>
            )}
          </TouchableOpacity>
        </View>

        {/* Shop Logo Upload */}
        <View className="mb-8">
          <Text className="text-sm font-medium text-gray-700 mb-2">
            Shop Logo
          </Text>
          <View className="flex-row items-center gap-4">
            <TouchableOpacity
              activeOpacity={0.7}
              onPress={() => pickImage("logo")}
              className="border-2 border-dashed border-gray-300 rounded-2xl w-20 h-20 bg-gray-50 items-center justify-center overflow-hidden">
              {logoUri ? (
                <Image
                  source={{ uri: logoUri }}
                  className="w-full h-full"
                  resizeMode="cover"
                />
              ) : (
                <UploadCloud size={20} color="#6B7280" />
              )}
            </TouchableOpacity>

            <View className="flex-1">
              <Text className="text-sm font-semibold text-gray-800">
                Upload Logo
              </Text>
              <Text className="text-xs text-gray-500 mt-0.5">
                Square image recommended (1:1 ratio)
              </Text>
            </View>
          </View>
        </View>

        <Button
          label="Next Step"
          onPress={handleSubmit}
          
          className="mb-3"
        />
    </Container>
  );
}
