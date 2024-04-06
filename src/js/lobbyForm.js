import * as z from "zod";
import { players } from "./lobbyPresence.js";
import { id as userId } from "./lobby.js";

const schema = z.object({
  maxPlayers: z.enum(["2", "4", "6", "8"]),
  numRounds: z.enum(["3", "6", "8"]),
  drawingTime: z.enum(["20", "40", "60", "80"]),
  visibility: z.enum(["Public", "Private"]),
  gameId: z.string().uuid(),
  ownerId: z.string().uuid(),
  players: z
    .array(
      z.object({
        isClient: z.boolean(),
        owner: z.boolean(),
        user: z.string().uuid(),
      })
    )
    .refine((players) => {
      // Check if there's at least one player who is the client and the owner
      if (players.length < 2) return false;
      const clientOwner = players.find(
        (player) => player.isClient && player.owner
      );
      // Check if the player's id matches the current client's id
      // Replace 'currentClientId' with the actual id of the current client
      return clientOwner && clientOwner.user === userId;
    }),
});

const id = window.location.pathname.split("/")[2];
document
  .getElementById("myForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Prevent the form from being submitted normally

    const formData = new FormData(this); // Create a FormData object from the form
    formData.append("ownerId", userId);
    formData.append("gameId", id);
    const data = {
      maxPlayers: formData.get("selectedValue-maxPlayers"),
      numRounds: formData.get("selectedValue-numRounds"),
      drawingTime: formData.get("selectedValue-drawingTime"),
      visibility: formData.get("selectedValue-visibility"),
      gameId: formData.get("gameId"),
      ownerId: formData.get("ownerId"),
      players: players,
    };

    const result = schema.safeParse(data);
    console.log(result);
    if (!result.success) {
      console.error(result.error);
      return;
    }
    console.log("maxPlayers zod", result.data.maxPlayers);
    const res = await fetch("/api/new-game", {
      method: "POST",
      body: formData,
    });
    if (!res.ok) {
      const data = await res.json();
      console.error(data);
    } else {
      const data = await res.json();
      console.log(data);
      // Log the response body to the console
      /* console.log(data[0].id);
      window.location.href = `/lobby/${data[0].id}`; */
    }
  });
