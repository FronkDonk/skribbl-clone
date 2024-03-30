import { createClient } from "https://cdn.skypack.dev/@supabase/supabase-js";
const client = createClient(
  "https://wzqbaxbadiqwdodpcglt.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Ind6cWJheGJhZGlxd2RvZHBjZ2x0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTEyODI2NDAsImV4cCI6MjAyNjg1ODY0MH0.edflXOAsbKYV7nuIQaGteGsAbdFaRjB64PyP0uRKnxw"
);
const roomOne = client.channel("room-01", {
  config: {
    broadcast: { self: true },
  },
});

roomOne
  .on("presence", { event: "sync" }, () => {
    const newState = roomOne.presenceState();
    console.log("sync", newState);
  })
  .on("presence", { event: "join" }, ({ key, newPresences }) => {
    console.log("join", key, newPresences);
  })
  .on("presence", { event: "leave" }, ({ key, leftPresences }) => {
    console.log("leave", key, leftPresences);
  })
  .subscribe();
