const { sign } = require("crypto");
const path = require("path");

module.exports = {
  entry: {
    lobby: "./dist/lobbyScripts.js",
    game: "./dist/gameScripts.js",
    signUp: "./dist/signUpScripts.js",
    signIn: "./dist/signInScripts.js",
    createGame: "./dist/createGameScripts.js",
    joinGame: "./dist/joinGameScripts.js",
  },
  mode: "development",
  output: {
    filename: "[name].bundle.js",
    path: path.resolve(__dirname, "dist"),
  },
};
