import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Routing',
        href: '/dashboard',
    },
];

export default function ResourcesShow() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Routing" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4">
                    
                </div>
            </div>
        </AppLayout>
    );
}