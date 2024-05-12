import { newGameForm } from "./lobby";

export function ownerOrPlayerView(players) {
  const owner = players.find(
    (player) => player.owner === true && player.isClient === true
  );

  if (owner) {
    newGameForm.style.pointerEvents = "auto";
    newGameForm.style.opacity = 1;
  }
}

export function enableStartButton(players) {
  console.log("enableStartButton", players);
  if (players.length >= 2) {
    document.getElementById("startGame").disabled = false;
  }
}

export async function renderOnlineUsers(players) {
  players.forEach(async (player) => {
    const players = document.getElementById("players");
    const existingPlayer = document.getElementById(player.user);
    if (existingPlayer) return;
    const div = `
   <article id=${player.user} class="flex px-2 py-1 items-center gap-2 border-2 border-input rounded-lg">
        <div class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-gradient-to-tr from-[#7FB2FF] to-[#FF7F7F]">
        </div>
          <p class="font-medium text-lg">${player.username}</p>
    </article>
`;

    players.insertAdjacentHTML("beforeend", div);
  });
}
