import { getMedicines, addMedicine } from "../api/medicines.js";
import { getStorages } from "../api/storages.js";
import { createTableRows, createOptions } from "../utils/utils.js";

const PAGE_SIZE = 10;

const searchInput = document.getElementById("searchInput");
const inventoryMedicinesTable = document.getElementById(
  "inventoryMedicinesTable"
);
const pageCountElement = document.getElementById("pageCount");
const pageNumberInput = document.getElementById("pageNumber");
const addMedicineModal = document.getElementById("addMedicineModal");
const addMedicineButton = document.getElementById("addMedicineButton");
const addMedicineMessage = document.getElementById("addMedicineMessage");
const addMedicineForm = document.getElementById("addMedicineForm");
const addMedicineCancel = document.getElementById("addMedicineCancel");
const storagesList = document.getElementById("storagesList");

let medicinesData = [];
let storagesData = [];
let medicinesTableData = [];
let pages = [];
let currentPage = 1;

const customTDFunction = (key, value, td) => {
  if (key === "id") {
    td.innerText = "";
    td.classList.remove("text-gray-500");
    td.classList.add("max-w-[20px]");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "edit";
    button.addEventListener("click", () => {
      handleEditButtonClick(value);
    });
    td.appendChild(button);
  }
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
  addMedicineButton.addEventListener("click", showAddMedicineModal);
  addMedicineForm.boxesCount.addEventListener(
    "change",
    handleItemsQuantityChange
  );
  addMedicineForm.itemsPerBox.addEventListener(
    "change",
    handleItemsQuantityChange
  );
  addMedicineForm.addEventListener("submit", handleAddMedicineSubmit);
  addMedicineCancel.addEventListener("click", handleAddMedicineCancel);
};

const renderPage = (pageNumber) => {
  pageNumber = Math.min(Math.max(1, pageNumber), pages.length);
  createTableRows(
    pages[pageNumber - 1],
    inventoryMedicinesTable,
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
const handleEditButtonClick = (id) => {
  const medicine = medicinesTableData.find((medicine) => medicine.id === id);
  console.log(medicine);
};

const showAddMedicineModal = () => {
  addMedicineModal.classList.remove("hidden");
};

const handleItemsQuantityChange = () => {
  addMedicineForm.itemsCount.value =
    addMedicineForm.itemsPerBox.value * addMedicineForm.boxesCount.value;
};

const handleAddMedicineSubmit = async (event) => {
  event.preventDefault();
  const medicineData = new FormData(addMedicineForm);
  try {
    const data = await addMedicine(medicineData);
    handleAddMedicineMessage(data.message, "text-green-500");
    addMedicineForm.reset();
  } catch (error) {
    handleAddMedicineMessage(error.message, "text-red-500");
  }
};
const handleAddMedicineMessage = (message, colorClass) => {
  addMedicineMessage.innerText = message;
  addMedicineMessage.classList.remove("text-red-500", "text-green-500");
  addMedicineMessage.classList.add(colorClass);
};

const handleAddMedicineCancel = () => {
  addMedicineModal.classList.add("hidden");
  addMedicineForm.reset();
  addMedicineMessage.innerText = "";
};

const initializeInventory = async () => {
  try {
    const [medicinesResponse, storagesResponse] = await Promise.all([
      getMedicines(),
      getStorages(),
    ]);

    medicinesData = medicinesResponse.medicines;
    storagesData = storagesResponse.storages;

    medicinesTableData = medicinesData.map((medicine) => ({
      name: medicine.name,
      brand: medicine.brand,
      unit: medicine.unit,
      expiration: medicine.expiration,
      boxesCount: medicine.boxesCount,
      itemsPerBox: medicine.itemsPerBox,
      remaining: medicine.itemsCount,
      itemsDeducted: medicine.itemsDeducted,
      id: medicine.id,
    }));

    pageCountElement.innerText = Math.ceil(
      medicinesTableData.length / PAGE_SIZE
    );
    pages = Array.from(
      { length: Math.ceil(medicinesTableData.length / PAGE_SIZE) },
      (_, i) => medicinesTableData.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
    );

    storagesList.innerHTML = "";
    const storagesOptions = createOptions(storagesData, "description");
    storagesOptions.forEach((option) => {
      storagesList.appendChild(option);
    });

    setupEventListeners();
    renderPage(1);
  } catch (error) {
    console.error(error);
  }
};

initializeInventory();
