import { SelectOption } from '@/types';

interface ReadOnlyFieldProps {
  field: {
    type: string;
    name: string;
    options?: SelectOption[];
  };
  data: Record<string, any>;
}

export default function ReadOnlyField({ field, data }: ReadOnlyFieldProps) {
  return (
    <div className="py-2 px-3 border border-transparent rounded-md bg-muted/30">
      {field.type === 'select' && field.options 
        ? field.options.find(opt => opt.value.toString() === data[field.name]?.toString())?.label || 
          <span className="text-muted-foreground italic">Not specified</span>
        : data[field.name] || 
          <span className="text-muted-foreground italic">Not specified</span>
      }
    </div>
  );
}