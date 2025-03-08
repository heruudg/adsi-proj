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

export default function ResourcesShow({ formFields, formData }: { formFields: any; formData: any }) {
    const { data, setData, post, processing, errors } = useForm(formData);
    const handleSubmit = () => {
        post(window.location.pathname);
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Routing" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="grid auto-rows-min gap-4">
                    <FormPanel
                        title="Title"
                        fields={formFields}
                        data={data}
                        errors={errors as Record<string, string>}
                        setData={setData}
                        onSubmit={handleSubmit}
                        loading={processing}
                    />
                </div>
            </div>
        </AppLayout>
    );
}