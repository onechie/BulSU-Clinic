const submitUserData = async () => {
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirmPassword");
  const registeredMessage = document.getElementById("registerMessage");

  const route = "register";
  const endPoint = "./backend/route/register.php";

  try {
    const username = usernameInput.value;
    const email = emailInput.value;
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    const { data } = await axios.post(
      endPoint,
      {
        username,
        email,
        password,
        confirmPassword,
        route,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    registeredMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};
