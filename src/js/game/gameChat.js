import * as z from "zod";
import {
  correctGuesses,
  player,
  players,
  roundFinsihedEarly,
  setRoundFinsihedEarly,
  timer,
  timesUp,
  userStatus,
} from "./gamePresence";
import { saveChatMessage, sendChatMessage } from "../actions/saveChatMessage";
import { client } from "../supabaseClient";
import { guessIsCorrect } from "../actions/guessIsCorrect";
import { renderScoreboard } from "./gameUi";

if (!client) {
  console.log("client is not defined");
}
const chatMessage = z.object({
  message: z.string(),
  gameId: z.string().length(6),
  userId: z.string().uuid(),
  username: z.string(),
  sentAt: z.string(),
  avatar: z.string(),
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
      userId: userStatus.id,
      username: userStatus.username,
      avatar: userStatus.avatar,
      sentAt: new Date().toISOString(),
    };

    const result = chatMessage.safeParse(data);

    if (!result.success) {
      console.error(result.error);
      return;
    }

    const { message, userId, username, sentAt, avatar } = result.data;

    const chat = document.getElementById("chat");
    const input = document.getElementById("message");
    input.value = "";

    const div = `
  <div id="message-${sentAt}" class="p-2 bg-muted rounded-md flex items-center gap-2">

  <div class="relative flex flex-col gap-2 h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-tr ${avatar}"></div>
      <div class="flex flex-col gap-px ">
          <label class="text-base">${username}</label>
          <p class="text-sm ">${message}</p>
      </div>
  </div>
  </div>
`;

    chat.insertAdjacentHTML("beforeend", div);

    const [_, isCorrect] = await Promise.all([
      saveChatMessage({ message, userId, username, sentAt, gameId }),
      guessIsCorrect({ message, gameId }),
    ]);

    gameChat.send({
      type: "broadcast",
      event: "new-message",
      payload: {
        message,
        username,
        userId,
        isCorrect,
        sentAt,
        avatar,
      },
    });

    if (isCorrect) {
      console.log("correct guess");
      const playerScore = document.getElementById(`score-${userId}`);
      players.find((player) => player.id === userId).score += 100;
      correctGuesses.push(userId);
      console.log(correctGuesses);
      if (correctGuesses.length === players.length - 1) {
        timesUp();
      }
      renderScoreboard(players);

      playerScore.textContent = Number(playerScore.textContent) + 100;

      const messageElement = document.getElementById(`message-${sentAt}`);
      messageElement.style.border = "2px solid #26c281";
    } else {
      console.log("incorrect guess");
    }
  });

gameChat.on("broadcast", { event: "new-message" }, ({ payload }) => {
  console.log("new-message");

  const { message, username, userId, isCorrect, sentAt, avatar } = payload;

  const chat = document.getElementById("chat");

  const div = `<div id="message-${sentAt}" class="${
    isCorrect && "border-primary"
  } p-2 border bg-muted rounded-md flex items-center gap-2">
    <div class="relative flex flex-col gap-2 h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-tr ${avatar}"></div>
        <div class="flex flex-col gap-px ">
            <label class="text-base">${username}</label>
            <p class="text-sm ">${isCorrect ? "guessed the word" : message}</p>
        </div>
    </div>
  </div>`;

  chat.insertAdjacentHTML("beforeend", div);

  if (isCorrect) {
    console.log("correct guess");
    const playerScore = document.getElementById(`score-${userId}`);
    players.find((player) => player.id === userId).score += 100;
    correctGuesses.push(userId);
    renderScoreboard(players);
    playerScore.textContent = Number(playerScore.textContent) + 100;

    const messageElement = document.getElementById(`message-${sentAt}`);
    messageElement.style.border = "2px solid #26c281";
  } else {
    console.log("incorrect guess");
  }
});
