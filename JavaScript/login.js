const submitUserData = async () => {
  const usernameOrEmail = document.getElementById("usernameOrEmail").value;
  const password = document.getElementById("password").value;
  const loginMessage = document.getElementById("loginMessage");

  const route = "login";
  const endPoint = "./backend/route/login.php";

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        usernameOrEmail,
        password,
        route,
      },
    });

    loginMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};
