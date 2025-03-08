import { SelectOption } from '@/types';
import { 
  Select,
  SelectTrigger,
  SelectValue,
  SelectContent,
  SelectItem
} from '@/components/ui/select';

interface SelectFieldProps {
  field: {
    name: string;
    label: string;
    placeholder?: string;
    options?: SelectOption[];
  };
  value: any;
  onChange: (name: string, value: any) => void;
}

export default function SelectField({ field, value, onChange }: SelectFieldProps) {
  return (
    <Select
      name={field.name}
      value={value?.toString() || ""}
      onValueChange={(value) => onChange(field.name, value)}
    >
      <SelectTrigger>
        <SelectValue placeholder={field.placeholder || `Select ${field.label}`} />
      </SelectTrigger>
      <SelectContent>
        {field.options?.map((option) => (
          <SelectItem key={`${field.name}-${option.value}`} value={option.value.toString()}>
            {option.label}
          </SelectItem>
        ))}
      </SelectContent>
    </Select>
  );
}