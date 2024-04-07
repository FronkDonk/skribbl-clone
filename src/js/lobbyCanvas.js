import { client } from "./supabaseClient.js";
import { gameId } from "./lobby.js";
const lobbyCanvas = client.channel(`lobbyCanvas-${gameId}`, {
  config: {
    /* presence: {
      key: `${id ? id : "unknown"}`,
    }, */
  },
});
lobbyCanvas.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
});

let drawingCommands = [];

const canvas = document.getElementById("playerCanvas");
const ctx = canvas.getContext("2d");

// Set initial canvas dimensions
canvas.width = canvas.offsetWidth;
canvas.height = canvas.offsetHeight;

// Update canvas dimensions when window size changes
window.addEventListener("resize", () => {
  const tempCommands = [...drawingCommands];
  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
  drawingCommands = [...tempCommands];
  replay();
});

let drawing = false;
let x = 0;
let y = 0;

// Function to start drawing
function startDrawing(e) {
  drawing = true;
  const rect = canvas.getBoundingClientRect();
  x = (e.clientX - rect.left) / rect.width; // Normalize x
  y = (e.clientY - rect.top) / rect.height; // Normalize y
  drawingCommands.push({ type: "start", x, y });
  lobbyCanvas.send({
    type: "broadcast",
    event: "start-drawing",
    payload: {
      x: x,
      y: y,
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
  const rect = canvas.getBoundingClientRect();
  const newX = (e.clientX - rect.left) / rect.width; // Normalize x
  const newY = (e.clientY - rect.top) / rect.height; // Normalize y
  ctx.beginPath();
  ctx.moveTo(x * rect.width, y * rect.height); // Scale x and y
  ctx.lineTo(newX * rect.width, newY * rect.height); // Scale newX and newY
  ctx.stroke();
  x = newX;
  y = newY;
  drawingCommands.push({ type: "line", x, y });
  lobbyCanvas.send({
    type: "broadcast",
    event: "drawing",
    payload: {
      clientX: x,
      clientY: y,
    },
  });
}

function replay() {
  for (let command of drawingCommands) {
    if (command.type === "start") {
      x = command.x;
      y = command.y;
    } else if (command.type === "line") {
      ctx.beginPath();
      ctx.moveTo(x, y);
      ctx.lineTo(command.x, command.y);
      ctx.stroke();
      x = command.x;
      y = command.y;
    }
  }
}

lobbyCanvas.on("broadcast", { event: "start-drawing" }, ({ payload }) => {
  console.log("start-position", payload);
  x = payload.x;
  y = payload.y;
});

lobbyCanvas.on("broadcast", { event: "move-cursor" }, ({ payload }) => {
  console.log("move-cursor", payload);
});

lobbyCanvas.on("broadcast", { event: "drawing" }, ({ payload }) => {
  const rect = canvas.getBoundingClientRect();
  const newX = payload.clientX * rect.width; // Scale x
  const newY = payload.clientY * rect.height; // Scale y
  ctx.beginPath();
  ctx.moveTo(x * rect.width, y * rect.height); // Scale x and y
  ctx.lineTo(newX, newY);
  ctx.stroke();
  x = payload.clientX;
  y = payload.clientY;
});

canvas.addEventListener("mousedown", startDrawing);
canvas.addEventListener("mouseup", stopDrawing);
canvas.addEventListener("mouseout", stopDrawing);
canvas.addEventListener("mousemove", draw);
