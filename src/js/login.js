"use strict";

const endPoint = "../backend/api/users/login";
let notificationTimeout;
const notificationIconError = document.getElementById("notificationIconError");
const notificationIconSuccess = document.getElementById(
  "notificationIconSuccess"
);
const notificationTitle = document.getElementById("notificationTitle");
const notificationMessage = document.getElementById("notificationMessage");

const loginButton = document.getElementById("loginButton");

const submitUserData = async () => {
  const usernameOrEmailInput = document.getElementById("usernameOrEmail");
  const passwordInput = document.getElementById("password");
  const keepLoggedInInput = document.getElementById("keepLoggedIn");

  loginButton.disabled = true;

  try {
    const usernameOrEmail = usernameOrEmailInput.value;
    const password = passwordInput.value;
    const keepLoggedIn = keepLoggedInInput.checked;

    toggleLoginButton(true);
    closeNotification();
    const { data } = await axios.post(
      endPoint,
      {
        usernameOrEmail,
        password,
        keepLoggedIn,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    notificationMessage.innerText = data.message;
    loginButton.disabled = false;
    openNotification("Login Success", true);
    toggleLoginButton(false);

    setTimeout(() => {
      location.reload();
    }, 2000);
  } catch (error) {
    notificationMessage.innerText = error.response.data.message;
    loginButton.disabled = false;
    openNotification("Login Failed", false);
    toggleLoginButton(false);
  }
};
const toggleLoginButton = (isLoading) => {
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

const checkIfLoggedIn = async () => {
  try {
    // Check if token is valid
    const { data } = await axios.get("../backend/api/users/auth", {});
    notificationMessage.innerText = data.message;
    openNotification("User Authenticated", true);
    // setTimeout(() => {
    //   location.reload();
    // }, 2000);
  } catch (error) {
    console.log(error);
  }
};
checkIfLoggedIn();
