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
}