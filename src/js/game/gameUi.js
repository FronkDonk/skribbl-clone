export function renderScoreboard(players) {
  players.sort((a, b) => b.score - a.score);

  players.forEach((player, index) => {
    const players = document.getElementById("scoreboard");
    const existingPlayer = document.getElementById(player.id);
    if (existingPlayer) return;
    const div = `
  <div id=${
    player.id
  } class="rounded-lg border-2 bg-card text-card-foreground shadow-sm flex gap-2 p-2">
    <p class="text-4xl font-semibold">${index + 1}.</p>
    <div class="flex gap-2 items-center">
      <div>
        <p class="text-2xl font-semibold leading-none tracking-tight">
          ${player.username}
        </p>
        <p id=score-${player.id} class="text-xl font-medium text-primary">${
      player.score
    }</p>
      </div>
      <div class="relative flex h-14 w-14 shrink-0 overflow-hidden rounded-full bg-gradient-to-tr from-[#7FB2FF] to-[#FF7F7F]"></div>
    </div>
  </div>
`;

    players.insertAdjacentHTML("beforeend", div);
  });
}

export function drawingUI({ word, drawingTime }) {
  const drawDiv = document.getElementById("draw");

  const div = `
   <span class="text-xl font-semibold">Draw: </span>
  <p class="text-lg font-medium text-muted-foreground">${word}</p>
  `;

  drawDiv.innerHTML = div;
  const input = document.getElementById("message");
  input.disabled = true;

  countdown(drawingTime);
}

export function updateScore(players) {}

export function gameFinished() {}

export function countdown(seconds) {
  let remaining = seconds;
  const counterElement = document.getElementById("counter");

  const intervalId = setInterval(() => {
    counterElement.textContent = remaining;
    remaining--;

    if (remaining < 0) {
      clearInterval(intervalId);
      counterElement.textContent = "";
    }
  }, 1000);
}
