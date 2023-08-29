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
import {
  createTableRows,
  getById,
  onClick,
  createState,
  handleOpen,
  handleCancel,
  handleSubmit,
} from "../utils/utils.js";
//ENUMS
const templateTypes = Object.freeze({
  COMPLAINT: "complaint",
  TREATMENT: "treatment",
  LABORATORY: "laboratory",
  STORAGE: "storage",
});
//STATES
const complaints = createState({ data: [], tableData: [] });
const treatments = createState({ data: [], tableData: [] });
const laboratories = createState({ data: [], tableData: [] });
const storages = createState({ data: [], tableData: [] });
//DOM ELEMENTS
const elements = {
  add: {
    modal: getById("add-template-modal"),
    title: getById("add-title"),
    type: getById("add-type"),
    description: getById("add-description"),
    message: getById("add-message"),
    cancel: getById("add-cancel"),
    submit: getById("add-submit"),
  },
  edit: {
    modal: getById("edit-template-modal"),
    title: getById("edit-title"),
    type: getById("edit-type"),
    id: getById("edit-id"),
    description: getById("edit-description"),
    message: getById("edit-message"),
    cancel: getById("edit-cancel"),
    submit: getById("edit-submit"),
  },
  complaints: {
    table: getById("complaints-table"),
    add: getById("complaints-add"),
    searchInput: getById("complaints-search-input"),
    searchButton: getById("complaints-search-button"),
  },
  treatments: {
    table: getById("treatments-table"),
    add: getById("treatments-add"),
    searchInput: getById("treatments-search-input"),
    searchButton: getById("treatments-search-button"),
  },
  laboratories: {
    table: getById("laboratories-table"),
    add: getById("laboratories-add"),
    searchInput: getById("laboratories-search-input"),
    searchButton: getById("laboratories-search-button"),
  },
  storages: {
    table: getById("storages-table"),
    add: getById("storages-add"),
    searchInput: getById("storages-search-input"),
    searchButton: getById("storages-search-button"),
  },
};
const initiateAddButtons = (buttons) => {
  const { submit, cancel, type, description, message, modal, title } =
    elements.add;
  buttons.map((button) => {
    onClick(button.element, () => {
      title.innerText = `Add ${button.type}`;
      type.value = button.type;
      handleOpen(modal);
    });
  });
  onClick(submit, () => {
    const { add, updateTable } = typeToFunctions[type.value];
    handleSubmit(
      {
        description: description.value,
      },
      add,
      message,
      updateTable,
      [description]
    );
  });
  onClick(cancel, () => {
    handleCancel(modal, [description, type], [message, title]);
  });
};
const initiateEditButtons = () => {
  const { submit, cancel, id, type, description, message, modal, title } =
    elements.edit;
  onClick(submit, () => {
    const { update, updateTable } = typeToFunctions[type.value];
    handleSubmit(
      {
        id: id.value,
        description: description.value,
      },
      update,
      message,
      updateTable,
      []
    );
  });
  onClick(cancel, () => {
    handleCancel(modal, [description, type], [message, title]);
  });
};
const initiateSearchButtons = (elements) => {
  elements.map(({ searchButton, type, searchInput, getState, table }) => {
    onClick(searchButton, () => {
      handleSearch(searchInput, getState, table, type.toLowerCase());
    });
  });
};
const handleSearch = (searchInput, getState, tableID, type) => {
  const searchValue = searchInput.value.toLowerCase();
  const searchOutput = getState().tableData.filter((item) =>
    Object.values(item).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );
  createTableRows(
    searchOutput,
    tableID,
    generateTDFunction(type, getState().data)
  );
};
const generateTDFunction = (tableType, data) => {
  return (key, value, td) => {
    if (key === "edit") {
      td.innerHTML = `<button class="underline text-blue-500">edit</button>`;
      td.classList = "py-3 text-end";
      const button = td.querySelector("button");
      onClick(button, () => {
        const item = data.find((item) => item.id === value);
        const { title, description, id, type, modal } = elements.edit;
        title.innerText = `Edit ${tableType}`;
        description.value = item.description;
        id.value = item.id;
        type.value = tableType;
        modal.classList.remove("hidden");
      });
    }
  };
};
const updateTable = async (apiFunction, setState, table, type) => {
  try {
    const data = await apiFunction();
    const tableData = data.map(({ id, description }) => ({
      id,
      description,
      edit: id,
    }));
    tableData.sort((a, b) => a.description - b.description);
    createTableRows(tableData, table, generateTDFunction(type, data));
    setState({ data, tableData });
  } catch (error) {
    table.querySelector("tbody").innerHTML = "";
    console.error(error);
  }
};
const updateComplaintsTable = async () => {
  await updateTable(
    getComplaints,
    complaints.setState,
    elements.complaints.table,
    templateTypes.COMPLAINT
  );
};
const updateTreatmentsTable = async () => {
  await updateTable(
    getTreatments,
    treatments.setState,
    elements.treatments.table,
    templateTypes.TREATMENT
  );
};
const updateLaboratoriesTable = async () => {
  await updateTable(
    getLaboratories,
    laboratories.setState,
    elements.laboratories.table,
    templateTypes.LABORATORY
  );
};
const updateStoragesTable = async () => {
  await updateTable(
    getStorages,
    storages.setState,
    elements.storages.table,
    templateTypes.STORAGE
  );
};
const typeToFunctions = {
  complaint: {
    add: addComplaint,
    update: updateComplaint,
    updateTable: updateComplaintsTable,
  },
  treatment: {
    add: addTreatment,
    update: updateTreatment,
    updateTable: updateTreatmentsTable,
  },
  laboratory: {
    add: addLaboratory,
    update: updateLaboratory,
    updateTable: updateLaboratoriesTable,
  },
  storage: {
    add: addStorage,
    update: updateStorage,
    updateTable: updateStoragesTable,
  },
};
const initializeSettings = async () => {
  await updateComplaintsTable();
  await updateTreatmentsTable();
  await updateLaboratoriesTable();
  await updateStoragesTable();
  initiateAddButtons([
    { element: elements.complaints.add, type: templateTypes.COMPLAINT },
    { element: elements.treatments.add, type: templateTypes.TREATMENT },
    { element: elements.laboratories.add, type: templateTypes.LABORATORY },
    { element: elements.storages.add, type: templateTypes.STORAGE },
  ]);
  initiateEditButtons();
  initiateSearchButtons([
    {
      ...elements.complaints,
      type: templateTypes.COMPLAINT,
      getState: complaints.getState,
    },
    {
      ...elements.treatments,
      type: templateTypes.TREATMENT,
      getState: treatments.getState,
    },
    {
      ...elements.laboratories,
      type: templateTypes.LABORATORY,
      getState: laboratories.getState,
    },
    {
      ...elements.storages,
      type: templateTypes.STORAGE,
      getState: storages.getState,
    },
  ]);
};

initializeSettings();
