export function ownerOrPlayerView(players) {
  console.log("onwerOrPlayerView", players)
  const owner = players.find(
    (player) => player.owner === true && player.isClient === true
  );
  console.log("owner", owner);
  const ownerView = document.getElementById("ownerView");
  const playerView = document.getElementById("playerView");
  if (owner) {
    ownerView.style.display = "flex";
    playerView.style.display = "none";
  } else if (!owner) {
    ownerView.style.display = "none";
    playerView.style.display = "block";
  }
}

export function enableStartButton(players) {
  if (players.length === 2) {
    document.getElementById("startGame").disabled = false;
  }
}

export async function renderOnlineUsers(players) {
  let elements = document.getElementsByClassName("onlineUsers");
  for (let i = 0; i < elements.length; i++) {
    elements[i].innerHTML = "";
  }
  console.log("players", players);
  players.forEach(async (player) => {
    const response = await fetch("/api/renderOnlineUsers", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `owner=${encodeURIComponent(
        player.owner
      )}&username=${encodeURIComponent(
        player.username
      )}&isClient=${encodeURIComponent(player.isClient)}`,
    });

    if (!response.ok) {
      console.error("Failed to fetch rendered HTML");
      return;
    }

    const html = await response.text();

    // Insert the rendered HTML at the end of the chat messages container
    for (let i = 0; i < elements.length; i++) {
      elements[i].insertAdjacentHTML("beforeend", html);
    }
  });
}
