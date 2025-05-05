import { Button } from "@/components/ui/button";
import { DeleteIcon, Edit2Icon } from "lucide-react";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from "@/components/ui/dialog";
import { UserForm } from "./UserForm";

export function DialogEdit({ onSuccess, dataUser, idUser }) {
  function getUserById(id) {
    if (!dataUser) return null;
    return dataUser.find((user) => user.id === id);
  }
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button variant="outline">
          <Edit2Icon className="text-yellow-500" />
          <div className="text-amber-50">Edit User</div>
        </Button>
      </DialogTrigger>
      <DialogContent className="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>Edit User</DialogTitle>
          <DialogDescription>
            Pastikan User Sebelumnya Belum Di Tambahkan
          </DialogDescription>
        </DialogHeader>
        {/* Form User */}
        <UserForm
          onSuccess={onSuccess}
          dataUser={getUserById(idUser)}
          isEdit={true}
        />
      </DialogContent>
    </Dialog>
  );
}
