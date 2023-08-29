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
import { createTableRows } from "../utils/utils.js";

// COMPLAINTS
const complaintsAdd = document.getElementById("complaintsAdd");
const complaintsSearchInput = document.getElementById("complaintsSearchInput");
const complaintsSearchButton = document.getElementById(
  "complaintsSearchButton"
);
const complaintsTable = document.getElementById("complaintsTable");

const addComplaintModal = document.getElementById("addComplaintModal");
const addComplaintDescription = document.getElementById(
  "addComplaintDescription"
);
const addComplaintMessage = document.getElementById("addComplaintMessage");
const addComplaintCancel = document.getElementById("addComplaintCancel");
const addComplaintSubmit = document.getElementById("addComplaintSubmit");

const editComplaintModal = document.getElementById("editComplaintModal");
const editComplaintDescription = document.getElementById(
  "editComplaintDescription"
);
const editComplaintId = document.getElementById("editComplaintId");
const editComplaintMessage = document.getElementById("editComplaintMessage");
const editComplaintCancel = document.getElementById("editComplaintCancel");
const editComplaintSubmit = document.getElementById("editComplaintSubmit");

// TREATMENTS
const treatmentsAdd = document.getElementById("treatmentsAdd");
const treatmentsSearchInput = document.getElementById("treatmentsSearchInput");
const treatmentsSearchButton = document.getElementById(
  "treatmentsSearchButton"
);
const treatmentsTable = document.getElementById("treatmentsTable");

const addTreatmentModal = document.getElementById("addTreatmentModal");
const addTreatmentDescription = document.getElementById(
  "addTreatmentDescription"
);
const addTreatmentMessage = document.getElementById("addTreatmentMessage");
const addTreatmentCancel = document.getElementById("addTreatmentCancel");
const addTreatmentSubmit = document.getElementById("addTreatmentSubmit");

const editTreatmentModal = document.getElementById("editTreatmentModal");
const editTreatmentDescription = document.getElementById(
  "editTreatmentDescription"
);
const editTreatmentId = document.getElementById("editTreatmentId");
const editTreatmentMessage = document.getElementById("editTreatmentMessage");
const editTreatmentCancel = document.getElementById("editTreatmentCancel");
const editTreatmentSubmit = document.getElementById("editTreatmentSubmit");

// LABORATORIES
const laboratoriesAdd = document.getElementById("laboratoriesAdd");
const laboratoriesSearchInput = document.getElementById(
  "laboratoriesSearchInput"
);
const laboratoriesSearchButton = document.getElementById(
  "laboratoriesSearchButton"
);
const laboratoriesTable = document.getElementById("laboratoriesTable");

const addLaboratoryModal = document.getElementById("addLaboratoryModal");
const addLaboratoryDescription = document.getElementById(
  "addLaboratoryDescription"
);
const addLaboratoryMessage = document.getElementById("addLaboratoryMessage");
const addLaboratoryCancel = document.getElementById("addLaboratoryCancel");
const addLaboratorySubmit = document.getElementById("addLaboratorySubmit");

const editLaboratoryModal = document.getElementById("editLaboratoryModal");
const editLaboratoryDescription = document.getElementById(
  "editLaboratoryDescription"
);
const editLaboratoryId = document.getElementById("editLaboratoryId");
const editLaboratoryMessage = document.getElementById("editLaboratoryMessage");
const editLaboratoryCancel = document.getElementById("editLaboratoryCancel");
const editLaboratorySubmit = document.getElementById("editLaboratorySubmit");

// STORAGES
const storagesAdd = document.getElementById("storagesAdd");
const storagesSearchInput = document.getElementById("storagesSearchInput");
const storagesSearchButton = document.getElementById("storagesSearchButton");
const storagesTable = document.getElementById("storagesTable");

const addStorageModal = document.getElementById("addStorageModal");
const addStorageDescription = document.getElementById("addStorageDescription");
const addStorageMessage = document.getElementById("addStorageMessage");
const addStorageCancel = document.getElementById("addStorageCancel");
const addStorageSubmit = document.getElementById("addStorageSubmit");

const editStorageModal = document.getElementById("editStorageModal");
const editStorageDescription = document.getElementById(
  "editStorageDescription"
);
const editStorageId = document.getElementById("editStorageId");
const editStorageMessage = document.getElementById("editStorageMessage");
const editStorageCancel = document.getElementById("editStorageCancel");
const editStorageSubmit = document.getElementById("editStorageSubmit");

let complaintsData = [];
let treatmentsData = [];
let laboratoriesData = [];
let storagesData = [];

let complaintsTableData = [];
let treatmentsTableData = [];
let laboratoriesTableData = [];
let storagesTableData = [];

