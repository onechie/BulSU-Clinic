const endPoint = "./backend/route/settings.php";
const complaintsMessage = document.getElementById("complaintsMessage");

const getComplaints = async () => {
  const complaintsContainer = document.getElementById("complaintsContainer");
  const complaintsTable = document.getElementById("complaintsTable");

  const route = "getComplaints";

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    const filteredComplaints = data.complaints.map(({ id, description }) => ({
      id,
      description,
    }));
    complaintsTable.innerHTML = "";

    filteredComplaints.forEach((item) => {
      const row = createTableRow(item);
      complaintsTable.appendChild(row);

      const viewHistoryButton = createButton("Delete");

      viewHistoryButton.addEventListener("click", async () => {
        const route = "deleteComplaint";
        const { data } = await axios.post(
          endPoint,
          {
            id: item.id,
            route,
          },
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded",
            },
          }
        );
        await getComplaints();
        complaintsMessage.innerText = data.message;
      });

      addCellToRow(row, viewHistoryButton);
    });

    complaintsContainer.removeAttribute("hidden");
    complaintsMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};

const addComplaint = async () => {
  const newComplaintValue = document.getElementById("newComplaintValue").value;
  const route = "addComplaint";
  try {
    const { data } = await axios.post(
      endPoint,
      {
        route,
        description: newComplaintValue,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );
    await getComplaints();
    complaintsMessage.innerText = data.message;
  } catch (error) {
    console.log(error);
  }
};

// Helper function to create a table row with cells from a medicine object
const createTableRow = (medicine) => {
  const row = document.createElement("tr");
  for (const key in medicine) {
    if (medicine.hasOwnProperty(key)) {
      const cell = document.createElement("td");
      cell.textContent = medicine[key];
      row.appendChild(cell);
    }
  }
  return row;
};
// Helper function to create a button element with provided text content
const createButton = (text) => {
  const button = document.createElement("button");
  button.textContent = text;
  button.classList.add("button-danger");
  return button;
};

// Helper function to add a cell to a table row
const addCellToRow = (row, cell) => {
  const viewHistoryCell = document.createElement("td");
  viewHistoryCell.appendChild(cell);
  row.appendChild(viewHistoryCell);
};
