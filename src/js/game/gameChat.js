import * as z from "zod";
import { player } from "./gamePresence";
import { gameRoom } from "./gamePresence";

const chatMessage = z.object({
  message: z.string(),
  roomId: z.string().uuid(),
  userId: z.string().uuid(),
  username: z.string(),
  sentAt: z.string(),
});

const path = window.location.pathname;

const segments = path.split("/");
export const gameId = segments[2];

document
  .getElementById("myForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault();

    const data = {
      message: formData.get("message"),
      roomId: gameId,
      userId: player[0].id,
      username: player[0].username,
      sentAt: new Date().toISOString(),
    };

    const result = chatMessage.safeParse(data);

    if (!result.success) {
      console.error(message.error);
      return;
    }

    const { message, userId, username, sentAt } = result.data;
    //save message to database
    gameRoom.send({
      type: "broadcast",
      event: "new-message",
      payload: {
        message,
        username,
        userId,
        sentAt,
      },
    });
  });

gameRoom.on("broadcast", { event: "new-message" }, ({ payload }) => {
  console.log("new-message");

  const message = payload.message;
  const username = payload.username;
  const userId = payload.userId;
  const sentAt = payload.sentAt;

  //call renderMessage.php

  // Add message to chat
});
