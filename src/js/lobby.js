import { createClient } from "@supabase/supabase-js";
import { getUserData } from "./actions/getUserData.js";
import { client } from "./supabaseClient.js";

const path = window.location.pathname;

const segments = path.split("/");
document.getElementById("startGame").disabled = true;

export const gameId = segments[2];
export const id = await getUserData();
console.log({ id });
if (!id) {
  console.log("ERror maybe display toast or something");
}

export const gameRoom = client.channel(`game-${gameId}`, {
  config: {
    broadcast: { self: true },
    presence: {
      key: `${id}`,
    },
  },
});
const usernames = [
  "John Doe",
  "Mr. Penisman",
  "The Real Slim Shady",
  "The Fake Slim Shady",
];

const userStatus = {
  username: usernames[Math.floor(Math.random() * usernames.length)],
  user: `${id}`,
  online_at: new Date().getTime(),
};

gameRoom.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
  const presenceTrackStatus = await gameRoom.track(userStatus);
});
