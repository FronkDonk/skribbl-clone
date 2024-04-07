export async function saveChatMessage({
  message,
  userId,
  username,
  sentAt,
  gameId,
}) {
  const res = await fetch("/api/saveChatMessage", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${message}&userId=${userId}&username=${username}&sentAt=${sentAt}&gameId=${gameId}`,
  });

  const messageRes = await res.json();
  console.log({ message });
  return messageRes;
}
