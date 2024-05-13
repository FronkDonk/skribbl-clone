import { gameRoom } from "./lobby.js";
import {
  enableStartButton,
  renderOnlineUsers,
  ownerOrPlayerView,
} from "./lobbyView.js";
import { id } from "./lobby.js";
//create a new lobby page makes all much simpler
export let players = [];
/* let elements = document.getElementsByClassName("onlineUsers");
for (let i = 0; i < elements.length; i++) {
  elements[i].innerHTML = "";
} */

gameRoom
  .on("presence", { event: "sync" }, async () => {
    const newState = gameRoom.presenceState();
    console.log("sync", newState);

    Object.entries(newState).forEach(([key, value]) => {
      console.log(`User ID: ${key}`);
      console.log(`Presence Info: ${value[0].username}`);

      const userExists = players.some(
        (player) => player.user === value[0].user
      );

      if (!userExists) {
        players.push({
          username: value[0].username,
          user: value[0].user,
          online_at: value[0].online_at,
          isClient: value[0].user === id ? true : false,
          avatar: value[0].avatar,
          owner: false,
        });
      }
    });

    const owner = players.reduce((prev, curr) =>
      prev.online_at < curr.online_at ? prev : curr
    );

    const ownerIndex = players.findIndex(
      (player) => player.user === owner.user
    );

    // Add the owner: true property to the owner
    if (ownerIndex !== -1) {
      players[ownerIndex].owner = true;
    }

    document.getElementById("startGame").disabled = true;
    renderOnlineUsers(players);
    enableStartButton(players);
    ownerOrPlayerView(players);
  })
  .on("presence", { event: "join" }, ({ key, newPresences }) => {
    console.log("join", key, newPresences);
  })
  .on("presence", { event: "leave" }, ({ key, leftPresences }) => {
    console.log("leave", key, leftPresences);
    players = players.filter((player) => player.user !== key);
    document.getElementById(key).remove();

    console.log("players", players);
  });

gameRoom.on("broadcast", { event: "startGame" }, ({ payload }) => {
  window.location.href = `/game/${payload.gameId}`;
});
