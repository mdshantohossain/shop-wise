import { Stack } from 'expo-router'
import React from 'react'

export default function AuthLayout() {
  return (
    <Stack 
      screenOptions={{ }}
    >
      <Stack.Screen name="seller/register" options={{ title: "Seller Register", headerShown: false}} />

      </Stack>
  )
}
