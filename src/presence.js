import { createClient } from "https://cdn.skypack.dev/@supabase/supabase-js";
const client = createClient(
  "https://wzqbaxbadiqwdodpcglt.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Ind6cWJheGJhZGlxd2RvZHBjZ2x0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTEyODI2NDAsImV4cCI6MjAyNjg1ODY0MH0.edflXOAsbKYV7nuIQaGteGsAbdFaRjB64PyP0uRKnxw"
);

const myChannel = client.channel("room-01", {
  config: {
    broadcast: { self: true },
  },
});

const userStatus = {
  user: "user-1",
  online_at: new Date().toISOString(),
};
myChannel.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }

  const presenceTrackStatus = await myChannel.track(userStatus);
  console.log(presenceTrackStatus);
});


