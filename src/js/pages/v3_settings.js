import {
  getComplaints,
  addComplaint,
  updateComplaint,
} from "../api/complaints.js";
import {
  getTreatments,
  addTreatment,
  updateTreatment,
} from "../api/treatments.js";
import {
  getLaboratories,
  addLaboratory,
  updateLaboratory,
} from "../api/laboratories.js";
import { getStorages, addStorage, updateStorage } from "../api/storages.js";
import { createTableRows, getById, onClick } from "../utils/utils.js";

const add = {
  modal: getById("add-template-modal"),
  title: getById("add-title"),
  type: getById("add-type"),
  description: getById("add-description"),
  message: getById("add-message"),
  cancel: getById("add-cancel"),
  submit: getById("add-submit"),
};

const edit = {
  modal: getById("edit-template-modal"),
  title: getById("edit-title"),
  type: getById("edit-type"),
  id: getById("edit-id"),
  description: getById("edit-description"),
  message: getById("edit-message"),
  cancel: getById("edit-cancel"),
  submit: getById("edit-submit"),
};

const complaints = {
  table: getById("complaints-table"),
  add: getById("complaints-add"),
  searchInput: getById("complaints-search-input"),
  searchButton: getById("complaints-search-button"),
  data: [],
  tableData: [],
};

const treatments = {
  table: getById("treatments-table"),
  add: getById("treatments-add"),
  searchInput: getById("treatments-search-input"),
  searchButton: getById("treatments-search-button"),
  data: [],
  tableData: [],
};

const laboratories = {
  table: getById("laboratories-table"),
  add: getById("laboratories-add"),
  searchInput: getById("laboratories-search-input"),
  searchButton: getById("laboratories-search-button"),
  data: [],
  tableData: [],
};

const storages = {
  table: getById("storages-table"),
  add: getById("storages-add"),
  searchInput: getById("storages-search-input"),
  searchButton: getById("storages-search-button"),
  data: [],
  tableData: [],
};

onClick(complaints.add, () => {
  handleOpen(add.modal);
  add.title.innerText = "Add complaint";
  add.type.value = "complaint";
});

onClick(treatments.add, () => {
  handleOpen(add.modal);
  add.title.innerText = "Add treatment";
  add.type.value = "treatment";
});
onClick(laboratories.add, () => {
  handleOpen(add.modal);
  add.title.innerText = "Add laboratory";
  add.type.value = "laboratory";
});
onClick(storages.add, () => {
  handleOpen(add.modal);
  add.title.innerText = "Add storage";
  add.type.value = "storage";
});
onClick(add.submit, () => {
  let apiFunction;
  let updateTable;
  switch (add.type.value) {
    case "complaint":
      apiFunction = addComplaint;
      updateTable = updateComplaintsTable;
      break;
    case "treatment":
      apiFunction = addTreatment;
      updateTable = updateTreatmentsTable;
      break;
    case "laboratory":
      apiFunction = addLaboratory;
      updateTable = updateLaboratoriesTable;
      break;
    case "storage":
      apiFunction = addStorage;
      updateTable = updateStoragesTable;
      break;
    default:
      add.message.innerText = "Error occurred. Please try again.";
      return;
  }
  handleSubmit(
    {
      description: add.description.value,
    },
    apiFunction,
    add.message,
    updateTable,
    [add.description]
  );
});

onClick(add.cancel, () => {
  handleCancel(
    add.modal,
    [add.description, add.type],
    [add.message, add.title]
  );
});

onClick(edit.submit, () => {
  let apiFunction;
  let updateTable;
  switch (edit.type.value) {
    case "complaint":
      apiFunction = updateComplaint;
      updateTable = updateComplaintsTable;
      break;
    case "treatment":
      apiFunction = updateTreatment;
      updateTable = updateTreatmentsTable;
      break;
    case "laboratory":
      apiFunction = updateLaboratory;
      updateTable = updateLaboratoriesTable;
      break;
    case "storage":
      apiFunction = updateStorage;
      updateTable = updateStoragesTable;
      break;
    default:
      console.log(edit.type.value);
      edit.message.innerText = "Error occurred. Please try again.";
      return;
  }
  handleSubmit(
    {
      id: edit.id.value,
      description: edit.description.value,
    },
    apiFunction,
    edit.message,
    updateTable,
    []
  );
});

