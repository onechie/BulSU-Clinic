const createRecord = async (event) => {
  event.preventDefault();

  const clinicFormData = document.getElementById("clinicFormData");
  const clinicFormMessage = document.getElementById("clinicFormMessage");
  const endPoint = "./backend/route/clinicForm.php";
  const route = "createRecord";

  try {
    // Use destructuring to extract the files from the file input
    const { files } = clinicFormData.attachments;

    // Use FormData constructor to create the formData object
    const formData = new FormData(clinicFormData);
    formData.append("route", route);

    // Remove the "attachments" key if no files are selected
    if (files.length === 0) {
      formData.delete("attachments[]");
    }

    const { data } = await axios.post(endPoint, formData);

    // Use template literals for setting the inner text
    clinicFormMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};
