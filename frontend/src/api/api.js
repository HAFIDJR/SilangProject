export async function getAllData() {
  try {
    const response = await fetch("http://127.0.0.1:8000/api/user");

    if (!response.ok) {
      throw new Error("Failed to fetch data");
    }

    const data = await response.json();
    console.log(data);
    return data;
  } catch (error) {
    console.error("Error fetching data:", error);
    return null;
  }
}

export async function createUser(user) {
  try {
    const response = await fetch("http://127.0.0.1:8000/api/user", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(user),
    });

    const data = await response.json();

    if (!response.ok) {
      console.error("Gagal menambahkan user:", data);
      return { success: false, errors: data.errors || data.message };
    }

    return { success: true, data };
  } catch (error) {
    console.error("Error menambahkan data:", error);
    return null;
  }
}
export async function editUser(id, userData) {
  try {
    console.log(userData);
    const response = await fetch(
      `http://127.0.0.1:8000/api/user/${id}?_method=PUT`,
      {
        method: "POST", // override
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(userData),
      }
    );

    if (!response.ok) {
      console.log(response);
      throw new Error(`Gagal update user: ${response}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.error("Error mengedit data:", error);
    return null;
  }
}

export async function deleteUser(id) {
  try {
    console.log(id);
    const response = await fetch(`http://127.0.0.1:8000/api/user/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        // Tambahkan Authorization jika perlu:
        // "Authorization": `Bearer ${token}`
      },
    });

    if (!response.ok) {
      throw new Error("Gagal menghapus user");
    }
    const text = await response.text();
    return text ? JSON.parse(text) : {};
  } catch (error) {
    console.error("Error menghapus data:", error);
    return null;
  }
}
