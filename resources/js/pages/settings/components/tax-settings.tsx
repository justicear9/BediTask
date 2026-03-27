import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Plus, Edit, Trash2 } from 'lucide-react';
import { useForm } from '@inertiajs/react';
import { CrudDeleteModal } from '@/components/CrudDeleteModal';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import axios from 'axios';


interface Tax {
  id: number;
  name: string;
  rate: number;
}

interface TaxSettingsProps {
  taxes?: Tax[];
}

export default function TaxSettings({ taxes = [] }: TaxSettingsProps) {
  const [isCreateOpen, setIsCreateOpen] = useState(false);
  const [isEditOpen, setIsEditOpen] = useState(false);
  const [isDeleteOpen, setIsDeleteOpen] = useState(false);
  const [editingTax, setEditingTax] = useState<Tax | null>(null);
  const [deletingTax, setDeletingTax] = useState<Tax | null>(null);

  const deleteForm = useForm();


  const createForm = useForm({
    name: '',
    rate: '',
  });

  const editForm = useForm({
    name: '',
    rate: '',
  });

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    createForm.post(route('taxes.store'), {
      onSuccess: () => {
        setIsCreateOpen(false);
        createForm.reset();

      },
      onError: () => {

      },
    });
  };

  const handleEdit = (tax: Tax) => {
    setEditingTax(tax);
    editForm.setData({
      name: tax.name,
      rate: tax.rate.toString(),
    });
    setIsEditOpen(true);
  };

  const handleUpdate = (e: React.FormEvent) => {
    e.preventDefault();
    if (!editingTax) return;

    editForm.put(route('taxes.update', editingTax.id), {
      onSuccess: () => {
        setIsEditOpen(false);
        setEditingTax(null);
        editForm.reset();

      },
      onError: () => {

      },
    });
  };

  const handleDelete = (tax: Tax) => {
    setDeletingTax(tax);
    setIsDeleteOpen(true);
  };

  const confirmDelete = () => {
    if (!deletingTax) return;
    
    deleteForm.delete(route('taxes.destroy', deletingTax.id), {
      onSuccess: () => {
        setIsDeleteOpen(false);
        setDeletingTax(null);
      },
      onError: () => {
        setIsDeleteOpen(false);
        setDeletingTax(null);
      },
    });
  };

  return (
    <Card>
      <CardHeader>
        <div className="flex items-center justify-between">
          <div>
            <CardTitle>Tax Settings</CardTitle>
            <CardDescription>
              Manage tax rates for your workspace
            </CardDescription>
          </div>
          <Dialog open={isCreateOpen} onOpenChange={setIsCreateOpen}>
            <DialogTrigger asChild>
              <Button>
                <Plus className="h-4 w-4 mr-2" />
                Add Tax
              </Button>
            </DialogTrigger>
            <DialogContent>
              <DialogHeader>
                <DialogTitle>Create Tax</DialogTitle>
                <DialogDescription>
                  Add a new tax rate to your workspace.
                </DialogDescription>
              </DialogHeader>
              <form onSubmit={handleCreate}>
                <div className="grid gap-4 py-4">
                  <div className="grid gap-2">
                    <Label htmlFor="name">Tax Name</Label>
                    <Input
                      id="name"
                      value={createForm.data.name}
                      onChange={(e) => createForm.setData('name', e.target.value)}
                      placeholder="e.g., VAT, GST, Sales Tax"
                      required
                    />
                    {createForm.errors.name && (
                      <p className="text-sm text-red-600">{createForm.errors.name}</p>
                    )}
                  </div>
                  <div className="grid gap-2">
                    <Label htmlFor="rate">Tax Rate (%)</Label>
                    <Input
                      id="rate"
                      type="number"
                      step="0.01"
                      min="0"
                      max="100"
                      value={createForm.data.rate}
                      onChange={(e) => createForm.setData('rate', e.target.value)}
                      placeholder="e.g., 18.00"
                      required
                    />
                    {createForm.errors.rate && (
                      <p className="text-sm text-red-600">{createForm.errors.rate}</p>
                    )}
                  </div>
                </div>
                <DialogFooter>
                  <Button type="button" variant="outline" onClick={() => setIsCreateOpen(false)}>
                    Cancel
                  </Button>
                  <Button type="submit" disabled={createForm.processing}>
                    {createForm.processing ? 'Creating...' : 'Create Tax'}
                  </Button>
                </DialogFooter>
              </form>
            </DialogContent>
          </Dialog>
        </div>
      </CardHeader>
      <CardContent>
        <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Name</TableHead>
                <TableHead>Rate</TableHead>
                <TableHead className="text-right">Actions</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {taxes.map((tax) => (
                <TableRow key={tax.id}>
                  <TableCell className="font-medium">{tax.name}</TableCell>
                  <TableCell>
                    <Badge variant="secondary">{tax.rate}%</Badge>
                  </TableCell>
                  <TableCell className="text-right">
                    <div className="flex items-center justify-end gap-2">
                      <TooltipProvider>
                        <Tooltip>
                          <TooltipTrigger asChild>
                            <Button
                              variant="ghost"
                              size="icon"
                              className="h-8 w-8 text-amber-500 hover:text-amber-700"
                              onClick={() => handleEdit(tax)}
                            >
                              <Edit className="h-4 w-4" />
                            </Button>
                          </TooltipTrigger>
                          <TooltipContent>
                            <p>Edit</p>
                          </TooltipContent>
                        </Tooltip>
                      </TooltipProvider>
                      <TooltipProvider>
                        <Tooltip>
                          <TooltipTrigger asChild>
                            <Button
                              variant="ghost"
                              size="icon"
                              className="h-8 w-8 text-red-500 hover:text-red-700"
                              onClick={() => handleDelete(tax)}
                            >
                              <Trash2 className="h-4 w-4" />
                            </Button>
                          </TooltipTrigger>
                          <TooltipContent>
                            <p>Delete</p>
                          </TooltipContent>
                        </Tooltip>
                      </TooltipProvider>
                    </div>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>

        {/* Edit Dialog */}
        <Dialog open={isEditOpen} onOpenChange={setIsEditOpen}>
          <DialogContent>
            <DialogHeader>
              <DialogTitle>Edit Tax</DialogTitle>
              <DialogDescription>
                Update the tax rate information.
              </DialogDescription>
            </DialogHeader>
            <form onSubmit={handleUpdate}>
              <div className="grid gap-4 py-4">
                <div className="grid gap-2">
                  <Label htmlFor="edit-name">Tax Name</Label>
                  <Input
                    id="edit-name"
                    value={editForm.data.name}
                    onChange={(e) => editForm.setData('name', e.target.value)}
                    placeholder="e.g., VAT, GST, Sales Tax"
                    required
                  />
                  {editForm.errors.name && (
                    <p className="text-sm text-red-600">{editForm.errors.name}</p>
                  )}
                </div>
                <div className="grid gap-2">
                  <Label htmlFor="edit-rate">Tax Rate (%)</Label>
                  <Input
                    id="edit-rate"
                    type="number"
                    step="0.01"
                    min="0"
                    max="100"
                    value={editForm.data.rate}
                    onChange={(e) => editForm.setData('rate', e.target.value)}
                    placeholder="e.g., 18.00"
                    required
                  />
                  {editForm.errors.rate && (
                    <p className="text-sm text-red-600">{editForm.errors.rate}</p>
                  )}
                </div>
              </div>
              <DialogFooter>
                <Button type="button" variant="outline" onClick={() => setIsEditOpen(false)}>
                  Cancel
                </Button>
                <Button type="submit" disabled={editForm.processing}>
                  {editForm.processing ? 'Updating...' : 'Update Tax'}
                </Button>
              </DialogFooter>
            </form>
          </DialogContent>
        </Dialog>

        {/* Delete Modal */}
        <CrudDeleteModal
          isOpen={isDeleteOpen}
          onClose={() => setIsDeleteOpen(false)}
          onConfirm={confirmDelete}
          itemName={deletingTax?.name || ''}
          entityName="Tax"
        />
      </CardContent>
    </Card>
  );
}