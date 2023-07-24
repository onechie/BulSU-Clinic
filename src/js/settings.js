const endPoint = "../backend/api/settings";

const complaintsMessage = document.getElementById("complaintsMessage");
const treatmentsMessage = document.getElementById("treatmentsMessage");
const laboratoriesMessage = document.getElementById("laboratoriesMessage");
const storagesMessage = document.getElementById("storagesMessage");

//COMPLAINTS
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

      const deleteButton = createButton("Delete");

      deleteButton.addEventListener("click", async () => {
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

      addCellToRow(row, deleteButton);
    });

    complaintsContainer.removeAttribute("hidden");
    complaintsMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};

//TREATMENTS
const getTreatments = async () => {
  const treatmentsContainer = document.getElementById("treatmentsContainer");
  const treatmentsTable = document.getElementById("treatmentsTable");

  const route = "getTreatments";

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    const filteredTreatments = data.treatments.map(({ id, description }) => ({
      id,
      description,
    }));
    treatmentsTable.innerHTML = "";

    filteredTreatments.forEach((item) => {
      const row = createTableRow(item);
      treatmentsTable.appendChild(row);

      const deleteButton = createButton("Delete");

      deleteButton.addEventListener("click", async () => {
        const route = "deleteTreatment";
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
        await getTreatments();
        treatmentsMessage.innerText = data.message;
      });

      addCellToRow(row, deleteButton);
    });

    treatmentsContainer.removeAttribute("hidden");
    treatmentsMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};

//LABORATORIES
const getLaboratories = async () => {
  const laboratoriesContainer = document.getElementById(
    "laboratoriesContainer"
  );
  const laboratoriesTable = document.getElementById("laboratoriesTable");

  const route = "getLaboratories";

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    const filteredLaboratories = data.laboratories.map(
      ({ id, description }) => ({
        id,
        description,
      })
    );
    laboratoriesTable.innerHTML = "";

    filteredLaboratories.forEach((item) => {
      const row = createTableRow(item);
      laboratoriesTable.appendChild(row);

      const deleteButton = createButton("Delete");

      deleteButton.addEventListener("click", async () => {
        const route = "deleteLaboratory";
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
        await getLaboratories();
        laboratoriesMessage.innerText = data.message;
      });

      addCellToRow(row, deleteButton);
    });

    laboratoriesContainer.removeAttribute("hidden");
    laboratoriesMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};

//STORAGES
const getStorages = async () => {
  const storagesContainer = document.getElementById("storagesContainer");
  const storagesTable = document.getElementById("storagesTable");

  const route = "getStorages";

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    const filteredStorages = data.storages.map(({ id, description }) => ({
      id,
      description,
    }));
    storagesTable.innerHTML = "";

    filteredStorages.forEach((item) => {
      const row = createTableRow(item);
      storagesTable.appendChild(row);

      const deleteButton = createButton("Delete");

      deleteButton.addEventListener("click", async () => {
        const route = "deleteStorage";
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
        await getStorages();
        storagesMessage.innerText = data.message;
      });

      addCellToRow(row, deleteButton);
    });

    storagesContainer.removeAttribute("hidden");
    storagesMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};

const addItem = async (route, inputId, fetchDataFunction, messageId) => {
  const newDescriptionValue = document.getElementById(inputId).value;
  try {
    const { data } = await axios.post(
      endPoint,
      {
        route,
        description: newDescriptionValue,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );
    await fetchDataFunction();
    messageId.innerText = data.message;
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

const addComplaint = async () => {
  await addItem(
    "addComplaint",
    "newComplaintValue",
    getComplaints,
    complaintsMessage
  );
};
const addTreatment = async () => {
  await addItem(
    "addTreatment",
    "newTreatmentValue",
    getTreatments,
    treatmentsMessage
  );
};
const addLaboratory = async () => {
  await addItem(
    "addLaboratory",
    "newLaboratoryValue",
    getLaboratories,
    laboratoriesMessage
  );
};
const addStorage = async () => {
  await addItem("addStorage", "newStorageValue", getStorages, storagesMessage);
};

getComplaints();
getTreatments();
getLaboratories();
getStorages();
