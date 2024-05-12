import * as z from "zod";

const schema = z.object({
  gameId: z.string().length(6),
  username: z.string().min(1).max(20),
});

document
  .getElementById("join-form")
  .addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(this); // Create a FormData object from the form
    const userData = {
      gameId: formData.get("gameId"),
      username: formData.get("username"),
    };

    const result = schema.safeParse(userData);

    if (!result.success) {
      console.error(result.error);
      return;
    }

    const res = await fetch("/api/join-game", {
      method: "POST",
      body: formData,
    });

    if (!res.ok) {
      console.error("Failed to join game");
      return;
    }

    window.location.href = `/new-game/${userData.gameId}`;
  });
