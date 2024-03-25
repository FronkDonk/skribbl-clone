import { createClient } from "https://cdn.skypack.dev/@supabase/supabase-js";
const client = createClient(
  "https://wzqbaxbadiqwdodpcglt.supabase.co",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Ind6cWJheGJhZGlxd2RvZHBjZ2x0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MTEyODI2NDAsImV4cCI6MjAyNjg1ODY0MH0.edflXOAsbKYV7nuIQaGteGsAbdFaRjB64PyP0uRKnxw"
);

const myChannel = client.channel("room-1", {
  /*  config: {
    broadcast: { self: true },
  }, */
});

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

// Variables to keep track of the drawing state
let drawing = false;
let x = 0;
let y = 0;

// Function to start drawing
function startDrawing(e) {
  drawing = true;
  x = e.clientX;
  y = e.clientY;
  myChannel.send({
    type: "broadcast",
    event: "start-drawing",
    payload: {
      x: e.clientX,
      y: e.clientY,
    },
  });
}

// Function to stop drawing
function stopDrawing() {
  drawing = false;
}

// Function to draw on the canvas
function draw(e) {
  if (!drawing) return;
  ctx.beginPath();
  ctx.moveTo(x, y);
  ctx.lineTo(e.clientX, e.clientY);
  console.log(e.clientX, e.clientY);
  ctx.stroke();
  x = e.clientX;
  y = e.clientY;
  myChannel.send({
    type: "broadcast",
    event: "drawing",
    payload: {
      clientX: e.clientX,
      clientY: e.clientY,
    },
  });
}

// Event listeners for the mouse events
canvas.addEventListener("mousedown", startDrawing);
canvas.addEventListener("mouseup", stopDrawing);
canvas.addEventListener("mouseout", stopDrawing);
canvas.addEventListener("mousemove", draw);
