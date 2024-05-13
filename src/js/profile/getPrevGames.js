const res = await fetch("/api/getPrevGames", {
  method: "GET",
});
if (!res.ok) {
  const data = await res.json();
  console.log(`Error: ${data.message}`);
  alert(data.message);
}
const { data } = await res.json();

return data;
