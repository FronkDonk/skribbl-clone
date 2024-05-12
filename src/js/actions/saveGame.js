export async function saveChatMessage({ gameId }) {
  const res = await fetch("/api/saveGame", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `gameId=${gameId}`,
  });

  const data = await res.json();
  return data.success;
}
