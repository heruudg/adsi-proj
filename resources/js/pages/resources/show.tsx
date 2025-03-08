import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import FormPanel from '@/components/resources/show/form-panel';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Routing',
        href: '/dashboard',
    },
];

export default function ResourcesShow({ formFields, formData, pageProperties }: { formFields: any; formData: any; pageProperties: any }) {
    const { data, setData, post, put, processing, errors } = useForm(formData);
    
    const handleSubmit = () => {
        if (data.id) {
            // Update existing resource
            put(`/${pageProperties.resource}/${data.id}`);
        } else {
            // Create new resource
            post(`/${pageProperties.resource}`);
        }
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={pageProperties.title} />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4">
                    <FormPanel
                        title={pageProperties.title}
                        fields={formFields}
                        data={data}
                        errors={errors as Record<string, string>}
                        setData={setData}
                        onSubmit={handleSubmit}
                        alwaysEditing={data.id === null}
                        loading={processing}
                    />
                </div>
            </div>
        </AppLayout>
    );
}