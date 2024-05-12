import { addPrevDrawers } from "../actions/addPrevDrawers.js";
import { clearPrevDrawers } from "../actions/clearPrevDrawers.js";
import { updateEventListeners } from "./gameCanvas.js";
import { client } from "../supabaseClient.js";
import { chooseWord } from "../actions/chooseWord.js";
import { saveWord } from "../actions/saveWord.js";
import { getPlayer } from "../actions/getPlayer.js";
import { getGameData } from "../actions/getGameData.js";
import { countdown, drawingUI, renderScoreboard } from "./gameUi.js";
const path = window.location.pathname;
export const scoreboard = document.getElementById("scoreboard");

const segments = path.split("/");
const gameId = segments[2];
let currentDrawerIndex = 0;
let gameIsFinished = false;
export let correctGuesses = [];
export let players = [];
export let prevDrawers = [];
export let clientPlayer;
export let timer;
export let roundFinsihedEarly = false;
export let roundState = "not-started";

export function setRoundFinsihedEarly() {
  roundFinsihedEarly = false;
}

const [player, gameData] = await Promise.all([
  getPlayer(),
  getGameData({ gameId }),
]);

export const gameRoom = client.channel(`game-${gameId}`, {
  config: {
    broadcast: {
      self: true,
    },
    presence: {
      key: player.id,
    },
  },
});

export const userStatus = {
  id: player.id,
  username: player.username,
  isOwner: player.is_owner,
  score: player.score,
  rounds: +gameData.num_rounds,
  drawingTime: +gameData.drawing_time,
};

gameRoom.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
  await gameRoom.track(userStatus);
});

gameRoom
  .on("presence", { event: "sync" }, async () => {
    const newState = gameRoom.presenceState();
    console.log("sync", newState);

    for (const [key, value] of Object.entries(newState)) {
      const userExists = players.some((player) => player.id === value[0].id);

      if (!userExists) {
        players.push({
          id: value[0].id,
          username: value[0].username,
          isDrawing: false,
          score: value[0].score,
          isOwner: value[0].isOwner,
          isClient: value[0].id === userStatus.id,
        });
        console.log(players);
        clientPlayer = players.find((player) => player.isClient === true);
      }

      renderScoreboard(players);
      updateEventListeners();
      if (!gameIsFinished && userStatus.isOwner && players.length >= 2) {
        startGame(players);
      }
    }
  })
  .on("presence", { event: "join" }, ({ key, newPresences }) => {
    console.log("join", key, newPresences);
  })
  .on("presence", { event: "leave" }, ({ key, leftPresences }) => {
    console.log("leave", key, leftPresences);
    players = players.filter((player) => player.id !== key);

    //check if the owner left the game
    //check if the the player drawing left the game
  });

function startGame(players) {
  if (userStatus.isOwner && players.length >= 2) {
    if (currentDrawerIndex < players.length) {
      gameRoom.send({
        type: "broadcast",
        event: "choose-word",
        payload: {
          drawerId: players[currentDrawerIndex].id,
        },
      });
      currentDrawerIndex = (currentDrawerIndex + 1) % players.length;
    } else {
      console.log("not enough players");
    }
  }
}

async function startNewRound(prevDrawers) {
  roundState = "not-started";
  if (userStatus.isOwner) {
    clearTimeout(timer);
    if (players.length >= 2) {
      const player = players.find((player) => !prevDrawers.includes(player.id));
      if (!player) {
        prevDrawers = [];
        try {
          const data = await clearPrevDrawers(gameId, userStatus.rounds);
          if (data.end) {
            console.log("all rounds have been played");
            gameIsFinished = true;
            gameRoom.send({
              type: "broadcast",
              event: "finished",
            });
            return;
          }
        } catch (error) {
          console.error("Error clearing previous drawers:", error);
          return;
        }
      }
      gameRoom.send({
        type: "broadcast",
        event: "choose-word",
        payload: {
          drawerId: players[currentDrawerIndex].id,
        },
      });
      currentDrawerIndex = (currentDrawerIndex + 1) % players.length;
    } else {
      console.log("game over");
      //check who has the most score
    }
  }
}

function startDrawingTime(player) {
  roundState = "in-progress";
  if (userStatus.isOwner) {
    timer = setTimeout(async () => {
      if (roundState === "in-progress") {
        timesUp();
      }
    }, userStatus.drawingTime * 1000);
  }
}
console.log({ drawingTime: userStatus.drawingTime });

gameRoom.on("broadcast", { event: "choose-word" }, async ({ payload }) => {
  console.log("choose-word", payload);
  const wordSelection = document.getElementById("wordSelection");
  wordSelection.innerHTML = "";
  const drawerId = payload.drawerId;

  players.forEach((player) => {
    player.isDrawing = false;
  });

  let player = players.find((player) => player.id === drawerId);
  player.isDrawing = true;

  if (clientPlayer && clientPlayer.id === drawerId && player.isDrawing) {
    const words = await chooseWord();
    if (words) {
      wordSelection.innerHTML = "";
      for (const word of words) {
        const button = document.createElement("button");
        button.className =
          "h-10 px-4 py-2 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground";
        button.textContent = word;

        // Add the onclick event to the button
        button.onclick = (e) => handleWordClick(e, player, drawerId);

        // Append the button to the wordSelection
        wordSelection.appendChild(button);
      }
    }
  }
});

gameRoom.on("broadcast", { event: "new-round" }, async ({ payload }) => {
  const input = document.getElementById("message");
  input.disabled = false;
  console.log("new-round", payload);
  const player = payload.player;
  updateEventListeners();
  startDrawingTime(player);
  countdown(userStatus.drawingTime);
});

gameRoom.on("broadcast", { event: "times-up" }, ({ payload }) => {
  const drawDiv = document.getElementById("draw");
  drawDiv.innerHTML = "";
  correctGuesses = [];
  console.log("times-up", payload);
  prevDrawers = payload.previousDrawers;
  const drawerId = payload.drawerId;
  let player = players.find((player) => player.id === drawerId);
  if (player) {
    player.isDrawing = false;
  }
  updateEventListeners();
  startNewRound(prevDrawers);
});

gameRoom.on("broadcast", { event: "finished" }, ({ payload }) => {
  if (userStatus.isOwner) {
  }
  const finishedDiv = document.getElementById("gameFinished");

  finishedDiv.style.display = "block";

  const sortedPlayers = players.sort((a, b) => b.score - a.score);

  const winner = sortedPlayers[0].username;

  const div = `
  
  `;
});

function handleWordClick(e, player, drawerId) {
  const word = e.target.textContent;
  drawingUI({ word, drawingTime: userStatus.drawingTime });
  saveWord({ word, gameId });
  gameRoom.send({
    type: "broadcast",
    event: "new-round",
    payload: {
      drawerId: drawerId,
      player: player,
    },
  });

  const wordSelection = document.getElementById("wordSelection");

  wordSelection.innerHTML = "";
}

export async function timesUp() {
  console.log("times up");
  if (roundState === "in-progress") {
    roundState = "finished";
    correctGuesses = [];
    console.log("times up");
    let player = players.find((player) => player.isDrawing === true);
    const prevDrawers = await addPrevDrawers(gameId, player.id);
    gameRoom.send({
      type: "broadcast",
      event: "times-up",
      payload: {
        previousDrawers: prevDrawers,
        drawerId: player.id,
      },
    });
  }
}
