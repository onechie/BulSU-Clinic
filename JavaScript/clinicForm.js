const createRecord = (event) => {
  event.preventDefault();

  const clinicFormData = document.getElementById("clinicFormData");
  const formData = new FormData(clinicFormData);
  formData.append("requestType", "createRecord");

  // Check if the input file has files selected
  const fileInput = document.getElementById("attachments");

  if (fileInput.files.length === 0) {
    formData.delete("attachments[]"); // Remove the "attachments" key from the formData
  }

  const clinicFormMessage = document.getElementById("clinicFormMessage");

  axios
    .post("./backend/routes/clinicForm.route.php", formData, {
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
