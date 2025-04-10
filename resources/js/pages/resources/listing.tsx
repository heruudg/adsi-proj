import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Table } from '@/components/table';
import { ResourcesListingProps } from '@/types/component';
import { Button } from '@/components/ui/button';
import { PlusCircle } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Routing',
        href: '/dashboard',
    },
];


export default function ResourcesListing({ tableHeader, tableData, pageProperties }: ResourcesListingProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={pageProperties.title} />
            <div className="flex flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="flex justify-between items-center mb-4">
                    <h1 className="text-2xl font-semibold">{pageProperties.title}</h1>
                    <Link href={`/${pageProperties.resource}/create`}>
                        <Button className="flex gap-2 items-center">
                            <PlusCircle className="h-4 w-4" />
                            <span>Create New</span>
                        </Button>
                    </Link>
                </div>
                <div className="grid auto-rows-min gap-4">
                    <Table header={tableHeader} data={tableData} resourceDef={
                        {
                            resource: pageProperties.resource,
                            pk: pageProperties.pk
                        }
                    }/>
                </div>
            </div>
        </AppLayout>
    );
}
