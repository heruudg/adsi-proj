import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';

interface FormField {
  name: string;
  label: string;
  type: string;
  placeholder?: string;
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
  
  const handleToggleEdit = () => {
    if (!alwaysEditing) {
      setIsEditing(!isEditing);
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onSubmit?.();
    
    // Only disable editing mode if not set to always editing
    if (!alwaysEditing) {
      setIsEditing(false);
    }
  };
  
  // Determine if we should show fields in edit mode
  const showEditMode = alwaysEditing || isEditing;
  
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
          {fields.map((field, index) => (
            <div key={index} className="grid gap-2">
              <Label htmlFor={field.name}>{field.label}</Label>
              
              {showEditMode ? (
                <Input
                  id={field.name}
                  type={field.type}
                  name={field.name}
                  autoComplete="off"
                  value={data[field.name]}
                  onChange={(e) => setData(field.name, e.target.value)}
                  placeholder={field.placeholder}
                />
              ) : (
                <div className="py-2 px-3 border border-transparent rounded-md bg-muted/30">
                  {data[field.name] || <span className="text-muted-foreground italic">Not specified</span>}
                </div>
              )}
              
              {showEditMode && <InputError message={errors[field.name]} />}
            </div>
          ))}

          {(showEditMode || alwaysEditing) && onSubmit && (
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