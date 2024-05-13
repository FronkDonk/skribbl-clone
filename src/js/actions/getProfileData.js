export async function getProfileData() {
  const res = await fetch("/api/getProfileData", {
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
