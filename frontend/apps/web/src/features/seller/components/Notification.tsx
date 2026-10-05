import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Separator } from '@radix-ui/react-select';
import { Bell } from 'lucide-react';
import React from 'react'

const notifications = [
  {
    title: "New order received",
    description: "Order #ORD-10482 has been placed.",
    time: "2 min ago",
  },
  {
    title: "Product approved",
    description: "Premium Wireless Headphone was approved.",
    time: "18 min ago",
  },
  {
    title: "New customer review",
    description: "You received a 5-star review.",
    time: "1 hour ago",
  },
];


export default function Notification() {
  return (
     <div className="flex items-center gap-2">
            {/* Notification */}
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                <Button
                  variant="outline"
                  size="icon"
                  className="relative rounded-full"
                >
                  <Bell className="h-4 w-4" />

                  <span className="absolute right-1 top-1 h-2 w-2 rounded-full bg-destructive ring-2 ring-background" />
                </Button>
              </DropdownMenuTrigger>

              <DropdownMenuContent
                align="end"
                className="w-[360px] p-0 "
              >
                <div className="flex items-center justify-between px-4 py-3">
                  <div>
                    <h3 className="font-semibold">Notifications</h3>
                    <p className="text-xs text-muted-foreground">
                      You have 3 unread notifications
                    </p>
                  </div>

                  <Button
                    variant="ghost"
                    size="sm"
                    className="text-xs"
                  >
                    Mark all read
                  </Button>
                </div>

                <Separator />

                <div className="max-h-[350px] overflow-y-auto">
                  {notifications.map((notification, index) => (
                    <DropdownMenuItem
                      key={index}
                      className="cursor-pointer items-start gap-3 px-4 py-3"
                    >
                      <div className="mt-1 h-2 w-2 shrink-0 rounded-full bg-primary" />

                      <div className="min-w-0">
                        <p className="text-sm font-medium">
                          {notification.title}
                        </p>

                        <p className="mt-0.5 text-xs text-muted-foreground">
                          {notification.description}
                        </p>

                        <p className="mt-1 text-[11px] text-muted-foreground">
                          {notification.time}
                        </p>
                      </div>
                    </DropdownMenuItem>
                  ))}
                </div>

                <DropdownMenuSeparator />

                <DropdownMenuItem className="justify-center py-3 text-sm font-medium">
                  View all notifications
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
  )
}
