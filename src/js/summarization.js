// Define a variable to store the current chart instance
let currentChart = null;
const endPoint = "../backend/api/summarization";

document.addEventListener("DOMContentLoaded", () => {
  getAndDisplaySummarization();
});

const getAndDisplaySummarization = async () => {
  const route = "getMedicines";
  const container = document.getElementById("barChart");

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    const medicinesData = data.medicines;
    const compareByItemsD = (a, b) => b.itemsD - a.itemsD;
    medicinesData.sort(compareByItemsD);

    const medicines = medicinesData.map((medicine) => medicine.name);
    const medicinesDeducted = medicinesData.map((medicine) => medicine.itemsD);

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
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
        indexAxis: "y",
      },
    });
  } catch (error) {
    console.log(error);
  }
};
