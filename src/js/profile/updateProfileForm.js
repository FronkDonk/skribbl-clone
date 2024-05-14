import * as z from "zod";

const schema = z.object({
  username: z.string().min(3).max(30).optional(),
  email: z.string().email().optional(),
  csrfToken: z.string(),
});

document
  .getElementById("profile-form")
  .addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const data = {
      username: formData.get("username"),
      email: formData.get("email"),
      csrfToken: formData.get("csrf_token"),
    };

    const result = schema.safeParse(data);

    if (!result.success) {
      console.error(result.error);
      alert("Invalid data");
      return;
    }

    const { email, username, csrfToken } = result.data;

    const res = await fetch("/api/updateProfile", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-CSRF-Token": csrfToken,
      },
      body: `username=${username}&email=${email}`,
    });

    if (!res.ok) {
      const data = await res.json();
      alert(data.message);
    } else {
      alert("Profile updated successfully!");
    }
  });
