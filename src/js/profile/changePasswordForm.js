import * as z from "zod";

const schema = z.object({
  password: z.string().min(6).max(100),
  newPassword: z.string().min(6).max(100),
  confirmPassword: z.string().min(6).max(100),
  csrfToken: z.string(),
});

document
  .getElementById("password-form")
  .addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const data = {
      password: formData.get("password"),
      newPassword: formData.get("new-password"),
      confirmPassword: formData.get("confirm-password"),
      csrfToken: formData.get("csrf_token"),
    };

    const result = schema.safeParse(data);

    if (!result.success) {
      console.error(result.error);
      alert("Invalid data");
      return;
    }

    const { password, newPassword, confirmPassword, csrfToken } = result.data;

    if (newPassword !== confirmPassword) {
      alert("Passwords do not match");
      return;
    }

    const res = await fetch("/api/changePassword", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-CSRF-Token": csrfToken,
      },
      body: `password=${password}&newPassword=${newPassword}`,
    });

    if (!res.ok) {
      const data = await res.json();
      alert(data.message);
    } else {
      alert("Password changed successfully");
    }
  });
