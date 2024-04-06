export async function getUserData() {
  const res = await fetch("/api/getCurrentUser", {
    method: "GET",
  });
  if (!res.ok) {
    const data = await res.json();
    console.log(`Error: ${data.message}`);
  } else {
    const { data } = await res.json();
    console.log("data", data);
    console.log("data.id", data.id);
    return data.id;
  }
}
