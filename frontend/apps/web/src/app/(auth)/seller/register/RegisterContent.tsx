"use client";

import React, { useState } from "react";
import {
  ArrowRight,
  ArrowLeft,
  Upload,
  CheckCircle2,
  Image as ImageIcon,
  X,
} from "lucide-react";

import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/components/ui/card";
import { sellerRegistrationSchema } from "@repo/validation";

interface FormData {
  // Shop Info
  shopName: string;
  shopLogo: File | null;
  shopBanner: File | null;
  shopDescription: string;
  tradeLicense: string;
  tinNumber: string;
  businessAddress: string;
  city: string;
  district: string;
  postalCode: string;

  // Account Info
  fullName: string;
  email: string;
  phone: string;
  password: string;
}

interface FormErrors {
  [key: string]: string;
}

export default function SellerRegisterContent() {
  const [step, setStep] = useState<1 | 2>(1);
  const [errors, setErrors] = useState<FormErrors>({});
  const [isSubmitting, setIsSubmitting] = useState(false);

  console.log(sellerRegistrationSchema);

  // Preview States
  const [logoPreview, setLogoPreview] = useState<string | null>(null);
  const [bannerPreview, setBannerPreview] = useState<string | null>(null);

  const [formData, setFormData] = useState<FormData>({
    shopName: "",
    shopLogo: null,
    shopBanner: null,
    shopDescription: "",
    tradeLicense: "",
    tinNumber: "",
    businessAddress: "",
    city: "",
    district: "",
    postalCode: "",
    fullName: "",
    email: "",
    phone: "",
    password: "",
  });

  const handleChange = (field: keyof FormData, value: string | File | null) => {
    setFormData((prev) => ({
      ...prev,
      [field]: value,
    }));

    if (errors[field]) {
      setErrors((prev) => ({
        ...prev,
        [field]: "",
      }));
    }
  };

  // Handle Image Upload & Dynamic Preview Generation
  const handleFileChange = (
    field: "shopLogo" | "shopBanner",
    e: React.ChangeEvent<HTMLInputElement>,
  ) => {
    const file = e.target.files?.[0] || null;
    handleChange(field, file);

    if (file) {
      const objectUrl = URL.createObjectURL(file);
      if (field === "shopLogo") {
        if (logoPreview) URL.revokeObjectURL(logoPreview);
        setLogoPreview(objectUrl);
      } else {
        if (bannerPreview) URL.revokeObjectURL(bannerPreview);
        setBannerPreview(objectUrl);
      }
    } else {
      if (field === "shopLogo") {
        setLogoPreview(null);
      } else {
        setBannerPreview(null);
      }
    }
  };

  const removeFile = (field: "shopLogo" | "shopBanner") => {
    handleChange(field, null);
    if (field === "shopLogo") {
      if (logoPreview) URL.revokeObjectURL(logoPreview);
      setLogoPreview(null);
    } else {
      if (bannerPreview) URL.revokeObjectURL(bannerPreview);
      setBannerPreview(null);
    }
  };

  // Step 1 Strict Validation
  const validateStep1 = () => {
    const newErrors: FormErrors = {};

    if (!formData.shopName.trim()) {
      newErrors.shopName = "Shop name is required";
    }

    if (!formData.businessAddress.trim()) {
      newErrors.businessAddress = "Business address is required";
    }

    if (!formData.city.trim()) {
      newErrors.city = "City is required";
    }

    if (!formData.district.trim()) {
      newErrors.district = "District is required";
    }

    if (!formData.postalCode.trim()) {
      newErrors.postalCode = "Postal code is required";
    } else if (!/^\d{4,5}$/.test(formData.postalCode.trim())) {
      newErrors.postalCode = "Postal code must be 4 or 5 digits";
    }

    if (
      formData.tradeLicense.trim() &&
      !/^\d+$/.test(formData.tradeLicense.trim())
    ) {
      newErrors.tradeLicense = "Trade license should contain numbers only";
    }

    if (
      formData.tinNumber.trim() &&
      !/^\d{10,12}$/.test(formData.tinNumber.trim())
    ) {
      newErrors.tinNumber = "TIN number must be 10 to 12 digits";
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // Step 2 Strict Validation
  const validateStep2 = () => {
    const newErrors: FormErrors = {};

    if (!formData.fullName.trim()) {
      newErrors.fullName = "Full name is required";
    }

    if (!formData.email.trim()) {
      newErrors.email = "Email address is required";
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email.trim())) {
      newErrors.email = "Please enter a valid email address";
    }

    if (!formData.phone.trim()) {
      newErrors.phone = "Phone number is required";
    } else if (!/^(?:\+8801|8801|01)[3-9]\d{8}$/.test(formData.phone.trim())) {
      newErrors.phone = "Enter a valid BD phone number (e.g. 01712345678)";
    }

    if (!formData.password) {
      newErrors.password = "Password is required";
    } else if (formData.password.length < 8) {
      newErrors.password = "Password must be at least 8 characters";
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleNext = () => {
    if (validateStep1()) {
      setStep(2);
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    }
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    if (!validateStep2()) return;

    try {
      setIsSubmitting(true);

      const data = new FormData();
      Object.entries(formData).forEach(([key, value]) => {
        if (value !== null) {
          data.append(key, value);
        }
      });

      console.log("Submitting Registration Data:", formData);

      alert("Seller Registration Submitted Successfully!");
    } catch (error) {
      console.error("Registration failed:", error);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="min-h-screen bg-muted/30 py-4 sm:py-10 px-0 sm:px-4 flex justify-center items-start">
      <Card className="w-full max-w-2xl border-none sm:border rounded-none sm:rounded-xl shadow-none sm:shadow-sm bg-background">
        <CardHeader className="text-center px-4 pt-6 sm:px-8">
          <div className="flex items-center justify-center gap-2 mb-4">
            <div
              className={`flex items-center justify-center w-8 h-8 rounded-full text-xs font-semibold ${
                step === 1
                  ? "bg-primary text-primary-foreground"
                  : "bg-primary/20 text-primary"
              }`}>
              1
            </div>

            <div className="w-12 h-1 bg-muted rounded-full overflow-hidden">
              <div
                className={`h-full bg-primary transition-all duration-300 ${
                  step === 2 ? "w-full" : "w-0"
                }`}
              />
            </div>

            <div
              className={`flex items-center justify-center w-8 h-8 rounded-full text-xs font-semibold ${
                step === 2
                  ? "bg-primary text-primary-foreground"
                  : "bg-muted text-muted-foreground"
              }`}>
              2
            </div>
          </div>

          <CardTitle className="text-xl sm:text-2xl font-bold tracking-tight">
            {step === 1 ? "Shop Information" : "Account Setup"}
          </CardTitle>

          <CardDescription className="text-xs sm:text-sm">
            {step === 1
              ? "Provide your shop details and business address for store setup."
              : "Set up your credentials and personal contact details to manage your store."}
          </CardDescription>
        </CardHeader>

        <CardContent className="px-4 pb-6 sm:px-8">
          {step === 1 && (
            <div className="space-y-5">
              {/* Shop Name */}
              <div className="space-y-1.5">
                <Label
                  htmlFor="shopName"
                  className={errors.shopName ? "text-destructive" : ""}>
                  Shop Name *
                </Label>
                <Input
                  id="shopName"
                  placeholder="e.g. Apex Electronics"
                  value={formData.shopName}
                  onChange={(e) => handleChange("shopName", e.target.value)}
                  className={
                    errors.shopName
                      ? "border-destructive focus-visible:ring-destructive"
                      : ""
                  }
                />
                {errors.shopName && (
                  <p className="text-xs text-destructive">{errors.shopName}</p>
                )}
              </div>

              {/* Trade License & TIN (Optional) */}
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div className="space-y-1.5">
                  <Label
                    htmlFor="tradeLicense"
                    className={errors.tradeLicense ? "text-destructive" : ""}>
                    Trade License Number (Optional)
                  </Label>
                  <Input
                    id="tradeLicense"
                    placeholder="e.g. 012345678"
                    value={formData.tradeLicense}
                    onChange={(e) =>
                      handleChange("tradeLicense", e.target.value)
                    }
                    className={
                      errors.tradeLicense
                        ? "border-destructive focus-visible:ring-destructive"
                        : ""
                    }
                  />
                  {errors.tradeLicense && (
                    <p className="text-xs text-destructive">
                      {errors.tradeLicense}
                    </p>
                  )}
                </div>

                <div className="space-y-1.5">
                  <Label
                    htmlFor="tinNumber"
                    className={errors.tinNumber ? "text-destructive" : ""}>
                    TIN Number (Optional)
                  </Label>
                  <Input
                    id="tinNumber"
                    placeholder="e.g. 1234567890"
                    value={formData.tinNumber}
                    onChange={(e) => handleChange("tinNumber", e.target.value)}
                    className={
                      errors.tinNumber
                        ? "border-destructive focus-visible:ring-destructive"
                        : ""
                    }
                  />
                  {errors.tinNumber && (
                    <p className="text-xs text-destructive">
                      {errors.tinNumber}
                    </p>
                  )}
                </div>
              </div>

              {/* Business Address */}
              <div className="space-y-1.5">
                <Label
                  htmlFor="businessAddress"
                  className={errors.businessAddress ? "text-destructive" : ""}>
                  Business Address *
                </Label>
                <Textarea
                  id="businessAddress"
                  placeholder="Street address, building, suite/unit"
                  rows={2}
                  value={formData.businessAddress}
                  onChange={(e) =>
                    handleChange("businessAddress", e.target.value)
                  }
                  className={
                    errors.businessAddress
                      ? "border-destructive focus-visible:ring-destructive"
                      : ""
                  }
                />
                {errors.businessAddress && (
                  <p className="text-xs text-destructive">
                    {errors.businessAddress}
                  </p>
                )}
              </div>

              {/* City, District, Postal Code */}
              <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div className="space-y-1.5">
                  <Label
                    htmlFor="city"
                    className={errors.city ? "text-destructive" : ""}>
                    City *
                  </Label>
                  <Input
                    id="city"
                    placeholder="e.g. Dhaka"
                    value={formData.city}
                    onChange={(e) => handleChange("city", e.target.value)}
                    className={
                      errors.city
                        ? "border-destructive focus-visible:ring-destructive"
                        : ""
                    }
                  />
                  {errors.city && (
                    <p className="text-xs text-destructive">{errors.city}</p>
                  )}
                </div>

                <div className="space-y-1.5">
                  <Label
                    htmlFor="district"
                    className={errors.district ? "text-destructive" : ""}>
                    District *
                  </Label>
                  <Input
                    id="district"
                    placeholder="e.g. Dhaka"
                    value={formData.district}
                    onChange={(e) => handleChange("district", e.target.value)}
                    className={
                      errors.district
                        ? "border-destructive focus-visible:ring-destructive"
                        : ""
                    }
                  />
                  {errors.district && (
                    <p className="text-xs text-destructive">
                      {errors.district}
                    </p>
                  )}
                </div>

                <div className="space-y-1.5">
                  <Label
                    htmlFor="postalCode"
                    className={errors.postalCode ? "text-destructive" : ""}>
                    Postal Code *
                  </Label>
                  <Input
                    id="postalCode"
                    placeholder="e.g. 1216"
                    value={formData.postalCode}
                    onChange={(e) => handleChange("postalCode", e.target.value)}
                    className={
                      errors.postalCode
                        ? "border-destructive focus-visible:ring-destructive"
                        : ""
                    }
                  />
                  {errors.postalCode && (
                    <p className="text-xs text-destructive">
                      {errors.postalCode}
                    </p>
                  )}
                </div>
              </div>

              {/* Logo & Banner Upload with Image Previews */}
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                {/* Shop Logo Input & Preview */}
                <div className="space-y-1.5">
                  <Label>Shop Logo</Label>
                  {logoPreview ? (
                    <div className="relative h-28 w-full border rounded-lg overflow-hidden group bg-accent/20 flex items-center justify-center">
                      {/* eslint-disable-next-next/no-img-element */}
                      <img
                        src={logoPreview}
                        alt="Shop Logo Preview"
                        className="h-full w-full object-contain p-2"
                      />
                      <Button
                        type="button"
                        variant="destructive"
                        size="icon"
                        className="absolute top-2 right-2 h-6 w-6 rounded-full shadow-md"
                        onClick={() => removeFile("shopLogo")}>
                        <X className="h-3.5 w-3.5" />
                      </Button>
                    </div>
                  ) : (
                    <div className="relative border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:bg-accent/50 transition-colors h-28 flex flex-col justify-center items-center">
                      <input
                        type="file"
                        accept="image/png, image/jpeg, image/webp"
                        onChange={(e) => handleFileChange("shopLogo", e)}
                        className="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                      />
                      <Upload className="h-6 w-6 text-muted-foreground mb-1" />
                      <span className="text-xs text-muted-foreground font-medium">
                        Upload Logo (PNG, JPG)
                      </span>
                    </div>
                  )}
                </div>

                {/* Shop Banner Input & Preview */}
                <div className="space-y-1.5">
                  <Label>Shop Banner (Optional)</Label>
                  {bannerPreview ? (
                    <div className="relative h-28 w-full border rounded-lg overflow-hidden group bg-accent/20 flex items-center justify-center">
                      {/* eslint-disable-next-next/no-img-element */}
                      <img
                        src={bannerPreview}
                        alt="Shop Banner Preview"
                        className="h-full w-full object-cover"
                      />
                      <Button
                        type="button"
                        variant="destructive"
                        size="icon"
                        className="absolute top-2 right-2 h-6 w-6 rounded-full shadow-md"
                        onClick={() => removeFile("shopBanner")}>
                        <X className="h-3.5 w-3.5" />
                      </Button>
                    </div>
                  ) : (
                    <div className="relative border-2 border-dashed rounded-lg p-4 text-center cursor-pointer hover:bg-accent/50 transition-colors h-28 flex flex-col justify-center items-center">
                      <input
                        type="file"
                        accept="image/png, image/jpeg, image/webp"
                        onChange={(e) => handleFileChange("shopBanner", e)}
                        className="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                      />
                      <ImageIcon className="h-6 w-6 text-muted-foreground mb-1" />
                      <span className="text-xs text-muted-foreground font-medium">
                        Upload Banner (1200x400)
                      </span>
                    </div>
                  )}
                </div>
              </div>

              {/* Shop Description */}
              <div className="space-y-1.5">
                <Label htmlFor="shopDescription">Shop Description</Label>
                <Textarea
                  id="shopDescription"
                  placeholder="Tell buyers what your store sells..."
                  rows={3}
                  value={formData.shopDescription}
                  onChange={(e) =>
                    handleChange("shopDescription", e.target.value)
                  }
                />
              </div>

              <Button
                type="button"
                onClick={handleNext}
                className="w-full mt-2 h-11 text-sm font-medium">
                Continue to Account Details
                <ArrowRight className="ml-2 h-4 w-4" />
              </Button>
            </div>
          )}

          {step === 2 && (
            <form onSubmit={handleSubmit} className="space-y-5">
              {/* Full Name */}
              <div className="space-y-1.5">
                <Label
                  htmlFor="fullName"
                  className={errors.fullName ? "text-destructive" : ""}>
                  Full Name *
                </Label>
                <Input
                  id="fullName"
                  placeholder="John Doe"
                  value={formData.fullName}
                  onChange={(e) => handleChange("fullName", e.target.value)}
                  className={
                    errors.fullName
                      ? "border-destructive focus-visible:ring-destructive"
                      : ""
                  }
                />
                {errors.fullName && (
                  <p className="text-xs text-destructive">{errors.fullName}</p>
                )}
              </div>

              {/* Email */}
              <div className="space-y-1.5">
                <Label
                  htmlFor="email"
                  className={errors.email ? "text-destructive" : ""}>
                  Email Address *
                </Label>
                <Input
                  id="email"
                  type="email"
                  placeholder="seller@example.com"
                  value={formData.email}
                  onChange={(e) => handleChange("email", e.target.value)}
                  className={
                    errors.email
                      ? "border-destructive focus-visible:ring-destructive"
                      : ""
                  }
                />
                {errors.email && (
                  <p className="text-xs text-destructive">{errors.email}</p>
                )}
              </div>

              {/* Phone */}
              <div className="space-y-1.5">
                <Label
                  htmlFor="phone"
                  className={errors.phone ? "text-destructive" : ""}>
                  Phone Number *
                </Label>
                <Input
                  id="phone"
                  type="tel"
                  placeholder="01712345678"
                  value={formData.phone}
                  onChange={(e) => handleChange("phone", e.target.value)}
                  className={
                    errors.phone
                      ? "border-destructive focus-visible:ring-destructive"
                      : ""
                  }
                />
                {errors.phone && (
                  <p className="text-xs text-destructive">{errors.phone}</p>
                )}
              </div>

              {/* Password */}
              <div className="space-y-1.5">
                <Label
                  htmlFor="password"
                  className={errors.password ? "text-destructive" : ""}>
                  Password *
                </Label>
                <Input
                  id="password"
                  type="password"
                  placeholder="••••••••"
                  value={formData.password}
                  onChange={(e) => handleChange("password", e.target.value)}
                  className={
                    errors.password
                      ? "border-destructive focus-visible:ring-destructive"
                      : ""
                  }
                />
                {errors.password && (
                  <p className="text-xs text-destructive">{errors.password}</p>
                )}
              </div>

              {/* Actions */}
              <div className="flex gap-3 pt-2">
                <Button
                  type="button"
                  variant="outline"
                  onClick={() => {
                    setStep(1);
                    setErrors({});
                  }}
                  className="w-1/3 h-11"
                  disabled={isSubmitting}>
                  <ArrowLeft className="mr-2 h-4 w-4" />
                  Back
                </Button>

                <Button
                  type="submit"
                  className="w-2/3 h-11 font-medium"
                  disabled={isSubmitting}>
                  {isSubmitting ? "Registering..." : "Complete Registration"}
                  {!isSubmitting && <CheckCircle2 className="ml-2 h-4 w-4" />}
                </Button>
              </div>
            </form>
          )}
        </CardContent>
      </Card>
    </div>
  );
}
