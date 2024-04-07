export async function guessIsCorrect({ message, gameId }) {
  const res = await fetch("/api/guessIsCorrect", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${message}&gameId=${gameId}`,
  });
  if (!res.ok) {
    const data = await res.json();
    console.log(`Error: ${data.message}`);
  } else {
    const { isCorrect } = await res.json();

    return isCorrect;
  }
}
