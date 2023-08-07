"use strict";
const endPoint = "../backend/api/users/register";
let notificationTimeout;
const notificationIconError = document.getElementById("notificationIconError");
const notificationIconSuccess = document.getElementById(
  "notificationIconSuccess"
);
const notificationTitle = document.getElementById("notificationTitle");
const notificationMessage = document.getElementById("notificationMessage");

const registerButton = document.getElementById("registerButton");

const submitUserData = async () => {
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const agreementInput = document.getElementById("agreement");

  registerButton.disabled = true;

  try {
    const username = usernameInput.value;
    const email = emailInput.value;
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const agreement = agreementInput.checked;

    toggleRegisterButton(true);
    closeNotification();
    const { data } = await axios.post(
      endPoint,
      {
        username,
        email,
        password,
        confirmPassword,
        agreement,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    notificationMessage.innerText = data.message;
    registerButton.disabled = false;
    openNotification("Registration Success", true);
    toggleRegisterButton(false);

    usernameInput.value = "";
    emailInput.value = "";
    passwordInput.value = "";
    confirmPasswordInput.value = "";
    agreementInput.checked = false;
  } catch (error) {
    notificationMessage.innerText = error.response.data.message;
    registerButton.disabled = false;
    openNotification("Registration Failed", false);
    toggleRegisterButton(false);
  }
};

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
