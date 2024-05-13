import * as z from "zod";

const schema = z.object({
  password: z.string(),
});

document
  .getElementById("delete-account")
  .addEventListener("submit", async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const data = {
      password: formData.get("delete"),
    };

    const result = schema.safeParse(data);

    if (!result.success) {
      alert("invalid data");
      console.error(result.error);
    }
    const { password } = result.data;
    const res = await fetch("/api/deleteAccount", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
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
