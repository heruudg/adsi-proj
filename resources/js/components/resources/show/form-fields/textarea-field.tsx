interface TextareaFieldProps {
  field: {
    name: string;
    placeholder?: string;
  };
  value: any;
  onChange: (name: string, value: any) => void;
}

export default function TextareaField({ field, value, onChange }: TextareaFieldProps) {
  return (
    <textarea
      id={field.name}
      name={field.name}
      className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
      value={value || ""}
      onChange={(e) => onChange(field.name, e.target.value)}
      placeholder={field.placeholder}
      rows={4}
    />
  );
}