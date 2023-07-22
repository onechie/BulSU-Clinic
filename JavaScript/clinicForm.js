const endPoint = "./backend/route/clinicForm.php";

const clinicForm = {
  medicationMaxQuantity: {},
  complaintSuggestions: document.getElementById("complaintSuggestions"),
  medicationSuggestions: document.getElementById("medicationSuggestions"),
  treatmentSuggestions: document.getElementById("treatmentSuggestions"),
  laboratorySuggestions: document.getElementById("laboratorySuggestions"),
  quantitySuggestions: document.getElementById("quantitySuggestions"),
  maxQuantityLabel: document.getElementById("maxQuantityLabel"),
  clinicFormData: document.getElementById("clinicFormData"),
  clinicFormMessage: document.getElementById("clinicFormMessage"),
};

const populateFormSuggestions = async () => {
  const route = "getFormSuggestions";
  try {
    const { data } = await axios.get(endPoint, { params: { route } });
    const { complaints, medications, treatments, laboratories } = data;
    populateDropdownOptions(
      clinicForm.complaintSuggestions,
      complaints,
      "description"
    );
    populateDropdownOptions(
      clinicForm.medicationSuggestions,
      medications,
      "name"
    );
    populateDropdownOptions(
      clinicForm.treatmentSuggestions,
      treatments,
      "description"
    );
    populateDropdownOptions(
      clinicForm.laboratorySuggestions,
      laboratories,
      "description"
    );

    medications.forEach((medication) => {
      clinicForm.medicationMaxQuantity[medication.name] = medication.itemsC;
    });
  } catch (error) {
    console.error(error);
  }
};

const populateDropdownOptions = (selectElement, optionsArray, property) => {
  optionsArray.forEach((option) => {
    const optionElement = document.createElement("option");
    optionElement.value = option[property];
    optionElement.textContent = option[property];
    selectElement.appendChild(optionElement);
  });
};

const setMaxQuantity = (event) => {
  const medication = event.target.value;
  const maxQuantity = clinicForm.medicationMaxQuantity[medication];
  if (maxQuantity !== 0) {
    clinicForm.quantitySuggestions.removeAttribute("disabled");
    clinicForm.maxQuantityLabel.textContent = `Max: ${maxQuantity} `;
  } else {
    clinicForm.quantitySuggestions.setAttribute("disabled", true);
    clinicForm.maxQuantityLabel.textContent = `Max: Out of stock `;
  }
  clinicForm.quantitySuggestions.max = maxQuantity;
};

const createRecord = async (event) => {
  event.preventDefault();

  const route = "createRecord";

  try {
    const { files } = clinicForm.clinicFormData.attachments;
    const formData = new FormData(clinicForm.clinicFormData);
    formData.append("route", route);

    if (files.length === 0) {
      formData.delete("attachments[]");
    }

    const { data } = await axios.post(endPoint, formData);
    clinicForm.clinicFormMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
    clinicForm.clinicFormMessage.innerText =
      "Error occurred while creating the record.";
  }
};

clinicForm.medicationSuggestions.addEventListener("change", setMaxQuantity);

populateFormSuggestions();
