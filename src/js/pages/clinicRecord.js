import { getRecords } from "../api/records.js";
import { createTableRows } from "../utils/utils.js";

const PAGE_SIZE = 10;

const searchInput = document.getElementById("searchInput");
const clinicRecordTable = document.getElementById("clinicRecordTable");
const pageCountElement = document.getElementById("pageCount");
const pageNumberInput = document.getElementById("pageNumber");

const viewHistoryModal = document.getElementById("viewHistoryModal");
const viewHistoryName = document.getElementById("viewHistoryName");
const viewHistoryTable = document.getElementById("viewHistoryTable");
const viewHistoryClose = document.getElementById("viewHistoryClose");

let recordsData = [];
let recordsTableData = [];
let pages = [];
let currentPage = 1;

const customTDFunction = (key, value, td) => {
  if (key === "viewHistory") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "view history";
    button.addEventListener("click", () => {
      handleViewHistoryClick(value);
    });
    td.appendChild(button);
  } else if (key === "complaint") {
    td.classList.add("w-1/5");
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
  viewHistoryClose.addEventListener("click", handleViewHistoryClose);
};

const renderPage = (pageNumber) => {
  pageNumber = Math.min(Math.max(1, pageNumber), pages.length);
  createTableRows(pages[pageNumber - 1], clinicRecordTable, customTDFunction);
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
  const searchOutput = recordsTableData.filter((medicine) =>
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

const handleViewHistoryClick = (name) => {
  viewHistoryModal.classList.remove("hidden");
  const records = recordsData.filter((record) => record.name === name);
  const newRecords = records.map((record) => ({
    date: record.date,
    complaint: record.complaint,
    medication: record.medication,
    id: record.id,
  }));

  viewHistoryName.innerText = name;
  const thisTDFunction = (key, value, td) => {
    if (key === "id") {
      td.innerText = "";
      td.classList.remove("text-gray-500", "pe-3");
      td.classList.add("text-end");
      const button = document.createElement("button");
      button.className = "underline text-blue-500";
      button.innerText = "see attachments";
      button.addEventListener("click", () => {
        handleSeeAttachments(value);
      });
      td.appendChild(button);
    } else if (key === "complaint") {
      td.classList.add("w-1/3");
    }
  };
  createTableRows(newRecords, viewHistoryTable, thisTDFunction);
};

const handleSeeAttachments = (id) => {
  const record = recordsData.find((record) => record.id === id);

  console.log(id);
};

const handleViewHistoryClose = () => {
  viewHistoryModal.classList.add("hidden");
  viewHistoryName.innerText = "";
  const tableBody = viewHistoryTable.querySelector("tbody");
  tableBody.innerHTML = "";
};
const updateRecordTable = async () => {
  try {
    const recordsResponse = await getRecords();
    recordsData = recordsResponse.records;

    recordsTableData = recordsData.map((record) => ({
      name: record.name,
      complaint: record.complaint,
      date: record.date,
      medication: record.medication,
      nurse: "nurse",
      viewHistory: record.name,
    }));

    pageCountElement.innerText = Math.ceil(recordsTableData.length / PAGE_SIZE);
    pages = Array.from(
      { length: Math.ceil(recordsTableData.length / PAGE_SIZE) },
      (_, i) => recordsTableData.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
    );
    renderPage(1);
  } catch (error) {
    console.error(error);
  }
};

const initializeClinicRecord = async () => {
  await updateRecordTable();
  setupEventListeners();
};

initializeClinicRecord();
