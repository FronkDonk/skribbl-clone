import { createClient } from "https://cdn.skypack.dev/@supabase/supabase-js";
const client = createClient(
  "https://wzqbaxbadiqwdodpcglt.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Ind6cWJheGJhZGlxd2RvZHBjZ2x0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTEyODI2NDAsImV4cCI6MjAyNjg1ODY0MH0.edflXOAsbKYV7nuIQaGteGsAbdFaRjB64PyP0uRKnxw"
);

const myChannel = client.channel("room-1");

myChannel.subscribe((status) => {
  if (status !== "SUBSCRIBED") {
    return null;
  }
});
const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

// Set the canvas size to fill the window
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let x = 0;
let y = 0;

myChannel.on("broadcast", { event: "start-drawing" }, ({ payload }) => {
  console.log("start-position", payload);
  x = payload.x;
  y = payload.y;
});

myChannel.on("broadcast", { event: "drawing" }, ({ payload }) => {
  console.log("clientx", payload.clientX);
  console.log("clienty", payload.clientY);

  ctx.beginPath();
  ctx.moveTo(x, y);
  ctx.lineTo(payload.clientX, payload.clientY);
  ctx.stroke();
  x = payload.clientX;
  y = payload.clientY;
});
