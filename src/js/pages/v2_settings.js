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

let complaintsData = [];
let treatmentsData = [];
let laboratoriesData = [];
let storagesData = [];

let complaintsTableData = [];
let treatmentsTableData = [];
let laboratoriesTableData = [];
let storagesTableData = [];

const generateTDFunction = (
  data,
  modalElement,
  descriptionElement,
  idElement
) => {
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
        modalElement.classList.remove("hidden");
        descriptionElement.value = item.description;
        idElement.value = item.id;
      });
      td.appendChild(button);
    }
  };
};

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

const handleCancel = (modalElement, inputElements, messageElement) => {
  modalElement.classList.add("hidden");
  inputElements.map((input) => (input.value = ""));
  messageElement.innerText = "";
};

const handleSubmit = async (parameter, apiFunction, messageID, updateTable) => {
  try {
    const response = await apiFunction(parameter);
    messageID.innerHTML = response.message;
    messageID.classList.remove("text-red-600");
    messageID.classList.add("text-green-600");
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

const complaintsEventListeners = () => {
  const Add = getById("complaintsAdd");
  const SearchInput = getById("complaintsSearchInput");
  const SearchButton = getById("complaintsSearchButton");
  const Table = getById("complaintsTable");
  const addModal = getById("addComplaintModal");
  const addDescription = getById("addComplaintDescription");
  const addMessage = getById("addComplaintMessage");
  const addCancel = getById("addComplaintCancel");
  const addSubmit = getById("addComplaintSubmit");
  const editModal = getById("editComplaintModal");
  const editDescription = getById("editComplaintDescription");
  const editId = getById("editComplaintId");
  const editMessage = getById("editComplaintMessage");
  const editCancel = getById("editComplaintCancel");
  const editSubmit = getById("editComplaintSubmit");

  const updateComplaintsTable = async () => {
    complaintsData = await getComplaints();
    complaintsTableData = await updateTable(
      complaintsData,
      Table,
      generateTDFunction(complaintsData, editModal, editDescription, editId)
    );
  };

  onClick(SearchButton, () => {
    handleSearch(
      SearchInput,
      complaintsTableData,
      Table,
      generateTDFunction(complaintsData, editModal, editDescription, editId)
    );
  });
  onClick(Add, () => {
    handleOpen(addModal);
  });
  onClick(addCancel, () => {
    handleCancel(addModal, [addDescription], addMessage);
  });
  onClick(addSubmit, () => {
    handleSubmit(
      {
        description: addDescription.value,
      },
      addComplaint,
      addMessage,
      updateComplaintsTable
    );
  });
  onClick(editCancel, () => {
    handleCancel(editModal, [editDescription], editMessage);
  });
  onClick(editSubmit, () => {
    handleSubmit(
      {
        id: editId.value,
        description: editDescription.value,
      },
      updateComplaint,
      editMessage,
      updateComplaintsTable
    );
  });
};

const treatmentsEventListeners = () => {
  const Add = getById("treatmentsAdd");
  const SearchInput = getById("treatmentsSearchInput");
  const SearchButton = getById("treatmentsSearchButton");
  const Table = getById("treatmentsTable");

  const addModal = getById("addTreatmentModal");
  const addDescription = getById("addTreatmentDescription");
  const addMessage = getById("addTreatmentMessage");
  const addCancel = getById("addTreatmentCancel");
  const addSubmit = getById("addTreatmentSubmit");

  const editModal = getById("editTreatmentModal");
  const editDescription = getById("editTreatmentDescription");
  const editId = getById("editTreatmentId");
  const editMessage = getById("editTreatmentMessage");
  const editCancel = getById("editTreatmentCancel");
  const editSubmit = getById("editTreatmentSubmit");

  const updateTreatmentsTable = async () => {
    treatmentsData = await getTreatments();
    treatmentsTableData = await updateTable(
      treatmentsData,
      Table,
      generateTDFunction(treatmentsData, editModal, editDescription, editId)
    );
  };

  onClick(SearchButton, () => {
    handleSearch(
      SearchInput,
      treatmentsTableData,
      Table,
      generateTDFunction(treatmentsData, editModal, editDescription, editId)
    );
  });
  onClick(Add, () => {
    handleOpen(addModal);
  });
  onClick(addCancel, () => {
    handleCancel(addModal, [addDescription], addMessage);
  });
  onClick(addSubmit, () => {
    handleSubmit(
      {
        description: addDescription.value,
      },
      addTreatment,
      addMessage,
      updateTreatmentsTable
    );
  });
  onClick(editCancel, () => {
    handleCancel(editModal, [editDescription], editMessage);
  });
  onClick(editSubmit, () => {
    handleSubmit(
      {
        id: editId.value,
        description: editDescription.value,
      },
      updateTreatment,
      editMessage,
      updateTreatmentsTable
    );
  });
};

const laboratoriesEventListeners = () => {
  const Add = getById("laboratoriesAdd");
  const SearchInput = getById("laboratoriesSearchInput");
  const SearchButton = getById("laboratoriesSearchButton");
  const Table = getById("laboratoriesTable");

  const addModal = getById("addLaboratoryModal");
  const addDescription = getById("addLaboratoryDescription");
  const addMessage = getById("addLaboratoryMessage");
  const addCancel = getById("addLaboratoryCancel");
  const addSubmit = getById("addLaboratorySubmit");

  const editModal = getById("editLaboratoryModal");
  const editDescription = getById("editLaboratoryDescription");
  const editId = getById("editLaboratoryId");
  const editMessage = getById("editLaboratoryMessage");
  const editCancel = getById("editLaboratoryCancel");
  const editSubmit = getById("editLaboratorySubmit");

  const updateLaboratoriesTable = async () => {
    laboratoriesData = await getLaboratories();
    laboratoriesTableData = await updateTable(
      laboratoriesData,
      Table,
      generateTDFunction(laboratoriesData, editModal, editDescription, editId)
    );
  };

  onClick(SearchButton, () => {
    handleSearch(
      SearchInput,
      laboratoriesTableData,
      Table,
      generateTDFunction(laboratoriesData, editModal, editDescription, editId)
    );
  });
  onClick(Add, () => {
    handleOpen(addModal);
  });
  onClick(addCancel, () => {
    handleCancel(addModal, [addDescription], addMessage);
  });
  onClick(addSubmit, () => {
    handleSubmit(
      {
        description: addDescription.value,
      },
      addLaboratory,
      addMessage,
      updateLaboratoriesTable
    );
  });
  onClick(editCancel, () => {
    handleCancel(editModal, [editDescription], editMessage);
  });
  onClick(editSubmit, () => {
    handleSubmit(
      {
        id: editId.value,
        description: editDescription.value,
      },
      updateLaboratory,
      editMessage,
      updateLaboratoriesTable
    );
  });
};

const storagesEventListeners = () => {
  const Add = getById("storagesAdd");
  const SearchInput = getById("storagesSearchInput");
  const SearchButton = getById("storagesSearchButton");
  const Table = getById("storagesTable");

  const addModal = getById("addStorageModal");
  const addDescription = getById("addStorageDescription");
  const addMessage = getById("addStorageMessage");
  const addCancel = getById("addStorageCancel");
  const addSubmit = getById("addStorageSubmit");

  const editModal = getById("editStorageModal");
  const editDescription = getById("editStorageDescription");
  const editId = getById("editStorageId");
  const editMessage = getById("editStorageMessage");
  const editCancel = getById("editStorageCancel");
  const editSubmit = getById("editStorageSubmit");

  const updateStoragesTable = async () => {
    storagesData = await getStorages();
    storagesTableData = await updateTable(
      storagesData,
      Table,
      generateTDFunction(storagesData, editModal, editDescription, editId)
    );
  };

  onClick(SearchButton, () => {
    handleSearch(
      SearchInput,
      storagesTableData,
      Table,
      generateTDFunction(storagesData, editModal, editDescription, editId)
    );
  });
  onClick(Add, () => {
    handleOpen(addModal);
  });
  onClick(addCancel, () => {
    handleCancel(addModal, [addDescription], addMessage);
  });
  onClick(addSubmit, () => {
    handleSubmit(
      {
        description: addDescription.value,
      },
      addStorage,
      addMessage,
      updateStoragesTable
    );
  });
  onClick(editCancel, () => {
    handleCancel(editModal, [editDescription], editMessage);
  });
  onClick(editSubmit, () => {
    handleSubmit(
      {
        id: editId.value,
        description: editDescription.value,
      },
      updateStorage,
      editMessage,
      updateStoragesTable
    );
  });
};
const initializeSettings = async () => {
  complaintsEventListeners();
  treatmentsEventListeners();
  laboratoriesEventListeners();
  storagesEventListeners();
};

initializeSettings();
