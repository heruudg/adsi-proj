import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from '@inertiajs/react';
import FormPanel from '@/components/resources/show/form-panel';
import { useEffect } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Routing',
        href: '/dashboard',
    },
];

export default function ResourcesShow({ 
    formFields, 
    formData, 
    formChildren, 
    formButtons = [], 
    pageProperties 
}: { 
    formFields: any; 
    formData: any; 
    formChildren: any; 
    formButtons?: any[]; 
    pageProperties: any 
}) {
    const { data, setData, post, put, delete: destroy, processing, errors } = useForm(formData);
    
    // Handle form submission (create/update)
    const handleSubmit = () => {
        if (resId) {
            // Update existing resource
            put(`/${pageProperties.resource}/${resId}`);
        } else {
            // Create new resource
            post(`/${pageProperties.resource}`,{
                preserveState: false
            });
        }
    };

    const handleActionButtonClick = (button: any) => {
        if(button.action == 'api'){
            post(button.url, {
                preserveState: false,
            });
        }
    }

    const resId = data[pageProperties.pk]
    
    // Handle resource deletion
    const handleDelete = () => {
        if (!resId) return; // Don't attempt to delete if no ID (new record)
        
        destroy(`/${pageProperties.resource}/${resId}`, {
            onSuccess: () => {
                // Redirect to listing page on successful delete
                router.visit(`/${pageProperties.resource}`);
            }
        });
    };
    
    // Process any URL parameters in button URLs
    const processedFormButtons = formButtons.map(button => ({
        ...button,
        url: button.url?.replace(':id', resId || ''),
        redirect: button.redirect?.replace(':id', resId || '')
    }));
    
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={pageProperties.title} />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4">
                    <FormPanel
                        title={pageProperties.title}
                        fields={formFields}
                        children={formChildren}
                        data={data}
                        errors={errors as Record<string, string>}
                        setData={setData}
                        onSubmit={handleSubmit}
                        onDelete={resId ? handleDelete : undefined}
                        onActionButtonClick={handleActionButtonClick}
                        deleteConfirmationMessage={`Are you sure you want to delete this ${pageProperties.resource.replace(/-/g, ' ')}? This action cannot be undone.`}
                        alwaysEditing={resId === null}
                        loading={processing}
                        formButtons={processedFormButtons}
                    />
                </div>
            </div>
        </AppLayout>
    );
}