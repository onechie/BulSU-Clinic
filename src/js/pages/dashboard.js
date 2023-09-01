import { getMedicines } from "../api/medicines.js";
import { getComplaints } from "../api/complaints.js";
import { getTreatments } from "../api/treatments.js";
import { getLaboratories } from "../api/laboratories.js";
import { addRecord } from "../api/records.js";
import { createTableRows, createOptions } from "../utils/utils.js";

const PAGE_SIZE = 10;

const searchInput = document.getElementById("searchInput");
const dashboardMedicinesTable = document.getElementById(
  "dashboardMedicinesTable"
);
const pageCountElement = document.getElementById("pageCount");
const pageNumberInput = document.getElementById("pageNumber");
const addRecordModal = document.getElementById("addRecordModal");
const addRecordButton = document.getElementById("addRecordButton");
const addRecordMessage = document.getElementById("addRecordMessage");
const addRecordForm = document.getElementById("addRecordForm");
const addRecordCancel = document.getElementById("addRecordCancel");
const complaintsList = document.getElementById("complaintsList");
const medicinesList = document.getElementById("medicinesList");
const medicinesStock = document.getElementById("medicinesStock");
const treatmentsList = document.getElementById("treatmentsList");
const laboratoriesList = document.getElementById("laboratoriesList");
const addRecordAttachments = document.getElementById("addRecordAttachments");
const attachmentsList = document.getElementById("attachmentsList");
const emergencyButton = document.getElementById("emergencyButton");
const emergencyModal = document.getElementById("emergencyModal");
const emergencyClose = document.getElementById("emergencyClose");

let complaintsData = [];
let medicinesData = [];
let treatmentsData = [];
let laboratoriesData = [];
let medicinesTableData = [];
let pages = [];
let currentPage = 1;

const customTDFunction = (key, value, td) => {
  if (key === "expiration") {
    const today = new Date();
    const expirationDate = new Date(value);
    td.classList.remove("text-gray-500");

    if (expirationDate < today) {
      td.classList.add("text-red-500");
    } else if (expirationDate < new Date(today.setDate(today.getDate() + 30))) {
      td.classList.add("text-blue-500");
    } else {
      td.classList.add("text-gray-500");
    }
  }
};

const sortMedicinesByExpiration = (medicinesData) => {
  return medicinesData
    .slice()
    .sort((a, b) => new Date(a.expiration) - new Date(b.expiration));
};

const setupEventListeners = () => {
  document
    .getElementById("searchButton")
    .addEventListener("click", handleSearch);
  document
    .getElementById("pageNext")
    .addEventListener("click", () => handlePageChange(1));
  document
    .getElementById("pagePrev")
    .addEventListener("click", () => handlePageChange(-1));
  pageNumberInput.addEventListener("change", handlePageInputChange);
  addRecordButton.addEventListener("click", () => {
    addRecordModal.classList.remove("hidden");
  });
  addRecordForm.medication.addEventListener("change", handleMedicineChange);
  addRecordForm.addEventListener("submit", handleAddRecordSubmit);
  addRecordCancel.addEventListener("click", handleAddRecordCancel);
  addRecordAttachments.addEventListener("change", handleAddRecordAttachments);
  emergencyButton.addEventListener("click", () => {
    emergencyModal.classList.remove("hidden");
  });
  emergencyClose.addEventListener("click", () => {
    emergencyModal.classList.add("hidden");
  });
};

const renderPage = (pageNumber) => {
  pageNumber = Math.min(Math.max(1, pageNumber), pages.length);
  createTableRows(
    pages[pageNumber - 1],
    dashboardMedicinesTable,
    customTDFunction
  );
  currentPage = pageNumber;
  pageNumberInput.value = currentPage;
};

const handlePageChange = (change) => {
  renderPage(currentPage + change);
};
const handlePageInputChange = () => {
  renderPage(parseInt(pageNumberInput.value));
};
const handleSearch = () => {
  const searchValue = searchInput.value.toLowerCase();
  const searchOutput = medicinesTableData.filter((medicine) =>
    Object.values(medicine).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );

  pageCountElement.innerText = Math.ceil(searchOutput.length / PAGE_SIZE);
  pages = Array.from(
    { length: Math.ceil(searchOutput.length / PAGE_SIZE) },
    (_, i) => searchOutput.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
  );

  renderPage(1);
};
const handleMedicineChange = (e) => {
  const medicineName = e.target.value;
  const medicine = medicinesData.find(
    (medicine) => medicine.name === medicineName
  );
  if (!medicine) {
    addRecordForm.quantity.disabled = true;
    addRecordForm.quantity.value = 0;
    medicinesStock.innerText = 0;
    return;
  }
  addRecordForm.quantity.disabled = false;
  medicinesStock.innerText = medicine.itemsCount - medicine.itemsDeducted;
};

