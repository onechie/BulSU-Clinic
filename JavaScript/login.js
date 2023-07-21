const submitUserData = () => {
  let usernameOrEmail = document.getElementById("usernameOrEmail").value;
  let password = document.getElementById("password").value;
  const loginMessage = document.getElementById("loginMessage");

  const route = "login";
  const endPoint = "./backend/route/login.php";

  axios
    .get(endPoint, {
      params: {
        usernameOrEmail,
        password,
        route,
      },
    })
    .then(({ data }) => {
      const success = data.success;
      const message = data.message;
      loginMessage.innerText = message;
    })
    .catch((error) => {
      console.log(error);
    });
};
