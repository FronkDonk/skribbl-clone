export async function getPlayer() {
  const res = await fetch("/api/getPlayer", {
    method: "GET",
  });
  if (!res.ok) {
    const data = await res.json();
    console.log(`Error: ${data.message}`);
  } else {
    const { data } = await res.json();

    return data;
  }
}