onClick(edit.cancel, () => {
  handleCancel(
    edit.modal,
    [edit.description, edit.type],
    [edit.message, edit.title]
  );
});

onClick(complaints.searchButton, () => {
  handleSearch(
    complaints.searchInput,
    complaints.tableData,
    complaints.table,
    generateTDFunction("complaint", complaints.data)
  );
});
onClick(treatments.searchButton, () => {
  handleSearch(
    treatments.searchInput,
    treatments.tableData,
    treatments.table,
    generateTDFunction("complaint", treatments.data)
  );
});
onClick(laboratories.searchButton, () => {
  handleSearch(
    laboratories.searchInput,
    laboratories.tableData,
    laboratories.table,
    generateTDFunction("complaint", laboratories.data)
  );
});
onClick(storages.searchButton, () => {
  handleSearch(
    storages.searchInput,
    storages.tableData,
    storages.table,
    generateTDFunction("complaint", storages.data)
  );
});

const handleSearch = (searchInput, tableData, tableID, tdFunction) => {
  const searchValue = searchInput.value.toLowerCase();
  const searchOutput = tableData.filter((item) =>
    Object.values(item).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );
  createTableRows(searchOutput, tableID, tdFunction);
};

const handleOpen = (modalElement) => {
  modalElement.classList.remove("hidden");
};

const handleCancel = (modalElement, inputElements, textElements) => {
  modalElement.classList.add("hidden");
  inputElements.map((input) => (input.value = ""));
  textElements.map((text) => (text.innerText = ""));
};

const handleSubmit = async (
  parameter,
  apiFunction,
  messageID,
  updateTable,
  inputElements
) => {
  try {
    const response = await apiFunction(parameter);
    messageID.innerHTML = response.message;
    messageID.classList.remove("text-red-600");
    messageID.classList.add("text-green-600");
    inputElements.map((input) => (input.value = ""));
    await updateTable();
  } catch (error) {
    messageID.innerHTML = error.message;
    messageID.classList.remove("text-green-600");
    messageID.classList.add("text-red-600");
  }
};

const updateTable = async (data, tableID, tdFunction) => {
  try {
    const tableData = data.map((item) => ({
      id: item.id,
      description: item.description,
      edit: item.id,
    }));

    tableData.sort((a, b) => a.description - b.description);
    createTableRows(tableData, tableID, tdFunction);
    return tableData;
  } catch (error) {
    const tableBody = tableID.querySelector("tbody");
    tableBody.innerHTML = "";
    console.error(error);
  }
};

const generateTDFunction = (type, data) => {
  return (key, value, td) => {
    if (key === "edit") {
      td.innerText = "";
      td.classList.remove("text-gray-500", "pe-3");
      td.classList.add("text-end");

      const button = document.createElement("button");
      button.className = "underline text-blue-500";
      button.innerText = "edit";

      onClick(button, () => {
        const item = data.find((item) => item.id === value);
        edit.title.innerText = `Edit ${type}`;
        edit.description.value = item.description;
        edit.id.value = item.id;
        edit.type.value = type;
        edit.modal.classList.remove("hidden");
      });

      td.appendChild(button);
    }
  };
};

const updateComplaintsTable = async () => {
  complaints.data = await getComplaints();
  complaints.tableData = await updateTable(
    complaints.data,
    complaints.table,
    generateTDFunction("complaint", complaints.data)
  );
};

const updateTreatmentsTable = async () => {
  treatments.data = await getTreatments();
  treatments.tableData = await updateTable(
    treatments.data,
    treatments.table,
    generateTDFunction("treatment", treatments.data)
  );
};
const updateLaboratoriesTable = async () => {
  laboratories.data = await getLaboratories();
  laboratories.tableData = await updateTable(
    laboratories.data,
    laboratories.table,
    generateTDFunction("laboratory", laboratories.data)
  );
};

const updateStoragesTable = async () => {
  storages.data = await getStorages();
  storages.tableData = await updateTable(
    storages.data,
    storages.table,
    generateTDFunction("storage", storages.data)
  );
};

const initializeSettings = async () => {
  await updateComplaintsTable();
  await updateTreatmentsTable();
  await updateLaboratoriesTable();
  await updateStoragesTable();
};

initializeSettings();
