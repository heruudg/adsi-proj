import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { FormField } from '@/types';
import ReadOnlyField from './form-fields/read-only-field';
import SelectField from './form-fields/select-field';
import TextareaField from './form-fields/textarea-field';
import InputField from './form-fields/input-field';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Trash2 } from 'lucide-react';

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
  deleteConfirmationMessage?: string;
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
  alwaysEditing = false,
  deleteConfirmationMessage = 'Are you sure you want to delete this item? This action cannot be undone.'
}: FormPanelProps) {
  const [isEditing, setIsEditing] = useState(alwaysEditing);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
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
  
  // Handle deletion confirmation
  const handleDeleteClick = () => {
    setIsDeleteDialogOpen(true);
  };

  const handleDeleteConfirm = () => {
    onDelete?.();
    setIsDeleteDialogOpen(false);
  };
  
  // Handle field changes
  const handleFieldChange = (name: string, value: any) => {
    setData(name, value);
  };
  
  // Render the appropriate input field based on type and mode
  const renderFormField = (field: FormField) => {
    if (!showEditMode) {
      return <ReadOnlyField field={field} data={data} />;
    }
    
    switch (field.type) {
      case 'select':
        return (
          <SelectField 
            field={field} 
            value={data[field.name]} 
            onChange={handleFieldChange} 
          />
        );
      case 'textarea':
        return (
          <TextareaField 
            field={field} 
            value={data[field.name]} 
            onChange={handleFieldChange} 
          />
        );
      default:
        return (
          <InputField 
            field={field} 
            value={data[field.name]} 
            onChange={handleFieldChange} 
          />
        );
    }
  };

  return (
    <>
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
                      <Button 
                        variant="destructive" 
                        size="sm" 
                        onClick={handleDeleteClick}
                        className="flex items-center gap-1"
                      >
                        <Trash2 className="h-4 w-4" />
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
      
      {/* Delete Confirmation Dialog */}
      <AlertDialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Confirm Deletion</AlertDialogTitle>
            <AlertDialogDescription>
              {deleteConfirmationMessage}
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancel</AlertDialogCancel>
            <AlertDialogAction onClick={handleDeleteConfirm}>
              Delete
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </>
  );
}