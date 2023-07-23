const endPoint = "./backend/route/inventory.php";
const inventoryMessage = document.getElementById("inventoryMessage");
const tableBody = document.getElementById("tableBody");
const tableMessage = document.getElementById("tableMessage");
const nameInput = document.getElementById("name");
const brandInput = document.getElementById("brand");
const unitInput = document.getElementById("unit");
const expirationInput = document.getElementById("expiration");
const boxesCountInput = document.getElementById("boxesCount");
const itemsPerBoxInput = document.getElementById("itemsPerBox");
const itemsCountInput = document.getElementById("itemsCount");

const storageSuggestions = document.getElementById("storageSuggestions");

const populateFormSuggestions = async () => {
  const route = "getFormSuggestions";
  try {
    const { data } = await axios.get(endPoint, { params: { route } });
    const { storages } = data;
    populateDropdownOptions(storageSuggestions, storages, "description");
  } catch (error) {
    console.error(error);
  }
};

const populateDropdownOptions = (selectElement, optionsArray, property) => {
  optionsArray.forEach((option) => {
    const optionElement = document.createElement("option");
    optionElement.value = option[property];
    optionElement.textContent = option[property];
    selectElement.appendChild(optionElement);
  });
};

const createMedicine = async () => {
  const route = "createMedicine";

  const name = nameInput.value;
  const brand = brandInput.value;
  const unit = unitInput.value;
  const expiration = expirationInput.value;
  const boxesCount = boxesCountInput.value;
  const itemsPerBox = itemsPerBoxInput.value;
  const itemsCount = itemsCountInput.value;
  const storage = storageSuggestions.value;

  try {
    const { data } = await axios.post(
      endPoint,
      {
        name,
        brand,
        unit,
        expiration,
        boxesCount,
        itemsPerBox,
        itemsCount,
        storage,
        route,
      },
      {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
      }
    );

    inventoryMessage.innerText = data.message;
    await getAllMedicine();
  } catch (error) {
    console.error(error);
  }
};

const getAllMedicine = async () => {
  const route = "getAllMedicine";

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    if (data.success) {
      const filteredMedicines = data.medicines.map(
        ({
          name,
          brand,
          unit,
          expiration,
          boxesC,
          itemsPerB,
          itemsC,
          itemsD,
        }) => ({
          name,
          brand,
          unit,
          expiration,
          boxesC,
          itemsPerB,
          itemsC,
          itemsD,
        })
      );

      // Clear previous table rows
      tableBody.innerHTML = "";

      filteredMedicines.forEach((item) => {
        const row = createTableRow(item);
        tableBody.appendChild(row);
      });

      tableMessage.innerText = data.message;
    } else {
      tableMessage.innerText = data.message;
    }
  } catch (error) {
    console.error(error);
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

populateFormSuggestions();
