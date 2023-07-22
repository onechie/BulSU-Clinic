const getAllMedicine = async () => {
  const route = "getAllMedicine";
  const endPoint = "./backend/route/dashboard.php";

  const tableBody = document.getElementById("tableBody");
  const tableMessage = document.getElementById("tableMessage");

  try {
    const { data } = await axios.get(endPoint, { params: { route } });

    if (data.success) {
      const filteredMedicines = data.medicines.map(({ brand, itemsC, expiration }) => ({
        brand,
        itemsC,
        expiration,
      }));

      filteredMedicines.sort((a, b) => new Date(a.expiration) - new Date(b.expiration));

      tableBody.textContent = ""; // Clear the table before adding new rows

      filteredMedicines.forEach((item) => {
        const row = document.createElement("tr");

        for (const [key, value] of Object.entries(item)) {
          const cell = document.createElement("td");
          cell.textContent = value;
          
          if (key === "expiration") {
            const daysDiff = calculateDaysDifference(value);
            if (daysDiff <= 1) {
              cell.classList.add("text-danger");
            } else if (daysDiff <= 30) {
              cell.classList.add("text-primary");
            }
          }

          row.appendChild(cell);
        }

        tableBody.appendChild(row);
      });
    } else {
      tableMessage.textContent = data.message;
    }
  } catch (error) {
    console.error(error);
  }
};

// Helper function to calculate the difference in days between two dates
const calculateDaysDifference = (dateString) => {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  const expiration = new Date(dateString);

  const diffTime = expiration.getTime() - today.getTime();
  return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
};

getAllMedicine();
