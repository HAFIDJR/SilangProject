import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { DialogForm } from "../components/Home/DialogForm";
import { getAllData } from "../api/api";
import { useEffect, useState } from "react";
import { DialogEdit } from "../components/Home/DialogEdit";
import { ConfirmDeleteData } from "../components/Home/DeleteUser";

export default function Home() {
  const [users, setUsers] = useState([]);
  async function fetchData() {
    const data = await getAllData();
    setUsers(data.data);
  }
  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div className="flex justify-center">
      <div className="ml-60 flex-1">
        <div className="flex mb-3">
          <DialogForm onSuccess={fetchData} />
        </div>
        <Table>
          <TableCaption>Semua Data User</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead className="font-extrabold">ID</TableHead>
              <TableHead>Nama</TableHead>
              <TableHead>Email</TableHead>
              <TableHead className="text-right">Password</TableHead>
              <TableHead className="text-right">No Hp</TableHead>
              <TableHead className="text-right">Aksi</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {users.map((user) => (
              <TableRow key={user.id}>
                <TableCell>{user.id}</TableCell>
                <TableCell className="font-medium">
                  {user.name || "Tidak tersedia"}
                </TableCell>
                <TableCell>{user.email || "Tidak tersedia"}</TableCell>
                <TableCell className="text-right">Hidden</TableCell>
                <TableCell className="text-right">
                  {user.phone_number || "Tidak Diisi"}
                </TableCell>
                <TableCell className="text-right">
                  <div className="ml-4 flex gap-4 justify-end">
                    <DialogEdit
                      onSuccess={fetchData}
                      dataUser={users}
                      idUser={user.id}
                    />
                    <ConfirmDeleteData id={user.id} onSucces={fetchData} />
                  </div>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </div>
    </div>
  );
}
