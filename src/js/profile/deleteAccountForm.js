import * as z from "zod";

const schema = z.object({
  password: z.string(),
  csrfToken: z.string(),
});

document
  .getElementById("delete-account")
  .addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const data = {
      password: formData.get("delete"),
      csrfToken: formData.get("csrf_Token"),
    };

    const result = schema.safeParse(data);

    if (!result.success) {
      alert("invalid data");
      console.error(result.error);
    }
    const { password, csrfToken } = result.data;
    const res = await fetch("/api/deleteAccount", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
        "X-CSRF-Token": csrfToken,
      },
      body: `password=${password}`,
    });

    if (!res.ok) {
      const data = await res.json();
      alert(data.message);
    } else {
      alert("Account deleted successfully!");

      window.location.href = "/";
    }
  });
