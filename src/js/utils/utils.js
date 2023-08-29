export const createTableRows = (data, table, customTDFunction) => {
  const tableBody = table.querySelector("tbody");
  tableBody.innerHTML = "";

  if (!data) return;

  try {
    data.forEach((item) => {
      const tr = document.createElement("tr");
      tr.classList.add("border-b", "border-gray-200");

      for (const key in item) {
        const td = document.createElement("td");
        td.innerText = item[key];

        td.classList.add("py-3", "pe-3");

        if (key === Object.keys(item)[0]) {
          td.classList.add("font-medium", "text-gray-600");
        } else {
          td.classList.add("text-gray-500");
        }

        if (customTDFunction && typeof customTDFunction === "function") {
          customTDFunction(key, item[key], td);
        }

        tr.appendChild(td);
      }
      tableBody.appendChild(tr);
    });
  } catch (error) {
    console.error(error);
  }
};

export const createOptions = (data, property) => {
  try {
    return data
      .sort((a, b) => a[property].localeCompare(b[property]))
      .map((item) => {
        const option = document.createElement("option");
        option.value = item[property];
        return option;
      });
  } catch (error) {
    console.error(error);
  }
};
export const getById = (id) => document.getElementById(id);

export const onClick = (element, callback) =>
  element.addEventListener("click", callback);

export const createState = (initialState) => {
  let state = initialState;
  return {
    getState: () => state,
    setState: (newState) => (state = newState),
  };
};
export const handleOpen = (modalElement) => {
  modalElement.classList.remove("hidden");
};
export const handleCancel = (modalElement, inputElements, textElements) => {
  modalElement.classList.add("hidden");
  inputElements.map((input) => (input.value = ""));
  textElements.map((text) => (text.innerText = ""));
};
export const handleSubmit = async (
  parameter,
  apiFunction,
  messageElement,
  updateTable,
  inputElements
) => {
  try {
    const response = await apiFunction(parameter);
    messageElement.innerHTML = response.message;
    messageElement.classList.remove("text-red-600");
    messageElement.classList.add("text-green-600");
    inputElements.map((input) => (input.value = ""));
    await updateTable();
  } catch (error) {
    messageElement.innerHTML = error.message;
    messageElement.classList.remove("text-green-600");
    messageElement.classList.add("text-red-600");
  }
};
