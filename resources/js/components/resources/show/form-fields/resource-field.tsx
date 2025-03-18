import React, { useState } from 'react';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/react';
import { Table } from '@/components/table';
import { TableHeader } from '@/types/component';
import { Button } from '@/components/ui/button';
import { PlusCircle, X } from 'lucide-react';
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogClose,
} from '@/components/ui/dialog';
import FormPanel from '@/components/resources/show/form-panel';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Routing',
        href: '/dashboard',
    },
];

interface ResourcesListingProps {
    tableHeader: TableHeader[];
    tableData: any[];
    pageProperties: {
        title: string;
        resource: string;
        pk: string;
        formFields?: any[];
    };
    formFields?: any[];
    reference?: any;
}

export default function ResourceField({ tableHeader, tableData, pageProperties, formFields, reference }: ResourcesListingProps) {
    const [isFormOpen, setIsFormOpen] = useState(false);
    const { data, setData, post, processing, errors, reset } = useForm({});
    
    const handleOpenForm = () => {
        reset();
        setIsFormOpen(true);
    };
    
    const handleSubmit = () => {
        post(`/${reference.objName}/${reference.value}/${pageProperties.resource}`, {
            preserveState: false,
            onSuccess: (data) => {
                console.log(data);
                
                setIsFormOpen(false);
            }
        });
    };
    
    // Normalize tableData to handle null, undefined, or object
    const normalizedData = React.useMemo(() => {
        if (!tableData) return [];
        if (!Array.isArray(tableData)) return [tableData];
        return tableData;
    }, [tableData]);
    
    return (
        <>
            <div className="flex my-5 flex-1 flex-col gap-4 rounded-xl p-4 border">
                <div className="flex justify-between items-center mb-4">
                    <h3 className="text-lg font-medium">{pageProperties.title}</h3>
                    <Button 
                        variant="outline"
                        size="sm" 
                        className="flex gap-1 items-center" 
                        onClick={handleOpenForm}
                    >
                        <PlusCircle className="h-3 w-3" />
                        <span>Create New</span>
                    </Button>
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
            
            {/* Form Dialog */}
            <Dialog open={isFormOpen} onOpenChange={setIsFormOpen}>
                <DialogContent className="sm:max-w-2xl">
                    <DialogHeader>
                        <DialogTitle className="flex justify-between items-center">
                            <span>Create New {pageProperties.title}</span>
                        </DialogTitle>
                    </DialogHeader>
                    
                    {formFields && (
                        <FormPanel
                            title=""
                            fields={formFields}
                            data={data}
                            errors={errors}
                            setData={setData}
                            onSubmit={handleSubmit}
                            loading={processing}
                            alwaysEditing={true}
                            submitLabel="Create"
                        />
                    )}
                </DialogContent>
            </Dialog>
        </>
    );
}
