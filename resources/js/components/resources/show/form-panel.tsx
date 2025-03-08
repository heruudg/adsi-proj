import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { 
  Select,
  SelectTrigger,
  SelectValue,
  SelectContent,
  SelectItem
} from '@/components/ui/select';

interface SelectOption {
  label: string;
  value: string | number;
}

interface FormField {
  name: string;
  label: string;
  type: string;
  placeholder?: string;
  options?: SelectOption[];
}

interface FormPanelProps {
  title: string;
  fields: FormField[];
  data: Record<string, any>;
  errors: Record<string, string>;
  setData: (name: string, value: any) => void;
  onSubmit?: () => void;
  onDelete?: () => void;
  submitLabel?: string;
  loading?: boolean;
  alwaysEditing?: boolean;
}

export default function FormPanel({
  title,
  fields,
  data,
  errors,
  setData,
  onSubmit,
  onDelete,
  submitLabel = 'Save',
  loading = false,
  alwaysEditing = false
}: FormPanelProps) {
  const [isEditing, setIsEditing] = useState(alwaysEditing);
  const showEditMode = alwaysEditing || isEditing;
  
  // Handle edit mode toggle
  const handleToggleEdit = () => {
    if (!alwaysEditing) {
      setIsEditing(!isEditing);
    }
  };

  // Handle form submission
  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit?.();
    
    if (!alwaysEditing) {
      setIsEditing(false);
    }
  };
  
  // Render read-only field
  const renderReadOnlyField = (field: FormField) => (
    <div className="py-2 px-3 border border-transparent rounded-md bg-muted/30">
      {field.type === 'select' && field.options 
        ? field.options.find(opt => opt.value.toString() === data[field.name]?.toString())?.label || 
          <span className="text-muted-foreground italic">Not specified</span>
        : data[field.name] || 
          <span className="text-muted-foreground italic">Not specified</span>
      }
    </div>
  );

  // Render select input
  const renderSelectField = (field: FormField) => (
    <Select
      name={field.name}
      value={data[field.name]?.toString() || ""}
      onValueChange={(value) => setData(field.name, value)}
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

  // Render textarea
  const renderTextareaField = (field: FormField) => (
    <textarea
      id={field.name}
      name={field.name}
      className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
      value={data[field.name] || ""}
      onChange={(e) => setData(field.name, e.target.value)}
      placeholder={field.placeholder}
      rows={4}
    />
  );

  // Render standard input
  const renderInputField = (field: FormField) => (
    <Input
      id={field.name}
      type={field.type}
      name={field.name}
      autoComplete="off"
      value={data[field.name] || ""}
      onChange={(e) => setData(field.name, e.target.value)}
      placeholder={field.placeholder}
    />
  );
  
  // Render the appropriate input field based on type and mode
  const renderFormField = (field: FormField) => {
    if (!showEditMode) {
      return renderReadOnlyField(field);
    }
    
    switch (field.type) {
      case 'select':
        return renderSelectField(field);
      case 'textarea':
        return renderTextareaField(field);
      default:
        return renderInputField(field);
    }
  };

  return (
    <Card className="rounded-xl">
      <CardHeader>
        <CardTitle className="flex justify-between items-center">
          <h3>{title}</h3>
          {!alwaysEditing && (
            <div className="flex space-x-2">
              {!isEditing ? (
                <>
                  <Button variant="outline" size="sm" onClick={handleToggleEdit}>
                    Edit
                  </Button>
                  {onDelete && (
                    <Button variant="destructive" size="sm" onClick={onDelete}>
                      Delete
                    </Button>
                  )}
                </>
              ) : (
                <Button variant="outline" size="sm" onClick={handleToggleEdit}>
                  Cancel
                </Button>
              )}
            </div>
          )}
        </CardTitle>
      </CardHeader>
      <CardContent className="px-10 py-8">
        <form onSubmit={handleSubmit} className="space-y-6">
          {fields.map((field) => (
            <div key={field.name} className="grid gap-2">
              <Label htmlFor={field.name}>{field.label}</Label>
              {renderFormField(field)}
              {showEditMode && <InputError message={errors[field.name]} />}
            </div>
          ))}

          {showEditMode && onSubmit && (
            <div className="flex justify-end">
              <Button type="submit" disabled={loading}>
                {loading ? 'Processing...' : submitLabel}
              </Button>
            </div>
          )}
        </form>
      </CardContent>
    </Card>
  );
}