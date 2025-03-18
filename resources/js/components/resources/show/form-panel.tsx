import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { FormField as BaseFormField } from '@/types';
import ReadOnlyField from './form-fields/read-only-field';
import SelectField from './form-fields/select-field';
import TextareaField from './form-fields/textarea-field';
import InputField from './form-fields/input-field';
import { ResourcesListingProps } from '@/types/component';
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
import { Trash2, Eye, FileText, ArrowRightLeft, Download, Printer, Share2 } from 'lucide-react';
import ResourceField from './form-fields/resource-field';

interface FormField extends BaseFormField {
  property?: {
    tableHeader?: any;
    pageProperties?: any;
  };
}

interface ActionButton {
  label: string;
  icon?: string;
  variant?: 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost' | 'link';
  action: 'link' | 'api';
  url: string;
  method?: string;
  data?: any;
  redirect?: string | null;
}

interface FormPanelProps {
  title: string;
  fields: FormField[];
  children?: ResourcesListingProps[];
  data: Record<string, any>;
  errors: Record<string, string>;
  setData: (name: string, value: any) => void;
  onSubmit?: () => void;
  onDelete?: () => void;
  submitLabel?: string;
  loading?: boolean;
  alwaysEditing?: boolean;
  deleteConfirmationMessage?: string;
  formButtons?: ActionButton[];
}

export default function FormPanel({
  title,
  fields,
  data,
  children,
  errors,
  setData,
  onSubmit,
  onDelete,
  submitLabel = 'Save',
  loading = false,
  alwaysEditing = false,
  deleteConfirmationMessage = 'Are you sure you want to delete this item? This action cannot be undone.',
  formButtons = []
}: FormPanelProps) {
  const [isEditing, setIsEditing] = useState(alwaysEditing);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
  const [isButtonLoading, setIsButtonLoading] = useState<string | null>(null);
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
  
  // Handle action button click
  const handleActionButtonClick = (button: ActionButton) => {
    setIsButtonLoading(button.label);
    
    if (button.action === 'link' && button.url) {
      // Use Inertia router for links
      window.location.href = button.url;
    } else if (button.action === 'api' && button.url) {
      // Make API call
      fetch(button.url, {
        method: button.method || 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        body: button.data ? JSON.stringify(button.data) : undefined
      })
      .then(response => response.json())
      .then(responseData => {
        // Handle success
        if (button.redirect) {
          window.location.href = button.redirect;
        } else {
          // Reload current page
          window.location.reload();
        }
      })
      .catch(error => {
        console.error('Error:', error);
      })
      .finally(() => {
        setIsButtonLoading(null);
      });
    }
  };
  
  // Get appropriate icon component
  const getButtonIcon = (iconName?: string) => {
    if (!iconName) return null;
    
    switch (iconName) {
      case 'eye':
        return <Eye className="h-4 w-4 mr-2" />;
      case 'file-text':
        return <FileText className="h-4 w-4 mr-2" />;
      case 'arrow-right-left':
        return <ArrowRightLeft className="h-4 w-4 mr-2" />;
      case 'download':
        return <Download className="h-4 w-4 mr-2" />;
      case 'print':
        return <Printer className="h-4 w-4 mr-2" />;
      case 'share':
        return <Share2 className="h-4 w-4 mr-2" />;
      default:
        return null;
    }
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
            <div className="flex space-x-2">
              {!showEditMode ? (
                <>
                  <Button variant="outline" size="sm" onClick={handleToggleEdit}>
                    Edit
                  </Button>
                  
                  {/* Action Buttons (only shown when not editing) */}
                  {formButtons && formButtons.map((button, index) => (
                    <Button
                      key={index}
                      variant={button.variant as any || "outline"}
                      size="sm"
                      onClick={() => handleActionButtonClick(button)}
                      disabled={isButtonLoading === button.label}
                      className="flex items-center"
                    >
                      {getButtonIcon(button.icon)}
                      <span>{isButtonLoading === button.label ? 'Processing...' : button.label}</span>
                    </Button>
                  ))}
                  
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
                <>
                  {!alwaysEditing && (
                    <Button variant="outline" size="sm" onClick={handleToggleEdit}>
                      Cancel
                    </Button>
                  )}
                </>
              )}
            </div>
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
          {children && children.map((child, index) => (
            <ResourceField key={index} {...child} />
          ))}
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