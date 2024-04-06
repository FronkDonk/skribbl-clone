export async function addPlayerToGame(gameId) {
  const res = await fetch("/api/addPlayerToGame", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `gameId=${gameId}`,
  });
  if (!res.ok) {
    const data = await res.json();
    console.log(`Error: ${data.message}`);
  } else {
    const data = await res.json();
    console.log("data", data);
    return { player: data.player, gameData: data.gameRoom };
  }
}
