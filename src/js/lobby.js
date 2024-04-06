import { createClient } from "@supabase/supabase-js";
import { getUserData } from "./actions/getUserData.js";

export const client = createClient(
  "https://wzqbaxbadiqwdodpcglt.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Ind6cWJheGJhZGlxd2RvZHBjZ2x0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTEyODI2NDAsImV4cCI6MjAyNjg1ODY0MH0.edflXOAsbKYV7nuIQaGteGsAbdFaRjB64PyP0uRKnxw"
);

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
