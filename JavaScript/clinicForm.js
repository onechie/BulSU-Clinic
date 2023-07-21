const createRecord = (event) => {
  event.preventDefault();
  const clinicFormData = document.getElementById("clinicFormData");
  const clinicFormMessage = document.getElementById("clinicFormMessage");

  const endPoint = "./backend/route/clinicForm.php";
  const route = "createRecord";

  const formData = new FormData(clinicFormData);
  formData.append("route", route);

  // Check if the input file has files selected
  const fileInput = document.getElementById("attachments");

  if (fileInput.files.length === 0) {
    formData.delete("attachments[]"); // Remove the "attachments" key from the formData
  }

  axios
    .post(endPoint, formData, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
    .then(({ data }) => {
      clinicFormMessage.innerText = data.message;
    })
    .catch((error) => {
      console.log(error);
    });
};
