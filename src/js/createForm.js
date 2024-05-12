import * as z from "zod";

const schema = z.object({
  username: z.string().min(1).max(20),
});

document
  .getElementById("create-form")
  .addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(this); // Create a FormData object from the form
    const userData = {
      username: formData.get("username"),
    };

    const result = schema.safeParse(userData);

    if (!result.success) {
      alert("Invalid data");
      console.error(result.error);
      return;
    }

    const res = await fetch("/api/create-game", {
      method: "POST",
      body: formData,
    });

    if (!res.ok) {
      alert("Failed to create game");
      console.error("Failed to create game");
      return;
    }

    const { gameId } = await res.json();

    window.location.href = `/new-game/${gameId}`;
  });
