//if user is owner send req to save game id in redis

import { getPlayer } from "../actions/getPlayer.js";
import { client } from "../supabaseClient.js";

export const newGameForm = document.getElementById("new-game-form");
newGameForm.style.pointerEvents = "none";
newGameForm.style.opacity = 0.5;

const path = window.location.pathname;

const segments = path.split("/");
document.getElementById("startGame").disabled = true;

export const gameId = segments[2];

const data = await getPlayer();
if (!data) {
  console.log("ERror maybe display toast or something");
}

export const id = data.id;

export const gameRoom = client.channel(`game-${gameId}`, {
  config: {
    broadcast: { self: true },
    presence: {
      key: `${data.id}`,
    },
  },
});

const userStatus = {
  username: data.username,
  user: data.id,
  online_at: new Date().getTime(),
};

gameRoom.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
  await gameRoom.track(userStatus);
});
