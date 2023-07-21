const endPoint = "./backend/route/clinicRecord.php";

const getAllRecord = async () => {
  try {
    const route = "getAllRecords";
    const tableBody = document.getElementById("tableBody");
    const clinicRecordMessage = document.getElementById("clinicRecordMessage");

    const { data } = await axios.get(endPoint, { params: { route } });

    if (data.success) {
      tableBody.innerHTML = "";
      const records = data.records;

      records.forEach((record) => {
        const row = document.createElement("tr");

        for (const key in record) {
          if (record.hasOwnProperty(key)) {
            const cell = document.createElement("td");
            cell.textContent = record[key];
            row.appendChild(cell);
          }
        }

        const viewHistoryCell = document.createElement("td");
        const viewHistoryButton = document.createElement("button");
        viewHistoryButton.textContent = "View History";

        viewHistoryButton.addEventListener("click", () => {
          console.log("View History clicked for record name: " + record.name);
          facultyRecord.setAttribute("hidden", true);
          patientHistory.removeAttribute("hidden");
          getAllRecordByName(record.name);
        });

        viewHistoryCell.appendChild(viewHistoryButton);
        row.appendChild(viewHistoryCell);

        tableBody.appendChild(row);
      });
      clinicRecordMessage.innerText = data.message;
    } else {
      clinicRecordMessage.innerText = data.message;
    }
  } catch (error) {
    console.error(error);
  }
};

const getAllRecordByName = async (name) => {
  try {
    const route = "getRecordsByName";
    const patientName = document.getElementById("patientName");
    const tableBodyByPatient = document.getElementById("tableBodyByPatient");
    const recordMessageByPatient = document.getElementById(
      "recordMessageByPatient"
    );

    const { data } = await axios.get(endPoint, { params: { name, route } });

    if (data.success) {
      tableBodyByPatient.innerHTML = "";
      patientName.innerText = name;
      const records = data.records;

      records.forEach((record) => {
        const row = document.createElement("tr");

        for (const key in record) {
          if (record.hasOwnProperty(key)) {
            const cell = document.createElement("td");
            cell.textContent = record[key];
            row.appendChild(cell);
          }
        }

        const viewHistoryCell = document.createElement("td");
        const viewHistoryButton = document.createElement("button");
        viewHistoryButton.textContent = "See Attachments";

        viewHistoryButton.addEventListener("click", () => {
          console.log("See Attachments clicked for record ID: " + record.id);
          patientHistory.setAttribute("hidden", true);
          recordAttachments.removeAttribute("hidden");
          getRecordById(record.id);
        });

        viewHistoryCell.appendChild(viewHistoryButton);
        row.appendChild(viewHistoryCell);

        tableBodyByPatient.appendChild(row);
      });
      recordMessageByPatient.innerText = data.message;
    } else {
      recordMessageByPatient.innerText = data.message;
    }
  } catch (error) {
    console.error(error);
  }
};

const getRecordById = async (id) => {
  try {
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

    const { data } = await axios.get(endPoint, { params: { id, route } });

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

      messageByPf.innerText = data.message;
    } else {
      messageByPf.innerText = data.message;
    }
  } catch (error) {
    console.error(error);
  }
};