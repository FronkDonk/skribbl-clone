import { createClient } from "@supabase/supabase-js";
import { addPlayerToGame } from "../actions/addPlayerToGame.js";
import { addPrevDrawers } from "../actions/addPrevDrawers.js";
import { clearPrevDrawers } from "../actions/clearPrevDrawers.js";
import { updateEventListeners } from "./gameCanvas.js";
import { client } from "../supabaseClient.js";
import { chooseWord } from "../actions/chooseWord.js";
import { saveWord } from "../actions/saveWord.js";

const path = window.location.pathname;

const segments = path.split("/");
const gameId = segments[2];
let currentDrawerIndex = 0;
let gameIsFinished = false;
export let players = [
  /* {
    id: "2daab645-0098-465a-90c3-00d60e8641e2",
    username: "Alice",
    isDrawing: false,
    score: 0,
    isOwner: false,
  },
  {
    id: "2daab645-0098-465a-90c3-00d60e8641e3",
    username: "Bob",
    isDrawing: false,
    score: 0,
    isOwner: false,
  },
  {
    id: "2daab645-0098-465a-90c3-00d60e8641e6",
    username: "Charlie",
    isDrawing: false,
    score: 0,
    isOwner: false,
  }, */
];
export let prevDrawers = [];
export const { player, gameData } = await addPlayerToGame(gameId);
export const gameRoom = client.channel(`game-${gameId}`, {
  config: {
    broadcast: {
      self: true,
    },
    presence: {
      key: player[0].id,
    },
  },
});

const userStatus = {
  id: player[0].id,
  username: player[0].username,
  isOwner: player[0].isOwner,
  score: player[0].score,
  rounds: +gameData[0].num_rounds,
  drawingTime: +gameData[0].drawing_time,
};

gameRoom.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
  const presenceTrackStatus = await gameRoom.track(userStatus);
});

gameRoom
  .on("presence", { event: "sync" }, async () => {
    const newState = gameRoom.presenceState();
    console.log("sync", newState);

    Object.entries(newState).forEach(([key, value], i) => {
      const userExists = players.some((player) => player.id === value[0].id);

      if (!userExists) {
        players.push({
          id: value[0].id,
          index: i,
          username: value[0].username,
          isDrawing: false,
          score: value[0].score,
          isOwner: value[0].isOwner,
          isClient: value[0].id === userStatus.id,
        });
        console.log(players);
      }
      updateEventListeners();
      if (!gameIsFinished && userStatus.isOwner && players.length >= 2) {
        startGame(players);
      }
    });
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

async function startNewRound(prevDrawers) {
  if (userStatus.isOwner) {
    if (players.length >= 2) {
      const player = players.find((player) => !prevDrawers.includes(player.id));
      if (!player) {
        prevDrawers = [];
        const data = await clearPrevDrawers(gameId, userStatus.rounds);
        if (data.end) {
          console.log("all rounds have been played");
          gameIsFinished = true;
          return;
        }
      } else {
        gameRoom.send({
          type: "broadcast",
          event: "choose-word",
          payload: {
            drawerId: players[currentDrawerIndex].id,
          },
        });
        currentDrawerIndex = (currentDrawerIndex + 1) % players.length;
      }
    } else {
      console.log("game over");
      //check who has the most score
    }
  }
}

function startDrawingTime(player) {
  if (userStatus.isOwner) {
    setTimeout(async () => {
      const prevDrawers = await addPrevDrawers(gameId, player.id);
      gameRoom.send({
        type: "broadcast",
        event: "times-up",
        payload: {
          drawerId: player.id,
          previousDrawers: prevDrawers,
        },
      });
    }, userStatus.drawingTime * 1000);
  }
}
console.log({ drawingTime: userStatus.drawingTime });

gameRoom.on("broadcast", { event: "choose-word" }, async ({ payload }) => {
  console.log("choose-word", payload);
  const drawerId = payload.drawerId;
  let player = players.find((player) => player.id === drawerId);
  player.isDrawing = true;
  const words = await chooseWord();
  if (words) {
    console.log(words);
    const wordSelection = document.getElementById("wordSelection");
    for (const word of words) {
      // Create a new button element
      const button = document.createElement("button");

      // Add classes
      button.classList.add(
        "inline-flex",
        "items-center",
        "justify-center",
        "whitespace-nowrap",
        "rounded-md",
        "text-sm",
        "font-medium",
        "ring-offset-background",
        "transition-colors",
        "focus-visible:outline-none",
        "focus-visible:ring-2",
        "focus-visible:ring-ring",
        "focus-visible:ring-offset-2",
        "disabled:pointer-events-none",
        "disabled:opacity-50",
        "border",
        "border-input",
        "bg-background",
        "hover:bg-accent",
        "hover:text-accent-foreground",
        "h-10",
        "px-4",
        "py-2"
      );
      button.textContent = word;
      button.onclick = (e) => handleWordClick(e, player, drawerId);
      wordSelection.appendChild(button);
    }
  }
});

gameRoom.on("broadcast", { event: "new-round" }, async ({ payload }) => {
  console.log("new-round", payload);
  const player = payload.player;

  updateEventListeners();
  startDrawingTime(player);
});

gameRoom.on("broadcast", { event: "times-up" }, ({ payload }) => {
  console.log("times-up", payload);
  const drawerId = payload.drawerId;
  prevDrawers = payload.previousDrawers;
  let player = players.find((player) => player.id === drawerId);
  if (player) {
    player.isDrawing = false;
  }
  updateEventListeners();
  startNewRound(prevDrawers);
});

function handleWordClick(e, player, drawerId) {
  const word = e.target.textContent;
  //clear wordSelection div

  const wordSelection = document.getElementById("wordSelection");
  while (wordSelection.firstChild) {
    wordSelection.removeChild(wordSelection.firstChild);
  }
  saveWord({ word, gameId });
  gameRoom.send({
    type: "broadcast",
    event: "new-round",
    payload: {
      drawerId: drawerId,
      player: player,
    },
  });
}
