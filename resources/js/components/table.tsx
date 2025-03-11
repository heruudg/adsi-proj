
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
                                        {row[col.column]}
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