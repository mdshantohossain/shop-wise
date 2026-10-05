"use client";

import React from "react";
import {
  ChevronUp,
  LogOut,
  Settings,
  Store,
  User,
} from "lucide-react";

import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

export default function SidebarFooter() {
  return (
    <div className="relative shrink-0 border-t bg-background p-3">
      <DropdownMenu>
        <DropdownMenuTrigger asChild>
          <Button
            variant="ghost"
            className="h-auto w-full justify-start gap-3 p-2 hover:bg-muted"
          >
            {/* Avatar */}
            <Avatar className="h-9 w-9 shrink-0">
              <AvatarFallback>SH</AvatarFallback>
            </Avatar>

            {/* User Info */}
            <div className="min-w-0 flex-1 text-left">
              <p className="truncate text-sm font-semibold">
                Shanto Hossain
              </p>

              <p className="truncate text-xs text-muted-foreground">
                Seller
              </p>
            </div>

            <ChevronUp className="h-4 w-4 shrink-0 text-muted-foreground" />
          </Button>
        </DropdownMenuTrigger>

        {/* Dropup */}
        <DropdownMenuContent
          side="top"
          align="end"
          sideOffset={8}
          className="w-[250px]"
        >
          {/* User header */}
          <div className="px-2 py-2">
            <p className="text-sm font-semibold">
              Shanto Hossain
            </p>

            <p className="text-xs text-muted-foreground">
              shanto@example.com
            </p>
          </div>

          <DropdownMenuSeparator />

          <DropdownMenuItem className="cursor-pointer">
            <User className="mr-2 h-4 w-4" />
            Profile
          </DropdownMenuItem>

          <DropdownMenuItem className="cursor-pointer">
            <Settings className="mr-2 h-4 w-4" />
            Settings
          </DropdownMenuItem>

          <DropdownMenuSeparator />

          <DropdownMenuItem className="cursor-pointer text-destructive focus:text-destructive">
            <LogOut className="mr-2 h-4 w-4" />
            Logout
          </DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
  );
}