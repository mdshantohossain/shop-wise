import { SellerDrawerItem } from "@/features/seller/types";
import { ChevronDown, ChevronRight } from "lucide-react";
import Link from "next/link";

export default function SidebarItem({
  item,
  expanded,
  onToggle,
}: {
  item: SellerDrawerItem;
  expanded: boolean;
  onToggle: () => void;
}) {
  const Icon = item.icon;

  if (item.children) {
    return (
      <div>
        <button
          type="button"
          onClick={onToggle}
          className="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
          <span className="flex items-center gap-3">
            <Icon className="h-[18px] w-[18px]" />
            {item.title}
          </span>

          {expanded ? (
            <ChevronDown className="h-4 w-4" />
          ) : (
            <ChevronRight className="h-4 w-4" />
          )}
        </button>

        {expanded && (
          <div className="ml-5 mt-1 space-y-1 border-l pl-3">
            {item.children.map((child) => {
              const ChildIcon = child.icon;

              return (
                <Link
                  href={child.route}
                  key={child.key}
                  type="button"
                  className="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                  <ChildIcon className="h-4 w-4" />
                  {child.title}
                </Link>
              );
            })}
          </div>
        )}
      </div>
    );
  }

  return (
    <Link
      href={item.route ?? '#'}
      
      className="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
      <Icon className="h-[18px] w-[18px]" />
      {item.title}
    </Link>
  );
}
