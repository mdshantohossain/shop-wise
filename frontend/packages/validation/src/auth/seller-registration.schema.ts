import * as Yup from "yup";

export const sellerRegistrationSchema = Yup.object({
  shopName: Yup.string()
    .required("Shop name is required")
    .min(3, "Shop name must be at least 3 characters"),

  sellerType: Yup.string()
    .oneOf(["individual", "business"])
    .required("Seller type is required"),

  phone: Yup.string()
    .required("Phone number is required")
    .matches(
      /^01[3-9]\d{8}$/,
      "Please enter a valid Bangladesh phone number"
    ),

  address: Yup.string()
    .required("Address is required")
    .min(10, "Address must be at least 10 characters"),
});