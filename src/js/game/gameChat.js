import * as z from "zod";
import { player } from "./gamePresence";
import { saveChatMessage, sendChatMessage } from "../actions/saveChatMessage";
import { renderChatMessage } from "../actions/renderChatMessage";
import { client } from "../supabaseClient";
import { guessIsCorrect } from "../actions/guessIsCorrect";

if (!client) {
  console.log("client is not defined");
}
const chatMessage = z.object({
  message: z.string(),
  gameId: z.string().uuid(),
  userId: z.string().uuid(),
  username: z.string(),
  sentAt: z.string(),
});

const path = window.location.pathname;

const segments = path.split("/");
const gameId = segments[2];

const gameChat = client.channel(`gameChat-${gameId}`, {});
gameChat.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
});
document
  .getElementById("guessForm")
  .addEventListener("submit", async function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    const data = {
      message: formData.get("message"),
      gameId: gameId,
      userId: player[0].id,
      username: player[0].username,
      sentAt: new Date().toISOString(),
    };

    const result = chatMessage.safeParse(data);

    if (!result.success) {
      console.error(result.error);
      return;
    }

    const { message, userId, username, sentAt, roomId } = result.data;
    gameChat.send({
      type: "broadcast",
      event: "new-message",
      payload: {
        message,
        username,
        userId,
        sentAt,
      },
    });

    const [_, html, isCorrect] = await Promise.all([
      saveChatMessage({ message, userId, username, sentAt, gameId }),
      renderChatMessage({ message, userId, username, sentAt }),
      guessIsCorrect({ message, gameId }),
    ]);

    if (isCorrect) {
      console.log("correct guess");
    } else {
      console.log("incorrect guess");
    }

    const chat = document.getElementById("chat");

    chat.insertAdjacentHTML("beforeend", html);
  });

gameChat.on("broadcast", { event: "new-message" }, async ({ payload }) => {
  console.log("new-message");

  const message = payload.message;
  const username = payload.username;
  const userId = payload.userId;
  const sentAt = payload.sentAt;

  const html = await renderChatMessage({ message, userId, username, sentAt });

  const chat = document.getElementById("chat");

  chat.insertAdjacentHTML("beforeend", html);
});