const setupEventListeners = () => {
  //COMPLAINTS
  complaintsAdd.addEventListener("click", handleComplaintsAdd);
  complaintsSearchButton.addEventListener("click", handleComplaintsSearch);
  addComplaintCancel.addEventListener("click", handleAddComplaintCancel);
  addComplaintSubmit.addEventListener("click", handleAddComplaintSubmit);
  editComplaintCancel.addEventListener("click", handleEditComplaintCancel);
  editComplaintSubmit.addEventListener("click", handleEditComplaintSubmit);
  // TREATMENTS
  treatmentsAdd.addEventListener("click", handleTreatmentsAdd);
  treatmentsSearchButton.addEventListener("click", handleTreatmentsSearch);
  addTreatmentCancel.addEventListener("click", handleAddTreatmentCancel);
  addTreatmentSubmit.addEventListener("click", handleAddTreatmentSubmit);
  editTreatmentCancel.addEventListener("click", handleEditTreatmentCancel);
  editTreatmentSubmit.addEventListener("click", handleEditTreatmentSubmit);
  // LABORATORIES
  laboratoriesAdd.addEventListener("click", handleLaboratoriesAdd);
  laboratoriesSearchButton.addEventListener("click", handleLaboratoriesSearch);
  addLaboratoryCancel.addEventListener("click", handleAddLaboratoryCancel);
  addLaboratorySubmit.addEventListener("click", handleAddLaboratorySubmit);
  editLaboratoryCancel.addEventListener("click", handleEditLaboratoryCancel);
  editLaboratorySubmit.addEventListener("click", handleEditLaboratorySubmit);
  // STORAGES
  storagesAdd.addEventListener("click", handleStoragesAdd);
  storagesSearchButton.addEventListener("click", handleStoragesSearch);
  addStorageCancel.addEventListener("click", handleAddStorageCancel);
  addStorageSubmit.addEventListener("click", handleAddStorageSubmit);
  editStorageCancel.addEventListener("click", handleEditStorageCancel);
  editStorageSubmit.addEventListener("click", handleEditStorageSubmit);
};

// COMPLAINTS
const complaintsTDFunction = (key, value, td) => {
  if (key === "edit") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "edit";
    button.addEventListener("click", () => {
      handleEditComplaint(value);
    });
    td.appendChild(button);
  }
};

const handleComplaintsSearch = () => {
  const searchValue = complaintsSearchInput.value.toLowerCase();
  const searchOutput = complaintsTableData.filter((complaint) =>
    Object.values(complaint).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );
  createTableRows(searchOutput, complaintsTable, complaintsTDFunction);
};

const handleComplaintsAdd = () => {
  addComplaintModal.classList.remove("hidden");
};
const handleAddComplaintCancel = () => {
  addComplaintModal.classList.add("hidden");
  addComplaintDescription.value = "";
  addComplaintMessage.innerHTML = "";
};
const handleAddComplaintSubmit = async () => {
  const description = addComplaintDescription.value;
  try {
    const response = await addComplaint(description);
    addComplaintMessage.innerHTML = response.message;
    addComplaintMessage.classList.remove("text-red-600");
    addComplaintMessage.classList.add("text-green-600");
    await updateComplaintsTable();
  } catch (error) {
    addComplaintMessage.innerHTML = error.message;
    addComplaintMessage.classList.remove("text-green-600");
    addComplaintMessage.classList.add("text-red-600");
  }
};
const handleEditComplaint = (id) => {
  const complaint = complaintsData.find((complaint) => complaint.id === id);
  editComplaintModal.classList.remove("hidden");
  editComplaintDescription.value = complaint.description;
  editComplaintId.value = complaint.id;
};
const handleEditComplaintCancel = () => {
  editComplaintModal.classList.add("hidden");
  editComplaintDescription.value = "";
  editComplaintMessage.innerHTML = "";
  editComplaintId.value = "";
};
const handleEditComplaintSubmit = async () => {
  const description = editComplaintDescription.value;
  const id = editComplaintId.value;
  try {
    const response = await updateComplaint(id, description);
    editComplaintMessage.innerHTML = response.message;
    editComplaintMessage.classList.remove("text-red-600");
    editComplaintMessage.classList.add("text-green-600");
    await updateComplaintsTable();
  } catch (error) {
    editComplaintMessage.innerHTML = error.message;
    editComplaintMessage.classList.remove("text-green-600");
    editComplaintMessage.classList.add("text-red-600");
  }
};

const updateComplaintsTable = async () => {
  try {
    const complaintsResponse = await getComplaints();
    complaintsData = complaintsResponse.complaints;

    complaintsTableData = complaintsData.map((complaint) => ({
      id: complaint.id,
      description: complaint.description,
      edit: complaint.id,
    }));

    complaintsTableData.sort((a, b) => b.description - a.description);
    createTableRows(complaintsTableData, complaintsTable, complaintsTDFunction);
  } catch (error) {
    const tableBody = complaintsTable.querySelector("tbody");
    tableBody.innerHTML = "";
    console.error(error);
  }
};

