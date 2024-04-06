export async function clearPrevDrawers(gameId, rounds) {
  const res = await fetch("/api/clearPrevDrawers", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `gameId=${gameId}&rounds=${rounds}`,
  });
  if (!res.ok) {
    const data = await res.json();
    console.log(`Error: ${data.message}`);
  } else {
    const data = await res.json();

    if (data.end) {
      console.log("game over");
      return data;
    }
    return data;
  }
}
