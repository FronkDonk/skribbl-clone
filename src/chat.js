import { createClient } from "https://cdn.skypack.dev/@supabase/supabase-js";

/* import { createClient } from "@supabase/supabase-js";
 */ const supabase = createClient(
  "https://wzqbaxbadiqwdodpcglt.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Ind6cWJheGJhZGlxd2RvZHBjZ2x0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTEyODI2NDAsImV4cCI6MjAyNjg1ODY0MH0.edflXOAsbKYV7nuIQaGteGsAbdFaRjB64PyP0uRKnxw"
);

const messages = [];

const chatRoom = supabase.channel("chatRoom-01", {
  config: {
    broadcast: { self: true },
  },
});

chatRoom.subscribe((status) => {
  if (status !== "SUBSCRIBED") {
    return null;
  }
});

const userStatus = {
  user: `user${Math.random() * 1000}`,
  online_at: new Date().toISOString(),
};
const presenceTrackStatus = await chatRoom.track(userStatus);

chatRoom
  .on("presence", { event: "sync" }, () => {
    const newState = chatRoom.presenceState();
    console.log("sync", newState);
  })
  .on("presence", { event: "join" }, ({ key, newPresences }) => {
    console.log("join", key, newPresences);
  })
  .on("presence", { event: "leave" }, ({ key, leftPresences }) => {
    console.log("leave", key, leftPresences);
  });

chatRoom.on("broadcast", { event: "new-message" }, async ({ payload }) => {
  const response = await fetch("renderMessage.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${encodeURIComponent(
      payload.message
    )}&username=${encodeURIComponent("player51")}`,
  });

  if (!response.ok) {
    console.error("Failed to fetch rendered HTML");
    return;
  }

  const html = await response.text();

  // Insert the rendered HTML at the end of the chat messages container
  chatMessages.insertAdjacentHTML("beforeend", html);
});

/*
supabase
  .channel("room_messages", {
    config: {
      broadcast: { self: false },
    },
  })
  .on(
    "postgres_changes",
    {
      event: "INSERT",
      schema: "public",
      table: "room_messages",
    },
    (payload) => {
      console.log("Change received!", payload);
    }
  )
  .subscribe(); */

// Fetch messages from the server
const response = await fetch("fetchChatMessages.php");

// Check if the request was successful
if (!response.ok) {
  console.error("Failed to fetch messages");
}

// Parse the JSON response
const data = await response.json();

// Add the messages to the messages array
console.log(data);
messages.push(...data.messages);

const chatMessages = document.getElementById("chatMessages");

messages.forEach(async (message) => {
  const response = await fetch("renderMessage.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${encodeURIComponent(
      message.message
    )}&username=${encodeURIComponent("player51")}`,
  });

  if (!response.ok) {
    console.error("Failed to fetch rendered HTML");
    return;
  }

  const html = await response.text();

  // Insert the rendered HTML at the end of the chat messages container
  chatMessages.insertAdjacentHTML("beforeend", html);
});

document.querySelector("form").addEventListener("submit", async (e) => {
  e.preventDefault();

  const message = document.getElementById("message").value;

  const response = await fetch("renderMessage.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${encodeURIComponent(message)}&username=${encodeURIComponent(
      "player51"
    )}`,
  });

  if (!response.ok) {
    console.error("Failed to fetch rendered HTML");
    return;
  }

  const html = await response.text();

  // Insert the rendered HTML at the end of the chat messages container
  chatMessages.insertAdjacentHTML("beforeend", html);

  chatRoom.send({
    type: "broadcast",
    event: "new-message",
    payload: {
      message,
    },
  });
  const { error } = await supabase.from("room_messages").insert({
    message,
  });
});
