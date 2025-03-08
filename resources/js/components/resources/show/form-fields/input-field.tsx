import { Input } from '@/components/ui/input';

interface InputFieldProps {
  field: {
    type: string;
    name: string;
    placeholder?: string;
  };
  value: any;
  onChange: (name: string, value: any) => void;
}

export default function InputField({ field, value, onChange }: InputFieldProps) {
  return (
    <Input
      id={field.name}
      type={field.type}
      name={field.name}
      autoComplete="off"
      value={value || ""}
      onChange={(e) => onChange(field.name, e.target.value)}
      placeholder={field.placeholder}
    />
  );
}