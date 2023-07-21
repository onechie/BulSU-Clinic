const submitUserData = async () => {
  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;
  const registeredMessage = document.getElementById("registerMessage");

  const route = "register";
  const endPoint = "./backend/route/register.php";

  try {
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
