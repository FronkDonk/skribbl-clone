import { getProfileData } from "../actions/getProfileData";

const userData = await getProfileData();
const emailInput = document.getElementById("email");
const usernameInput = document.getElementById("username");

emailInput.value = userData.email;
usernameInput.value = userData.username;
