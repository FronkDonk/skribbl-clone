import { players } from "./lobbyPresence";

const owner = players.find(
  (player) => player.owner === true && player.isClient === true
);

function handleClick(event, id) {
  if (!owner) return;
  console.log(event.target.innerText); // Logs the clicked element to the console
  document.getElementById(`selectedLabel-${id}`).innerText =
    event.target.innerText;
  document.getElementById(`selectedValue-${id}`).value = event.target.innerText;
  console.log(event.target.innerText);
}

function toggleSelect(event, id) {
  if (!owner) return;

  console.log(id);
  event.stopPropagation();
  let dropdown = document.getElementById(`dropdown-${id}`);
  if (dropdown.style.display === "none") {
    dropdown.style.display = "block";

    document.addEventListener("click", function hideDropdown() {
      dropdown.style.display = "none";

      // Remove the event listener after hiding the dropdown
      document.removeEventListener("click", hideDropdown);
    });
  } else {
    dropdown.style.display = "none";
  }
}
