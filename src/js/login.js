const endPoint = "../backend/api/login";
const submitUserData = async () => {
  const usernameOrEmailInput = document.getElementById("usernameOrEmail");
  const passwordInput = document.getElementById("password");
  const loginMessage = document.getElementById("loginMessage");

  const route = "login";

  try {
    const usernameOrEmail = usernameOrEmailInput.value;
    const password = passwordInput.value;

    const { data } = await axios.post(
      endPoint,
      {
        usernameOrEmail,
        password,
        route,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    loginMessage.innerText = data.message;
  } catch (error) {
    loginMessage.innerText = error.response.data.message;
    console.error(error);
  }
};
