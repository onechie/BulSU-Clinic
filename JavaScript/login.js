const submitUserData = async () => {
  const usernameOrEmailInput = document.getElementById("usernameOrEmail");
  const passwordInput = document.getElementById("password");
  const loginMessage = document.getElementById("loginMessage");

  const route = "login";
  const endPoint = "./backend/route/login.php";

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
    console.error(error);
  }
};
