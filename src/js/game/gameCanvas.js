import { client } from "../supabaseClient";
import { players } from "./gamePresence";

const path = window.location.pathname;

const segments = path.split("/");
const gameId = segments[2];

const gameCanvas = client.channel(`gameCanvas-${gameId}`, {});
gameCanvas.subscribe(async (status) => {
  if (status !== "SUBSCRIBED") {
    return;
  }
});

let drawingCommands = [];

const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");
const section = document.querySelector("section");

// Set initial canvas dimensions
canvas.width = canvas.offsetWidth;
canvas.height = canvas.offsetHeight;

window.onload = function () {
  section.style.maxHeight = `${canvas.offsetHeight}px`;
};

// Update canvas dimensions when window size changes
window.addEventListener("resize", () => {
  const tempCommands = [...drawingCommands];
  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
  section.style.maxHeight = `${canvas.offsetHeight}px`;
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
  gameCanvas.send({
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
  gameCanvas.send({
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

gameCanvas.on("broadcast", { event: "start-drawing" }, ({ payload }) => {
  console.log("start-position", payload);
  x = payload.x;
  y = payload.y;
});

/* gameCanvas.on("broadcast", { event: "move-cursor" }, ({ payload }) => {
  console.log("move-cursor", payload);
}); */

gameCanvas.on("broadcast", { event: "drawing" }, ({ payload }) => {
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

export function updateEventListeners() {
  // First, remove all existing event listeners
  canvas.removeEventListener("mousedown", startDrawing);
  canvas.removeEventListener("mouseup", stopDrawing);
  canvas.removeEventListener("mouseout", stopDrawing);
  canvas.removeEventListener("mousemove", draw);

  const clientPlayer = players.find((player) => player.isClient === true);

  // Then, if the client player is drawing, add the event listeners
  if (clientPlayer && clientPlayer.isDrawing) {
    console.log("you are drawing");
    canvas.addEventListener("mousedown", startDrawing);
    canvas.addEventListener("mouseup", stopDrawing);
    canvas.addEventListener("mouseout", stopDrawing);
    canvas.addEventListener("mousemove", draw);
  }
}
