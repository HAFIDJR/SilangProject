import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import { DeleteIcon } from "lucide-react";
import { deleteUser } from "../../api/api";

export function ConfirmDeleteData({ id, onSucces }) {
  async function onDeleted(id) {
    const data = await deleteUser(id);
    onSucces();
    console.log(data);
  }
  return (
    <AlertDialog>
      <AlertDialogTrigger asChild>
        <DeleteIcon className="text-red-500 cursor-pointer" size={30} />
      </AlertDialogTrigger>
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Yakin Menghapus Data</AlertDialogTitle>
          <AlertDialogDescription>
            This action cannot be undone. This will permanently delete your
            account and remove your data from our servers.
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel>
            <p className="text-amber-50">Cancel</p>
          </AlertDialogCancel>
          <AlertDialogAction onClick={() => onDeleted(id)}>
            <p className="text-red-600">Continue</p>
          </AlertDialogAction>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  );
}
