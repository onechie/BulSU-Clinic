import { getMedicines } from "../api/medicines.js";
import { getRecords } from "../api/records.js";
import { getById } from "../utils/utils.js";

// Define a variable to store the current chart instance
let currentChart = null;

const container = getById("barChart");
const selectMonth = getById("selectMonth");

let medicinesData = [];
let recordsData = [];
let groupedRecords = {};
let medicineNames = [];
let monthOptions = new Set();

document.addEventListener("DOMContentLoaded", () => {
  getAndDisplaySummarization();
});
const sortLikePyramid = (arr) => {
  const compareByItemsD = (a, b) => b.itemsDeducted - a.itemsDeducted;
  arr.sort(compareByItemsD);
  const returnData = [];
  for (let i = 0; i < arr.length; i++) {
    if (i % 2 === 0) {
      returnData.push(arr[i]);
    } else {
      returnData.unshift(arr[i]);
    }
  }
  return returnData;
};

const groupRecords = () => {
  recordsData.forEach((record) => {
    const createdAt = new Date(record.date);
    const monthYear = createdAt.toLocaleString("en-US", {
      month: "short",
      year: "numeric",
    });
    monthOptions.add(monthYear);
    // Create the group if it doesn't exist
    if (!groupedRecords[monthYear]) {
      groupedRecords[monthYear] = {};
    }

    // Initialize the medication if it doesn't exist in the group
    if (!groupedRecords[monthYear][record.medication]) {
      groupedRecords[monthYear][record.medication] = 0;
    }

    // Accumulate the quantity
    groupedRecords[monthYear][record.medication] += record.quantity;
  });
};

const fillMissingMedicines = () => {
  for (const month in groupedRecords) {
    if (groupedRecords.hasOwnProperty(month)) {
      const monthData = groupedRecords[month];

      // Initialize missing names with 0
      for (const name in monthData) {
        if (!medicineNames.includes(name)) {
          delete monthData[name]; // Remove the name if it's not in the 'names' array
        }
      }

      for (const name of medicineNames) {
        if (!monthData.hasOwnProperty(name)) {
          monthData[name] = 0;
        }
      }
    }
  }
};

const updateData = async () => {
  medicinesData = await getMedicines();
  medicinesData = medicinesData.medicines;
  recordsData = await getRecords();
  recordsData = recordsData.records;
  medicineNames = medicinesData.map((medicine) => medicine.name);
};

const renderChart = (records) => {
  let medicinesArray = Object.keys(records).map((medicineName) => ({
    name: medicineName,
    itemsDeducted: records[medicineName],
  }));
  medicinesArray = sortLikePyramid(medicinesArray);
  const medicines = medicinesArray.map((medicine) => medicine.name);
  const medicinesDeducted = medicinesArray.map(
    (medicine) => medicine.itemsDeducted
  );
  // If there is a current chart, destroy it before creating a new one
  if (currentChart) {
    currentChart.destroy();
  }
  // Create the new chart
  currentChart = new Chart(container, {
    type: "bar",
    data: {
      labels: medicines,
      datasets: [
        {
          label: "# of deducted medicines",
          data: medicinesDeducted,
          borderWidth: 1,
          backgroundColor: "rgb(59 130 246)",
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
      indexAxis: "x",
      maintainAspectRatio: false,
    },
  });
};
const customComparator = (a, b) => {
  // Convert the date strings to JavaScript Date objects
  const dateA = new Date(`01 ${a}`);
  const dateB = new Date(`01 ${b}`);

  // Compare the Date objects
  if (dateA > dateB) return -1; // Sort in descending order
  if (dateA < dateB) return 1;
  return 0;
};

const getAndDisplaySummarization = async () => {
  try {
    await updateData();
    groupRecords();
    fillMissingMedicines();

    const monthsArray = Array.from(monthOptions);

    monthsArray.sort(customComparator);
    monthOptions = new Set(monthsArray);

    for (const month of monthOptions) {
      const option = document.createElement("option");
      option.value = month;
      option.textContent = month;
      option.classList = "text-gray-600";
      selectMonth.appendChild(option);
    }
    renderChart(groupedRecords[selectMonth.value]);
  } catch (error) {
    console.log(error);
  }

  selectMonth.addEventListener("change", () => {
    renderChart(groupedRecords[selectMonth.value]);
  });
};
