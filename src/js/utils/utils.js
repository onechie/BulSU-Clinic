export const createTableRows = (data, table, customTDFunction) => {
  const tableBody = table.querySelector("tbody");
  tableBody.innerHTML = "";

  if (!data) return;

  data.forEach((item) => {
    const tr = document.createElement("tr");
    tr.classList.add("border-b", "border-gray-200");

    for (const key in item) {
      const td = document.createElement("td");
      td.innerText = item[key];

      td.classList.add("py-3");

      if (key === Object.keys(item)[0]) {
        td.classList.add("font-medium", "text-gray-600");
      } else {
        td.classList.add("text-gray-500");
      }

      if (customTDFunction && typeof customTDFunction === "function") {
        customTDFunction(key, item[key], td);
      }

      tr.appendChild(td);
    }
    tableBody.appendChild(tr);
  });
};

export const createOptions = (data, property) => {
  return data
    .sort((a, b) => a[property].localeCompare(b[property]))
    .map((item) => {
      const option = document.createElement("option");
      option.value = item[property];
      return option;
    });
};
