import { getMedicines } from "../api/medicines.js";
import { createTableRows } from "../utils/createTableRows.js";

// Constants
const PAGE_SIZE = 10;

// DOM elements
const searchInput = document.getElementById("searchInput");
const dashboardMedicinesTable = document.getElementById(
  "dashboardMedicinesTable"
);
const pageCountElement = document.getElementById("pageCount");
const pageNumberInput = document.getElementById("pageNumber");

// Data and state
let medicines = [];
let pages = [];
let currentPage = 1;

// Function to apply expired-related classes
const checkIfExpired = (key, value, td) => {
  // Check if the key is "expiration"
  if (key === "expiration") {
    const today = new Date();
    const expirationDate = new Date(value);
    td.classList.remove("text-gray-500");

    // Apply appropriate classes based on expiration
    if (expirationDate < today) {
      td.classList.add("text-red-500");
    } else if (expirationDate < today.setDate(today.getDate() + 30)) {
      td.classList.add("text-blue-500");
    } else {
      td.classList.add("text-gray-500");
    }
  }
};

// Function to sort medicines by expiration
const sortMedicinesByExpiration = (medicinesData) => {
  return medicinesData.slice().sort((a, b) => {
    const expirationA = new Date(a.expiration).getTime();
    const expirationB = new Date(b.expiration).getTime();
    return expirationA - expirationB;
  });
};

// Function to set up event listeners
const setupEventListeners = () => {
  document
    .getElementById("searchButton")
    .addEventListener("click", handleSearch);
  document.getElementById("pageNext").addEventListener("click", handlePageNext);
  document.getElementById("pagePrev").addEventListener("click", handlePagePrev);
  pageNumberInput.addEventListener("change", handlePageChange);
};

// Function to render a specific page
const renderPage = (pageNumber) => {
  createTableRows(
    pages[pageNumber - 1],
    dashboardMedicinesTable,
    checkIfExpired
  );
  pageNumberInput.value = pageNumber;
};

// Function to handle next page
const handlePageNext = () => {
  if (currentPage === pages.length) return;
  currentPage++;
  renderPage(currentPage);
};

// Function to handle previous page
const handlePagePrev = () => {
  if (currentPage === 1) return;
  currentPage--;
  renderPage(currentPage);
};

// Function to handle page change via input
const handlePageChange = (e) => {
  let newPageNumber = parseInt(e.target.value);
  newPageNumber = Math.max(1, Math.min(newPageNumber, pages.length));

  if (newPageNumber === currentPage) return;
  currentPage = newPageNumber;
  renderPage(currentPage);
};

// Function to perform search
const handleSearch = () => {
  const searchValue = searchInput.value.toLowerCase();
  const searchOutput = medicines.filter((medicine) => {
    const values = Object.values(medicine).map((value) =>
      value.toString().toLowerCase()
    );
    return values.some((value) => value.includes(searchValue));
  });

  pageCountElement.innerText = Math.ceil(searchOutput.length / PAGE_SIZE);

  // Divide searchOutput into pages
  pages = [];
  for (let i = 0; i < searchOutput.length; i += PAGE_SIZE) {
    pages.push(searchOutput.slice(i, i + PAGE_SIZE));
  }

  renderPage(1);
};

// Function to initialize the dashboard
const initializeDashboard = async () => {
  try {
    const data = await getMedicines();
    const sortedMedicines = sortMedicinesByExpiration(data.medicines);

    // Create medicines array with selected properties
    medicines = sortedMedicines.map((medicine) => {
      return {
        brand: medicine.brand,
        remaining: medicine.itemsCount,
        expiration: medicine.expiration,
        storage: medicine.storage,
      };
    });

    // Calculate total pages and set initial page count
    pageCountElement.innerText = Math.ceil(medicines.length / PAGE_SIZE);

    // Divide medicines into pages
    pages = [];
    for (let i = 0; i < medicines.length; i += PAGE_SIZE) {
      pages.push(medicines.slice(i, i + PAGE_SIZE));
    }

    // Set up event listeners, render initial page
    setupEventListeners();
    renderPage(1);

    console.log(pages[0]);
  } catch (error) {
    console.error(error);
  }
};

// Initialize the dashboard
initializeDashboard();
