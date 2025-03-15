export interface CrudResourceGroup {
    title: string;
    resources: CrudResource[];
}

export interface CrudResource {
    title: string;
}

export interface TableHeader {
    title: string;
    column: string;
    type?: 'text' | 'datetime' | 'date' | 'time';
}

export interface ResourcesListingProps {
    tableHeader: TableHeader[];
    tableData: any[];
    pageProperties: {
        title: string;
        resource: string;
        pk: string;
    };
}