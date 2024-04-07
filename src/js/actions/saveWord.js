export async function saveWord({ word, gameId }) {
  const res = await fetch("/api/saveWord", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `word=${word}&gameId=${gameId}`,
  });

  const messageRes = await res.json();
  console.log({ messageRes });
  return messageRes;
}