const handleAddRecordSubmit = async (event) => {
  event.preventDefault();
  const recordData = new FormData(addRecordForm);
  try {
    const data = await addRecord(recordData);
    handleAddRecordMessage(data.message, "text-green-500");
    attachmentsList.innerHTML = "";
    addRecordForm.reset();
    medicinesStock.innerText = 0;
    await updateMedicinesList();
    await updateMedicineTable();
  } catch (error) {
    handleAddRecordMessage(error.message, "text-red-500");
  }
};

const handleAddRecordMessage = (message, colorClass) => {
  addRecordMessage.innerText = message;
  addRecordMessage.classList.remove("text-red-500", "text-green-500");
  addRecordMessage.classList.add(colorClass);
};

const handleAddRecordCancel = () => {
  addRecordModal.classList.add("hidden");
  addRecordForm.reset();
  attachmentsList.innerHTML = "";
  const attachmentItem = document.createElement("div");
  attachmentItem.className =
    "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
  attachmentItem.innerText = "No attachments";
  attachmentsList.appendChild(attachmentItem);
  addRecordMessage.innerText = "";
};

const handleAddRecordAttachments = () => {
  const { files } = addRecordAttachments;
  attachmentsList.innerHTML = "";
  for (let i = 0; i < files.length; i++) {
    const attachment = files[i];
    const attachmentItem = document.createElement("div");
    attachmentItem.className =
      "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
    attachmentItem.innerText = attachment.name;
    attachmentsList.appendChild(attachmentItem);
  }
  if (files.length <= 0) {
    const attachmentItem = document.createElement("div");
    attachmentItem.className =
      "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
    attachmentItem.innerText = "No attachments";
    attachmentsList.appendChild(attachmentItem);
  }
};

const updateComplaintsList = async () => {
  complaintsList.innerHTML = "";
  try {
    complaintsData = await getComplaints();
    const complaintsOptions = createOptions(complaintsData, "description");
    complaintsOptions.forEach((option) => {
      complaintsList.appendChild(option);
    });
  } catch (error) {
    console.error(error);
  }
};
const updateMedicinesList = async () => {
  medicinesList.innerHTML = "";
  try {
    const medicinesResponse = await getMedicines();
    medicinesData = medicinesResponse.medicines;
    const medicinesOptions = createOptions(medicinesData, "name");
    medicinesOptions.forEach((option) => {
      medicinesList.appendChild(option);
    });
  } catch (error) {
    console.error(error);
  }
};
const updateTreatmentsList = async () => {
  treatmentsList.innerHTML = "";
  try {
    treatmentsData = await getTreatments();
    const treatmentsOptions = createOptions(treatmentsData, "description");
    treatmentsOptions.forEach((option) => {
      treatmentsList.appendChild(option);
    });
  } catch (error) {
    console.error(error);
  }
};

const updateLaboratoriesList = async () => {
  laboratoriesList.innerHTML = "";
  try {
    laboratoriesData = await getLaboratories();
    const laboratoriesOptions = createOptions(laboratoriesData, "description");
    laboratoriesOptions.forEach((option) => {
      laboratoriesList.appendChild(option);
    });
  } catch (error) {
    console.error(error);
  }
};

const updateMedicineTable = () => {
  if (medicinesData.length >= 1) {
    medicinesTableData = sortMedicinesByExpiration(medicinesData).map(
      ({ brand, itemsCount, itemsDeducted, expiration, storage }) => ({
        brand,
        remaining: itemsCount - itemsDeducted,
        expiration,
        storage,
      })
    );

    pageCountElement.innerText = Math.ceil(
      medicinesTableData.length / PAGE_SIZE
    );
    pages = Array.from(
      { length: Math.ceil(medicinesTableData.length / PAGE_SIZE) },
      (_, i) => medicinesTableData.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
    );
    renderPage(1);
  }
};
const initializeDashboard = async () => {
  await updateComplaintsList();
  await updateMedicinesList();
  await updateTreatmentsList();
  await updateLaboratoriesList();
  updateMedicineTable();
  setupEventListeners();
};

initializeDashboard();
