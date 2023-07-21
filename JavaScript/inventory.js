const endPoint = "./backend/route/inventory.php";

const createMedicine = async () => {
  const route = "createMedicine";

  const name = document.getElementById("name").value;
  const brand = document.getElementById("brand").value;
  const unit = document.getElementById("unit").value;
  const expiration = document.getElementById("expiration").value;
  const boxesCount = document.getElementById("boxesCount").value;
  const itemsPerBox = document.getElementById("itemsPerBox").value;
  const itemsCount = document.getElementById("itemsCount").value;
  const inventoryMessage = document.getElementById("inventoryMessage");

  try {
    const { data } = await axios.post(endPoint, {
      name,
      brand,
      unit,
      expiration,
      boxesCount,
      itemsPerBox,
      itemsCount,
      route,
    }, {
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    });

    inventoryMessage.innerText = data.message;
    await getAllMedicine();
  } catch (error) {
    console.error(error);
  }
};

const getAllMedicine = async () => {
  const route = "getAllMedicine";

  const tableBody = document.getElementById("tableBody");
  const tableMessage = document.getElementById("tableMessage");

  try {
    const { data } = await axios.get(endPoint, {
      params: {
        route,
      },
    });

    if (data.success) {
      tableBody.innerHTML = "";
      const medicines = data.medicines;

      medicines.forEach((item) => {
        const row = document.createElement("tr");

        for (const key in item) {
          if (item.hasOwnProperty(key)) {
            const cell = document.createElement("td");
            cell.textContent = item[key];
            row.appendChild(cell);
          }
        }

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