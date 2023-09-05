"use strict";
import { registerUser } from "../api/users.js";
import { getById, onClick } from "../utils/utils.js";
const endPoint = "../backend/api/users/register";
let notificationTimeout;
const notificationIconError = document.getElementById("notificationIconError");
const notificationIconSuccess = document.getElementById(
  "notificationIconSuccess"
);
const notificationTitle = document.getElementById("notificationTitle");
const notificationMessage = document.getElementById("notificationMessage");

const registerForm = getById("registerForm");
const profilePicturePreview = getById("profilePicturePreview");
const profileIcon = getById("profileIcon");
const registerButton = document.getElementById("registerButton");

registerForm.addEventListener("submit", async (event) => {
  event.preventDefault();
  registerButton.disabled = true;
  const userData = new FormData(registerForm);
  try {
    toggleRegisterButton(true);
    closeNotification();
    const { message } = await registerUser(userData);
    notificationMessage.innerText = message;
    registerButton.disabled = false;
    openNotification("Registration Success", true);
    toggleRegisterButton(false);
    profilePicturePreview.classList = `relative outline-none ring-2 ring-gray-500 hover:ring-gray-600 cursor-pointer 
    rounded-full h-[100px] w-[100px] overflow-hidden bg-center bg-cover bg-[url("")]`;
    profileIcon.classList.remove("hidden");
    registerForm.reset();
  } catch (error) {
    notificationMessage.innerText = error.message;
    registerButton.disabled = false;
    openNotification("Registration Failed", false);
    toggleRegisterButton(false);
  }
});

registerForm.profilePicture.addEventListener("change", () => {
  if (registerForm.profilePicture.files.length === 0) {
    profilePicturePreview.classList = `relative outline-none ring-2 ring-gray-500 hover:ring-gray-600 cursor-pointer 
    rounded-full h-[100px] w-[100px] overflow-hidden bg-center bg-cover bg-[url("")]`;
    profileIcon.classList.remove("hidden");
    return;
  }
  const profilePicture = registerForm.profilePicture.files[0];

  var validImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];

  if (validImageTypes.includes(profilePicture.type) === false) {
    profilePicturePreview.classList = `relative outline-none ring-2 ring-gray-500 hover:ring-gray-600 cursor-pointer 
    rounded-full h-[100px] w-[100px] overflow-hidden bg-center bg-cover bg-[url("")]`;
    registerForm.profilePicture.value = null;
    closeNotification();
    notificationMessage.innerText = "Please insert valid image file!";
    openNotification("Invalid Photo", false);
    profileIcon.classList.remove("hidden");
  } else {
    profilePicturePreview.classList = `relative outline-none ring-2 ring-gray-500 hover:ring-gray-600 cursor-pointer 
    rounded-full h-[100px] w-[100px] overflow-hidden bg-center bg-cover bg-[url("${URL.createObjectURL(
      profilePicture
    )}")]`;
    profileIcon.classList.add("hidden");
  }
});

const toggleRegisterButton = (isLoading) => {
  const buttonLoading = document.getElementById("buttonLoading");
  const buttonReady = document.getElementById("buttonReady");
  if (isLoading) {
    buttonLoading.style.display = "block";
    buttonReady.style.display = "none";
  } else {
    buttonLoading.style.display = "none";
    buttonReady.style.display = "block";
  }
};
const openNotification = (title, success) => {
  if (success) {
    notificationTitle.innerText = title;
    notificationIconError.style.display = "none";
    notificationIconSuccess.style.display = "block";
  } else {
    notificationTitle.innerText = title;
    notificationIconError.style.display = "block";
    notificationIconSuccess.style.display = "none";
  }
  anime({
    targets: "#notification",
    translateX: -370,
  });
  clearTimeout(notificationTimeout);
  notificationTimeout = setTimeout(() => {
    anime({
      targets: "#notification",
      translateX: 0,
    });
  }, 5000);
};

const closeNotification = () => {
  clearTimeout(notificationTimeout);
  anime({
    targets: "#notification",
    translateX: 0,
  });
};
//test
const checkIfLoggedIn = async () => {
  try {
    // Check if token is valid
    const { data } = await axios.get("../backend/api/users/auth", {});
    notificationMessage.innerText = data.message;
    openNotification("User Authenticated", true);
    setTimeout(() => {
      location.reload();
    }, 2000);
  } catch (error) {
    console.log(error);
  }
};
checkIfLoggedIn();