// TREATMENTS
const treatmentsTDFunction = (key, value, td) => {
  if (key === "edit") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "edit";
    button.addEventListener("click", () => {
      handleEditTreatment(value);
    });
    td.appendChild(button);
  }
};

const handleTreatmentsSearch = () => {
  const searchValue = treatmentsSearchInput.value.toLowerCase();
  const searchOutput = treatmentsTableData.filter((treatment) =>
    Object.values(treatment).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );
  createTableRows(searchOutput, treatmentsTable, treatmentsTDFunction);
};

const handleTreatmentsAdd = () => {
  addTreatmentModal.classList.remove("hidden");
};
const handleAddTreatmentCancel = () => {
  addTreatmentModal.classList.add("hidden");
  addTreatmentDescription.value = "";
  addTreatmentMessage.innerHTML = "";
};
const handleAddTreatmentSubmit = async () => {
  const description = addTreatmentDescription.value;
  try {
    const response = await addTreatment(description);
    addTreatmentMessage.innerHTML = response.message;
    addTreatmentMessage.classList.remove("text-red-600");
    addTreatmentMessage.classList.add("text-green-600");
    await updateTreatmentsTable();
  } catch (error) {
    addTreatmentMessage.innerHTML = error.message;
    addTreatmentMessage.classList.remove("text-green-600");
    addTreatmentMessage.classList.add("text-red-600");
  }
};
const handleEditTreatment = (id) => {
  const treatment = treatmentsData.find((treatment) => treatment.id === id);
  editTreatmentModal.classList.remove("hidden");
  editTreatmentDescription.value = treatment.description;
  editTreatmentId.value = treatment.id;
};
const handleEditTreatmentCancel = () => {
  editTreatmentModal.classList.add("hidden");
  editTreatmentDescription.value = "";
  editTreatmentMessage.innerHTML = "";
  editTreatmentId.value = "";
};
const handleEditTreatmentSubmit = async () => {
  const description = editTreatmentDescription.value;
  const id = editTreatmentId.value;
  try {
    const response = await updateTreatment(id, description);
    editTreatmentMessage.innerHTML = response.message;
    editTreatmentMessage.classList.remove("text-red-600");
    editTreatmentMessage.classList.add("text-green-600");
    await updateTreatmentsTable();
  } catch (error) {
    editTreatmentMessage.innerHTML = error.message;
    editTreatmentMessage.classList.remove("text-green-600");
    editTreatmentMessage.classList.add("text-red-600");
  }
};

const updateTreatmentsTable = async () => {
  try {
    const treatmentsResponse = await getTreatments();
    treatmentsData = treatmentsResponse.treatments;

    treatmentsTableData = treatmentsData.map((treatment) => ({
      id: treatment.id,
      description: treatment.description,
      edit: treatment.id,
    }));

    treatmentsTableData.sort((a, b) => b.description - a.description);
    createTableRows(treatmentsTableData, treatmentsTable, treatmentsTDFunction);
  } catch (error) {
    const tableBody = treatmentsTable.querySelector("tbody");
    tableBody.innerHTML = "";
    console.error(error);
  }
};
// LABORATORIES
const laboratoriesTDFunction = (key, value, td) => {
  if (key === "edit") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "edit";
    button.addEventListener("click", () => {
      handleEditLaboratory(value);
    });
    td.appendChild(button);
  }
};

const handleLaboratoriesSearch = () => {
  const searchValue = laboratoriesSearchInput.value.toLowerCase();
  const searchOutput = laboratoriesTableData.filter((laboratory) =>
    Object.values(laboratory).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );
  createTableRows(searchOutput, laboratoriesTable, laboratoriesTDFunction);
};

