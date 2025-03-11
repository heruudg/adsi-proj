import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { BookOpen, Folder, LayoutGrid, Settings } from 'lucide-react';
import AppLogo from './app-logo';

// Define the icon mapping
const iconMapping = {
  LayoutGrid,
  Folder,
  BookOpen,
  Settings,
  // Add more icons as needed
};

// Default navigation in case PHP doesn't provide any
const defaultNavItems: NavItem[] = [];

const footerNavItems: NavItem[] = [];

export function AppSidebar() {
    // Get navigation items from Inertia shared props
    const { navigation } = usePage().props as any;
    
    // Use PHP-provided navigation or fall back to default
    const mainNavItems: NavItem[] = (navigation?.mainNavItems || defaultNavItems).map(
      (item: any) => ({
        ...item,
        icon: iconMapping[item.icon as keyof typeof iconMapping] || LayoutGrid
      })
    );

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/dashboard" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
