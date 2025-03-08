
import { TableHeader } from '@/types/component';
import { Link } from '@inertiajs/react'

export function Table({ header = [], data = [] }: { header: TableHeader[]; data: any }) {
    return (
        <table className='min-w-full'>
            <thead className='border-gray-100 border-y bg-gray-50 dark:border-gray-800 dark:bg-gray-900'>
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
            </thead>
            <tbody>
                {data.data.map((row, index) => (
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
                                <Link href={`/routing/${row.id}`} className='mx-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>Show</Link>
                            </div>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    )
}