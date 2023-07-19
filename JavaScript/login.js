const submitUserData = () => {
  let usernameOrEmail = document.getElementById("usernameOrEmail").value;
  let password = document.getElementById("password").value;
  let requestType = "login";

  const loginMessage = document.getElementById("loginMessage");

  axios
    .get("./backend/routes/login.route.php", {
      params: {
        usernameOrEmail,
        password,
        requestType,
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
