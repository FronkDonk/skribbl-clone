export async function renderChatMessage({ message, userId, username, sentAt }) {
  const res = await fetch("/api/renderMessage", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${message}&userId=${userId}&username=${username}&sentAt=${sentAt}`,
  });

  const html = await res.text();
  console.log({ html });
  return html;
}
