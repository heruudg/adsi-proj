import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Table } from '@/components/table';
import { TableHeader } from '@/types/component';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Routing',
        href: '/dashboard',
    },
];


interface ResourcesListingProps {
    tableHeader: TableHeader[];
    tableData: any[];
}

export default function ResourcesListing({ tableHeader, tableData }: ResourcesListingProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Routing" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4">
                    <Table header={tableHeader} data={tableData} />
                </div>
            </div>
        </AppLayout>
    );
}