const handleLaboratoriesAdd = () => {
  addLaboratoryModal.classList.remove("hidden");
};
const handleAddLaboratoryCancel = () => {
  addLaboratoryModal.classList.add("hidden");
  addLaboratoryDescription.value = "";
  addLaboratoryMessage.innerHTML = "";
};
const handleAddLaboratorySubmit = async () => {
  const description = addLaboratoryDescription.value;
  try {
    const response = await addLaboratory(description);
    addLaboratoryMessage.innerHTML = response.message;
    addLaboratoryMessage.classList.remove("text-red-600");
    addLaboratoryMessage.classList.add("text-green-600");
    await updateLaboratoriesTable();
  } catch (error) {
    addLaboratoryMessage.innerHTML = error.message;
    addLaboratoryMessage.classList.remove("text-green-600");
    addLaboratoryMessage.classList.add("text-red-600");
  }
};
const handleEditLaboratory = (id) => {
  const laboratory = laboratoriesData.find((laboratory) => laboratory.id === id);
  editLaboratoryModal.classList.remove("hidden");
  editLaboratoryDescription.value = laboratory.description;
  editLaboratoryId.value = laboratory.id;
};
const handleEditLaboratoryCancel = () => {
  editLaboratoryModal.classList.add("hidden");
  editLaboratoryDescription.value = "";
  editLaboratoryMessage.innerHTML = "";
  editLaboratoryId.value = "";
};
const handleEditLaboratorySubmit = async () => {
  const description = editLaboratoryDescription.value;
  const id = editLaboratoryId.value;
  try {
    const response = await updateLaboratory(id, description);
    editLaboratoryMessage.innerHTML = response.message;
    editLaboratoryMessage.classList.remove("text-red-600");
    editLaboratoryMessage.classList.add("text-green-600");
    await updateLaboratoriesTable();
  } catch (error) {
    editLaboratoryMessage.innerHTML = error.message;
    editLaboratoryMessage.classList.remove("text-green-600");
    editLaboratoryMessage.classList.add("text-red-600");
  }
};

const updateLaboratoriesTable = async () => {
  try {
    const laboratoriesResponse = await getLaboratories();
    laboratoriesData = laboratoriesResponse.laboratories;

    laboratoriesTableData = laboratoriesData.map((laboratory) => ({
      id: laboratory.id,
      description: laboratory.description,
      edit: laboratory.id,
    }));

    laboratoriesTableData.sort((a, b) => b.description - a.description);
    createTableRows(laboratoriesTableData, laboratoriesTable, laboratoriesTDFunction);
  } catch (error) {
    const tableBody = laboratoriesTable.querySelector("tbody");
    tableBody.innerHTML = "";
    console.error(error);
  }
};
// STORAGES
const storagesTDFunction = (key, value, td) => {
  if (key === "edit") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "edit";
    button.addEventListener("click", () => {
      handleEditStorage(value);
    });
    td.appendChild(button);
  }
};

const handleStoragesSearch = () => {
  const searchValue = storagesSearchInput.value.toLowerCase();
  const searchOutput = storagesTableData.filter((storage) =>
    Object.values(storage).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );
  createTableRows(searchOutput, storagesTable, storagesTDFunction);
};

const handleStoragesAdd = () => {
  addStorageModal.classList.remove("hidden");
};
const handleAddStorageCancel = () => {
  addStorageModal.classList.add("hidden");
  addStorageDescription.value = "";
  addStorageMessage.innerHTML = "";
};
const handleAddStorageSubmit = async () => {
  const description = addStorageDescription.value;
  try {
    const response = await addStorage(description);
    addStorageMessage.innerHTML = response.message;
    addStorageMessage.classList.remove("text-red-600");
    addStorageMessage.classList.add("text-green-600");
    await updateStoragesTable();
  } catch (error) {
    addStorageMessage.innerHTML = error.message;
    addStorageMessage.classList.remove("text-green-600");
    addStorageMessage.classList.add("text-red-600");
  }
};
const handleEditStorage = (id) => {
  const storage = storagesData.find((storage) => storage.id === id);
  editStorageModal.classList.remove("hidden");
  editStorageDescription.value = storage.description;
  editStorageId.value = storage.id;
};
const handleEditStorageCancel = () => {
  editStorageModal.classList.add("hidden");
  editStorageDescription.value = "";
  editStorageMessage.innerHTML = "";
  editStorageId.value = "";
};
const handleEditStorageSubmit = async () => {
  const description = editStorageDescription.value;
  const id = editStorageId.value;
  try {
    const response = await updateStorage(id, description);
    editStorageMessage.innerHTML = response.message;
    editStorageMessage.classList.remove("text-red-600");
    editStorageMessage.classList.add("text-green-600");
    await updateStoragesTable();
  } catch (error) {
    editStorageMessage.innerHTML = error.message;
    editStorageMessage.classList.remove("text-green-600");
    editStorageMessage.classList.add("text-red-600");
  }
};

const updateStoragesTable = async () => {
  try {
    const storagesResponse = await getStorages();
    storagesData = storagesResponse.storages;

    storagesTableData = storagesData.map((storage) => ({
      id: storage.id,
      description: storage.description,
      edit: storage.id,
    }));

    storagesTableData.sort((a, b) => b.description - a.description);
    createTableRows(storagesTableData, storagesTable, storagesTDFunction);
  } catch (error) {
    const tableBody = storagesTable.querySelector("tbody");
    tableBody.innerHTML = "";
    console.error(error);
  }
};


const initializeSettings = async () => {
  await updateComplaintsTable();
  await updateTreatmentsTable();
  await updateLaboratoriesTable();
  await updateStoragesTable();
  setupEventListeners();
};

initializeSettings();
