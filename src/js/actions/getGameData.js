export async function getGameData({ gameId }) {
  const res = await fetch("/api/getGameData", {
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
    const { gameData } = await res.json();

    return gameData;
  }
}
