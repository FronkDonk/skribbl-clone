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

const div = `
<tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
  <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">${}</td>
  <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">${}</td>
  <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">${}</td>
  <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">${}</td>
</tr>
`;
