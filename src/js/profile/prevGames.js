import { getPrevGames } from "../actions/getPrevGames";

const data = await getPrevGames();
const table = document.getElementById("prevGames");
console.log(data);
data.map((game) => {
  console.log(game.game_room.created_at);
  console.log(game.game_room.num_rounds);
  const date = new Date(game.game_room.created_at).toLocaleString();
  const tr = `
    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
      <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Draw</td>
      <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">${date}</td>
      <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">1000</td>
      <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">${
        game.game_room.num_rounds
      }</td>
      <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">
        <div class="flex items-center gap-2">
          ${game.players.map((player, i) => {
            return `
              <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                <span class="flex text-muted h-full w-full items-center justify-center rounded-full bg-gradient-to-tr ${
                  player.avatar
                }">P${i + 1}</span>
              </span>
              <span>${player.username}: ${player.score} points</span>
            `;
          })}
        </div>
      </td>
    </tr>
  `;

  table.insertAdjacentHTML("beforeend", tr);
});
