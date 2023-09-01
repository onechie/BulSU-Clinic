import { getById, onClick } from "../utils/utils.js";
import { getUser, logoutUser } from "../api/users.js";

const userButton = getById("user-button");
const userMenu = getById("user-menu");
const userSettings = getById("user-settings");
const userLogout = getById("user-logout");

onClick(userButton, () => {
  userMenu.classList.toggle("hidden");
});

onClick(userSettings, () => {});

onClick(userLogout, async () => {
  try {
    await logoutUser();
    location.reload();
  } catch (error) {
    console.error(error);
  }
});
