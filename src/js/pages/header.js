import { getById, onClick } from "../utils/utils.js";
import { getUser, logoutUser } from "../api/users.js";

const profilePicture = getById("profile-picture");
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

const initializeUser = async () => {
  try {
    const user = await getUser();
    if (user.profilePicture) {
      profilePicture.classList = `me-1 relative outline-none ring-1 ring-gray-200 rounded-full h-[35px] w-[35px] overflow-hidden bg-center bg-cover bg-[url("${user.profilePicture}")]`;
    }
  } catch (error) {
    console.error(error);
  }
};

initializeUser();
