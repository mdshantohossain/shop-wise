import { LucideIcon } from "lucide-react";

export type SellerDrawerItem = {
  key: string;
  title: string;
  icon: LucideIcon;
  route?: string;
  children?: {key: string; title: string; icon: LucideIcon, route: string}[];
};
