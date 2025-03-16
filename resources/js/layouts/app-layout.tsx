import AppLayoutTemplate from '@/layouts/app/app-sidebar-layout';
import { type BreadcrumbItem } from '@/types';
import { type ReactNode, useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';

interface PageProps {
  flash: {
    message?: string;
    type?: 'success' | 'error' | 'warning' | 'info';
  };
  [key: string]: any; // Add index signature to satisfy Inertia's PageProps constraint
}
import { 
    Alert,
    AlertTitle,
    AlertDescription 
} from "@/components/ui/alert";
import { CheckCircle2, AlertCircle, Info, XCircle, X } from "lucide-react";
import { ToastContainer, toast } from "react-toastify";
interface AppLayoutProps {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
}

export default function AppLayout({ children, breadcrumbs, ...props }: AppLayoutProps) {
    const { flash } = usePage<PageProps>().props;
    
    // Show flash message when component mounts or flash changes
    useEffect(() => {
        if (flash?.message) {
            // Default to 'info' type if not specified
            const type = flash.type || 'info';
            
            // Show toast notification based on type
            switch (type) {
                case 'success':
                    toast.success(flash.message, {
                        icon: <CheckCircle2 className="h-5 w-5" />
                    });
                    break;
                case 'error':
                    toast.error(flash.message, {
                        icon: <XCircle className="h-5 w-5" />
                    });
                    break;
                case 'warning':
                    toast.warning(flash.message, {
                        icon: <AlertCircle className="h-5 w-5" />
                    });
                    break;
                case 'info':
                default:
                    toast.info(flash.message, {
                        icon: <Info className="h-5 w-5" />
                    });
                    break;
            }
        }
    }, [flash]);

    return (
        <>
            <ToastContainer
                position="top-right"
                autoClose={5000}
                hideProgressBar={false}
                newestOnTop
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
                theme="light"
            />
            
            <AppLayoutTemplate breadcrumbs={breadcrumbs} {...props}>
                {children}
            </AppLayoutTemplate>
        </>
    );
}
