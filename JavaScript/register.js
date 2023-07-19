const submitUserData = () => {
    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let requestType = "register";

    const registeredMessage = document.getElementById("registerMessage");

    axios
      .post(
        "./backend/routes/register.route.php",
        {
          username,
          email,
          password,
          confirmPassword,
          requestType,
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