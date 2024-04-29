import * as z from "zod";
import { player } from "./gamePresence";
import { saveChatMessage, sendChatMessage } from "../actions/saveChatMessage";
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

    const chat = document.getElementById("chat");
    const input = document.getElementById("message");
    const div = `
  <div class="p-2 bg-muted rounded-md flex items-center gap-2">

  <div class="relative flex flex-col gap-2 h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-tr from-[#7FB2FF] to-[#FF7F7F]"></div>

      <div class="flex flex-col gap-px ">
          <label class="text-base">${username}</label>
     

      <p class="text-sm ">${message}</p>
       </div>
  </div>
  </div>
`;

    chat.insertAdjacentHTML("beforeend", div);
    input.value = "";

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

    const [_, isCorrect] = await Promise.all([
      saveChatMessage({ message, userId, username, sentAt, gameId }),
      guessIsCorrect({ message, gameId }),
    ]);

    if (isCorrect) {
      console.log("correct guess");
    } else {
      console.log("incorrect guess");
    }
  });

gameChat.on("broadcast", { event: "new-message" }, ({ payload }) => {
  console.log("new-message");

  const message = payload.message;
  const username = payload.username;
  const userId = payload.userId;
  const sentAt = payload.sentAt;

  const chat = document.getElementById("chat");

  const div = `
  <div class="p-2 bg-muted rounded-md flex items-center gap-2">

  <div class="relative flex flex-col gap-2 h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-tr from-[#7FB2FF] to-[#FF7F7F]"></div>

      <div class="flex flex-col gap-px ">
          <label class="text-base">${username}</label>
     

      <p class="text-sm ">${message}</p>
       </div>
  </div>
  </div>
`;

  chat.insertAdjacentHTML("beforeend", div);
});
