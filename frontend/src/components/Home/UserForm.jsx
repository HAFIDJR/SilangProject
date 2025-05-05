"use client";

import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";
import { z } from "zod";

import { Button } from "@/components/ui/button";
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { createUser, editUser } from "../../api/api";

// Skema validasi untuk name, email, dan phone
let formSchema = z.object({
  name: z.string().min(2, { message: "name must be at least 2 characters." }),
  email: z.string().email({ message: "Invalid email address." }),
  password: z
    .string()
    .min(5, { message: "Password number must be at least 6 digits." }),
  phone_number: z
    .string()
    .min(10, { message: "Phone number must be at least 10 digits." }),
});

export function UserForm({ onSuccess, dataUser = null, isEdit = false }) {
  if (isEdit) {
    formSchema = z.object({
      name: z
        .string()
        .min(2, { message: "name must be at least 2 characters." }),
      email: z.string().email({ message: "Invalid email address." }),
      phone_number: z
        .string()
        .min(10, { message: "Phone number must be at least 10 digits." }),
    });
  }

  const data = dataUser ?? {
    name: "",
    email: "",
    password: "",
    phone_number: "",
  };

  const form = useForm({
    resolver: zodResolver(formSchema),
    defaultValues: data,
  });

  async function onSubmit(values) {
    const data = await createUser(values);
    if (data && onSuccess) {
      onSuccess(); // 🔄 panggil ulang fetchData
      form.reset(); // optional: reset form
    }
  }

  async function onEdit(value) {
    const id = dataUser?.id;
    const data = await editUser(id, value);
    if (data && onSuccess) {
      onSuccess(); // 🔄 panggil ulang fetchData
      form.reset(); // optional: reset form
    }
  }

  return (
    <Form {...form}>
      <form
        onSubmit={
          isEdit ? form.handleSubmit(onEdit) : form.handleSubmit(onSubmit)
        }
        className="space-y-6"
      >
        <FormField
          control={form.control}
          name="name"
          render={({ field }) => (
            <FormItem>
              <FormLabel>name</FormLabel>
              <FormControl>
                <Input placeholder="yourname" {...field} />
              </FormControl>
              <FormDescription>
                This is your public display name.
              </FormDescription>
              <FormMessage />
            </FormItem>
          )}
        />
        <FormField
          control={form.control}
          name="email"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Email</FormLabel>
              <FormControl>
                <Input type="email" placeholder="you@example.com" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        {isEdit ? null : (
          <FormField
            control={form.control}
            name="password"
            render={({ field }) => (
              <FormItem>
                <FormLabel>Password</FormLabel>
                <FormControl>
                  <Input type="password" placeholder="123455678" {...field} />
                </FormControl>
                <FormMessage />
              </FormItem>
            )}
          />
        )}

        <FormField
          control={form.control}
          name="phone_number"
          render={({ field }) => (
            <FormItem>
              <FormLabel>Phone Number</FormLabel>
              <FormControl>
                <Input type="tel" placeholder="081234567890" {...field} />
              </FormControl>
              <FormMessage />
            </FormItem>
          )}
        />
        <Button type="submit" className="w-full">
          Submit
        </Button>
      </form>
    </Form>
  );
}
