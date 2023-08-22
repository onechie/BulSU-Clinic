"use strict";
// Define a variable to store the current chart instance
let currentChart = null;

document.addEventListener("DOMContentLoaded", () => {
  getAndDisplaySummarization();
});

const getAndDisplaySummarization = async () => {
  const endPoint = "./backend/api/medicines";
  const container = document.getElementById("barChart");

  try {
    // const { data } = await axios.get(endPoint, {
    //   params: {
    //     route,
    //   },
    // });

    //DUMMY DATA
    const data = {
      medicines: [
        {
          name: "Paracetamol",
          itemsDeducted: 100,
        },
        {
          name: "Ibuprofen",
          itemsDeducted: 90,
        },
        {
          name: "Aspirin",
          itemsDeducted: 80,
        },
        {
          name: "Cetirizine",
          itemsDeducted: 70,
        },
        {
          name: "Loratadine",
          itemsDeducted: 60,
        },
        {
          name: "Omeprazole",
          itemsDeducted: 50,
        },
        {
          name: "Metformin",
          itemsDeducted: 40,
        },
        {
          name: "Simvastatin",
          itemsDeducted: 30,
        },
        {
          name: "Amlodipine",
          itemsDeducted: 20,
        },
        {
          name: "Atorvastatin",
          itemsDeducted: 10,
        },
      ],
    }

    const medicinesData = data.medicines;
    const compareByItemsD = (a, b) => b.itemsDeducted - a.itemsDeducted;
    medicinesData.sort(compareByItemsD);

    const medicines = medicinesData.map((medicine) => medicine.name);
    const medicinesDeducted = medicinesData.map((medicine) => medicine.itemsDeducted);

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
        indexAxis: "y",
      },
    });
  } catch (error) {
    console.log(error);
  }
};
