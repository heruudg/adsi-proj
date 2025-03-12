
import { TableHeader } from '@/types/component';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react'

interface ResourceDef{
    resource: string;
    pk: string;
}

export function Table({ header = [], data = [], resourceDef = { resource: '', pk: '' } }: { header: TableHeader[]; data:  any; resourceDef: ResourceDef }) {
    return (
        <div>
       
            <table className='min-w-full'>
                <thead className='border-gray-100 border-y bg-gray-50 dark:border-gray-800 dark:bg-gray-900'>
                    <tr>
                        {header.map((col, index) => (
                            <th className='px-6 py-3 whitespace-nowrap' key={index}>
                                <div className='flex items-center'>
                                    {col.title}
                                </div>
                            </th>
                        ))}
                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {data.data.map((row: any, index: number) => (
                        <tr key={index}>
                            {header.map((col, index) => (
                                <td className='px-6 py-3 whitespace-nowrap' key={index}>
                                    <div className='flex items-center'>
                                        {(() => {
                                            const columnPath = col.column.split('.');
                                            let value = row;
                                            for (const key of columnPath) {
                                                value = value?.[key];
                                                if (value === undefined) break;
                                            }
    
                                            // Handle date formatting if the value is a date
                                            if (value && col.type === 'datetime' && !isNaN(new Date(value).getTime())) {
                                                const date = new Date(value);
                                                return date.toLocaleString(); // Format as locale date and time
                                            } else if (value && col.type === 'date' && !isNaN(new Date(value).getTime())) {
                                                const date = new Date(value);
                                                return date.toLocaleDateString(); // Format as locale date
                                            } else if (value && col.type === 'time' && !isNaN(new Date(value).getTime())) {
                                                const date = new Date(value);
                                                return date.toLocaleTimeString(); // Format as locale time
                                            }
    
                                            return value;
                                        })()}
                                    </div>
                                </td>
                            ))}
                            <td className='px-6 py-3 whitespace-nowrap'>
                                <div className='flex items-center'>
                                    <Link href={`/${resourceDef.resource}/${row[resourceDef.pk]}`} className='mx-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Show</Link>
                                </div>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <div className='mx-auto w-fit mt-4'>
                {data.links.map((row: any, index: number) => (
                    row.url ? (
                        <Link className='mx-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-1' href={row.url} key={index}>{row.label}</Link>
                    ) : ''
                ))}
            </div>
        </div>
    )
}