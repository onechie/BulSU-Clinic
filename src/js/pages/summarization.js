import { getMedicines } from "../api/medicines.js";

// Define a variable to store the current chart instance
let currentChart = null;

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

const getAndDisplaySummarization = async () => {
  const container = document.getElementById("barChart");

  try {
    let medicinesResponse = await getMedicines();
    let medicinesData = medicinesResponse.medicines;
    medicinesData = sortLikePyramid(medicinesData);

    const medicines = medicinesData.map((medicine) => medicine.name);
    const medicinesDeducted = medicinesData.map(
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
  } catch (error) {
    console.log(error);
  }
};
