export async function addPrevDrawers(gameId, drawerId) {
  const res = await fetch("/api/addPrevDrawers", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `gameId=${gameId}&drawerId=${drawerId}`,
  });
  if (!res.ok) {
    const data = await res.json();
    console.log(`Error: ${data.message}`);
  } else {
    const { data } = await res.json();
    
    return data;
  }
}
