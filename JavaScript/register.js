const submitUserData = () => {
  let username = document.getElementById("username").value;
  let email = document.getElementById("email").value;
  let password = document.getElementById("password").value;
  let confirmPassword = document.getElementById("confirmPassword").value;
  const registeredMessage = document.getElementById("registerMessage");

  const route = "register";
  const endPoint = "./backend/route/register.php";

  axios
    .post(
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
    )
    .then(({ data }) => {
      const success = data.success;
      const message = data.message;
      registeredMessage.innerText = message;
    })
    .catch((error) => {
      console.log(error);
    });
};
