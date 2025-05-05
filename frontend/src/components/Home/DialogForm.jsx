import { Button } from "@/components/ui/button";
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

export function DialogForm({ onSuccess }) {
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button variant="outline">
          <div className="text-amber-50">Tambah User</div>
        </Button>
      </DialogTrigger>
      <DialogContent className="sm:max-w-[425px]">
        <DialogHeader>
          <DialogTitle>Tambhkan User Terbaru</DialogTitle>
          <DialogDescription>
            Pastikan User Sebelumnya Belum Di Tambahkan
          </DialogDescription>
        </DialogHeader>
        {/* Form User */}
        <UserForm onSuccess={onSuccess} />
      </DialogContent>
    </Dialog>
  );
}
