import { players } from "../game/gamePresence";

export async function chooseWord() {
  const clientPlayer = players.find((player) => player.isClient === true);

  if (clientPlayer && clientPlayer.isDrawing) {
    console.log("sending request to choose word");
    const res = await fetch("/api/chooseWord", {
      method: "GET",
    });

    if (!res.ok) {
      const data = await res.json();
      console.log(`Error: ${data.message}`);
    } else {
      const { words } = await res.json();
      console.log(words);
      return words;
    }
  }

  return null;
}
