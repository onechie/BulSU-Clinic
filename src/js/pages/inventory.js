import { getMedicines, addMedicine, updateMedicine } from "../api/medicines.js";
import { getStorages } from "../api/storages.js";
import {
  createTableRows,
  createOptions,
  getById,
  onClick,
  handleOpen,
} from "../utils/utils.js";

const PAGE_SIZE = 10;

const searchInput = getById("searchInput");
const printInventory = getById("printInventory");
const inventoryMedicinesTable = getById("inventoryMedicinesTable");
const pageCountElement = getById("pageCount");
const pageNumberInput = getById("pageNumber");
const addMedicineModal = getById("addMedicineModal");
const addMedicineButton = getById("addMedicineButton");
const addMedicineMessage = getById("addMedicineMessage");
const addMedicineForm = getById("addMedicineForm");
const addMedicineCancel = getById("addMedicineCancel");
const addMedicineStoragesList = getById("addMedicineStoragesList");
const editMedicineModal = getById("editMedicineModal");
const editMedicineMessage = getById("editMedicineMessage");
const editMedicineForm = getById("editMedicineForm");
const editMedicineCancel = getById("editMedicineCancel");
const editMedicineStoragesList = getById("editMedicineStoragesList");

let medicinesData = [];
let storagesData = [];
let medicinesTableData = [];
let pages = [];
let currentPage = 1;

const customTDFunction = (key, value, td) => {
  if (key === "id") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500 print:hidden";
    button.innerText = "edit";
    button.addEventListener("click", () => {
      handleEditButtonClick(value);
    });
    td.appendChild(button);
  }
};

const setupEventListeners = () => {
  onClick(getById("searchButton"), handleSearch);
  onClick(printInventory, () => window.print());
  onClick(getById("pageNext"), () => handlePageChange(1));
  onClick(getById("pagePrev"), () => handlePageChange(-1));
  pageNumberInput.addEventListener("change", handlePageInputChange);
  onClick(addMedicineButton, () => {
    handleOpen(addMedicineModal);
  });
  addMedicineForm.boxesCount.addEventListener(
    "change",
    handleItemsQuantityChange
  );
  addMedicineForm.itemsPerBox.addEventListener(
    "change",
    handleItemsQuantityChange
  );
  addMedicineForm.addEventListener("submit", handleAddMedicineSubmit);
  onClick(addMedicineCancel, handleAddMedicineCancel);
  editMedicineForm.boxesCount.addEventListener(
    "change",
    handleEditMedicineQuantities
  );
  editMedicineForm.itemsPerBox.addEventListener(
    "change",
    handleEditMedicineQuantities
  );
  editMedicineForm.addEventListener("submit", handleEditMedicineSubmit);
  onClick(editMedicineCancel, handleEditMedicineCancel);
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

const handleItemsQuantityChange = () => {
  addMedicineForm.itemsCount.value =
    addMedicineForm.itemsPerBox.value * addMedicineForm.boxesCount.value;
};
const handleEditMedicineQuantities = () => {
  editMedicineForm.itemsCount.value =
    editMedicineForm.itemsPerBox.value * editMedicineForm.boxesCount.value;
  editMedicineForm.itemsRemaining.value =
    editMedicineForm.itemsPerBox.value * editMedicineForm.boxesCount.value -
    editMedicineForm.itemsDeducted.value;
};

const handleAddMedicineSubmit = async (event) => {
  event.preventDefault();
  const medicineData = new FormData(addMedicineForm);
  try {
    const data = await addMedicine(medicineData);
    handleAddMedicineMessage(data.message, "text-green-500");
    addMedicineForm.reset();
    updateMedicineTable();
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
const handleEditButtonClick = (id) => {
  const medicine = medicinesData.find((medicine) => medicine.id === id);
  editMedicineForm.id.value = medicine.id;
  editMedicineForm.name.value = medicine.name;
  editMedicineForm.brand.value = medicine.brand;
  editMedicineForm.unit.value = medicine.unit;
  editMedicineForm.expiration.value = medicine.expiration;
  editMedicineForm.boxesCount.value = medicine.boxesCount;
  editMedicineForm.itemsPerBox.value = medicine.itemsPerBox;
  editMedicineForm.itemsCount.value = medicine.itemsCount;
  editMedicineForm.itemsDeducted.value = medicine.itemsDeducted;
  editMedicineForm.itemsRemaining.value =
    medicine.itemsCount - medicine.itemsDeducted;
  editMedicineForm.storage.value = medicine.storage;
  editMedicineModal.classList.remove("hidden");
};
const handleEditMedicineCancel = () => {
  editMedicineModal.classList.add("hidden");
  editMedicineForm.reset();
  editMedicineMessage.innerText = "";
};
const handleEditMedicineSubmit = async (event) => {
  event.preventDefault();
  const medicineData = new FormData(editMedicineForm);

  try {
    const data = await updateMedicine(medicineData);
    handleEditMedicineMessage(data.message, "text-green-500");
    updateMedicineTable();
  } catch (error) {
    handleEditMedicineMessage(error.message, "text-red-500");
  }
};
const handleEditMedicineMessage = (message, colorClass) => {
  editMedicineMessage.innerText = message;
  editMedicineMessage.classList.remove("text-red-500", "text-green-500");
  editMedicineMessage.classList.add(colorClass);
};

const updateStoragesList = async () => {
  addMedicineStoragesList.innerHTML = "";
  editMedicineStoragesList.innerHTML = "";
  try {
    storagesData = await getStorages();
    const storagesOptions = createOptions(storagesData, "description");
    storagesOptions.forEach((option) => {
      addMedicineStoragesList.appendChild(option);
      editMedicineStoragesList.appendChild(option.cloneNode(true));
    });
  } catch (error) {
    console.error(error);
  }
};
const updateMedicineTable = async () => {
  try {
    const medicinesResponse = await getMedicines();
    medicinesData = medicinesResponse.medicines;

    medicinesTableData = medicinesData.map((medicine) => ({
      name: medicine.name,
      brand: medicine.brand,
      unit: medicine.unit,
      expiration: medicine.expiration,
      boxesCount: medicine.boxesCount,
      itemsPerBox: medicine.itemsPerBox,
      totalCount: medicine.itemsCount,
      itemsDeducted: medicine.itemsDeducted,
      remaining: medicine.itemsCount - medicine.itemsDeducted,
      id: medicine.id,
    }));

    pageCountElement.innerText = Math.ceil(
      medicinesTableData.length / PAGE_SIZE
    );
    pages = Array.from(
      { length: Math.ceil(medicinesTableData.length / PAGE_SIZE) },
      (_, i) => medicinesTableData.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
    );
    renderPage(1);
  } catch (error) {
    console.error(error);
  }
};
const initializeInventory = async () => {
  await updateStoragesList();
  await updateMedicineTable();
  setupEventListeners();
};
initializeInventory();
