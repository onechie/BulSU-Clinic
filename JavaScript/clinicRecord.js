const facultyRecord = document.getElementById("facultyRecord");
const patientHistory = document.getElementById("patientHistory");
const recordAttachments = document.getElementById("recordAttachments");

const endPoint = "./backend/route/clinicRecord.php";

const getAllRecord = () => {
  const route = "getAllRecords";

  const tableBody = document.getElementById("tableBody");
  const clinicRecordMessage = document.getElementById("clinicRecordMessage");

  axios
    .get(endPoint, {
      params: {
        route,
      },
    })
    .then(({ data }) => {
      if (data.success) {
        while (tableBody.firstChild) {
          tableBody.removeChild(tableBody.firstChild);
        }
        const records = data.records;
        // Loop through each object in the records array
        records.forEach((record) => {
          // Create a new row (tr element) for each object
          const row = document.createElement("tr");

          // Loop through each key-value pair in the object
          for (const key in record) {
            if (record.hasOwnProperty(key)) {
              // Create a new cell (td element) for each value in the object
              const cell = document.createElement("td");
              cell.textContent = record[key];
              row.appendChild(cell);
            }
          }

          // Create a new cell (td element) for the "View History" button
          const viewHistoryCell = document.createElement("td");

          // Create the "View History" button
          const viewHistoryButton = document.createElement("button");
          viewHistoryButton.textContent = "View History";

          // Add a click event listener to the button
          viewHistoryButton.addEventListener("click", () => {
            // Handle the click event, e.g., show the history for the specific record
            // You can implement this functionality based on your requirements
            // For example, you might want to redirect the user to a new page showing the history for the record
            console.log("View History clicked for record name: " + record.name);

            facultyRecord.setAttribute("hidden", true);
            patientHistory.removeAttribute("hidden");

            getAllRecordByName(record.name);
          });

          // Append the button to the cell and the cell to the row
          viewHistoryCell.appendChild(viewHistoryButton);
          row.appendChild(viewHistoryCell);

          // Append the row to the table body
          tableBody.appendChild(row);
        });
        clinicRecordMessage.innerText = data.message;
      } else {
        clinicRecordMessage.innerText = data.message;
      }
    })
    .catch((error) => {
      console.log(error);
    });
};

const getAllRecordByName = (name) => {
  const route = "getRecordsByName";

  const patientName = document.getElementById("patientName");
  const tableBodyByPatient = document.getElementById("tableBodyByPatient");
  const recordMessageByPatient = document.getElementById(
    "recordMessageByPatient"
  );

  axios
    .get(endPoint, {
      params: {
        name,
        route,
      },
    })
    .then(({ data }) => {
      if (data.success) {
        while (tableBodyByPatient.firstChild) {
          tableBodyByPatient.removeChild(tableBodyByPatient.firstChild);
        }
        patientName.innerText = name;
        const records = data.records;
        // Loop through each object in the records array
        records.forEach((record) => {
          // Create a new row (tr element) for each object
          const row = document.createElement("tr");

          // Loop through each key-value pair in the object
          for (const key in record) {
            if (record.hasOwnProperty(key)) {
              // Create a new cell (td element) for each value in the object
              const cell = document.createElement("td");
              cell.textContent = record[key];
              row.appendChild(cell);
            }
          }

          // Create a new cell (td element) for the "View History" button
          const viewHistoryCell = document.createElement("td");

          // Create the "View History" button
          const viewHistoryButton = document.createElement("button");
          viewHistoryButton.textContent = "See Attachments";

          // Add a click event listener to the button
          viewHistoryButton.addEventListener("click", () => {
            // Handle the click event, e.g., show the history for the specific record
            // You can implement this functionality based on your requirements
            // For example, you might want to redirect the user to a new page showing the history for the record
            console.log("See Attachments clicked for record ID: " + record.id);
            patientHistory.setAttribute("hidden", true);
            recordAttachments.removeAttribute("hidden");
            getRecordById(record.id);
          });

          // Append the button to the cell and the cell to the row
          viewHistoryCell.appendChild(viewHistoryButton);
          row.appendChild(viewHistoryCell);

          // Append the row to the table body
          tableBodyByPatient.appendChild(row);
        });
        recordMessageByPatient.innerText = data.message;
      } else {
        recordMessageByPatient.innerText = data.message;
      }
    })
    .catch((error) => {
      console.log(error);
    });
};

const getRecordById = (id) => {
  const route = "getRecordById";
  const pfName = document.getElementById("pfName");
  const pfComplaint = document.getElementById("pfComplaint");
  const pfMedication = document.getElementById("pfMedication");
  const pfTreatment = document.getElementById("pfTreatment");
  const pfLaboratory = document.getElementById("pfLaboratory");
  const pfBloodPressure = document.getElementById("pfBloodPressure");
  const pfPulse = document.getElementById("pfPulse");
  const pfWeight = document.getElementById("pfWeight");
  const pfTemperature = document.getElementById("pfTemperature");
  const pfRespiration = document.getElementById("pfRespiration");
  const pfSaturation = document.getElementById("pfSaturation");
  const messageByPf = document.getElementById("messageByPf");
  axios
    .get(endPoint, {
      params: {
        id,
        route,
      },
    })
    .then(({ data }) => {
      if (data.success) {
        const {
          name,
          complaint,
          medication,
          treatment,
          laboratory,
          bloodPressure,
          pulse,
          weight,
          temperature,
          respiration,
          oximetry,
        } = data.record;

        pfName.innerText = name;
        pfComplaint.innerText = complaint;
        pfMedication.innerText = medication;
        pfTreatment.innerText = treatment;
        pfLaboratory.innerText = laboratory;
        pfBloodPressure.innerText = bloodPressure;
        pfPulse.innerText = pulse;
        pfWeight.innerText = weight;
        pfTemperature.innerText = temperature;
        pfRespiration.innerText = respiration;
        pfSaturation.innerText = oximetry;

        messageByPf.innerText = messageByPf.innerText = data.message;
      } else {
        messageByPf.innerText = data.message;
      }
    })
    .catch((error) => {
      console.log(error);
    });
};
