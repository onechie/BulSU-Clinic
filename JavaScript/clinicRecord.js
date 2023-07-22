const endPoint = "./backend/route/clinicRecord.php";
const facultyRecordDiv = document.getElementById("facultyRecord");
const patientHistoryDiv = document.getElementById("patientHistory");
const recordAttachmentsDiv = document.getElementById("recordAttachments");
const addAttachmentDiv = document.getElementById("addAttachment");

const tableBody = document.getElementById("tableBody");
const clinicRecordMessage = document.getElementById("clinicRecordMessage");
const patientName = document.getElementById("patientName");
const tableBodyByPatient = document.getElementById("tableBodyByPatient");
const recordMessageByPatient = document.getElementById("recordMessageByPatient");
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
const recordId = document.getElementById("recordId");
const attachmentsContainer = document.getElementById("attachmentsContainer");

const getAllRecord = async () => {
  try {
    const route = "getAllRecords";

    const { data } = await axios.get(endPoint, { params: { route } });

    if (data.success) {
      const filteredRecords = data.records.map(({ name, complaint, date, medication }) => ({
        name,
        complaint,
        date,
        medication,
      }));

      tableBody.innerHTML = "";

      filteredRecords.forEach((record) => {
        const row = createTableRow(record);
        const viewHistoryButton = createButton("View History");

        viewHistoryButton.addEventListener("click", () => {
          facultyRecordDiv.setAttribute("hidden", true);
          patientHistoryDiv.removeAttribute("hidden");
          getAllRecordByName(record.name);
        });

        addCellToRow(row, viewHistoryButton);
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

    const { data } = await axios.get(endPoint, { params: { name, route } });

    if (data.success) {
      tableBodyByPatient.innerHTML = "";
      patientName.innerText = name;

      const filteredRecords = data.records.map(({ id, date, complaint, medication }) => ({
        id,
        date,
        complaint,
        medication,
      }));

      filteredRecords.forEach((record) => {
        const row = createTableRow(record);
        const viewAttachmentsButton = createButton("See Attachments");

        viewAttachmentsButton.addEventListener("click", () => {
          patientHistoryDiv.setAttribute("hidden", true);
          recordAttachmentsDiv.removeAttribute("hidden");
          getRecordById(record.id);
        });

        addCellToRow(row, viewAttachmentsButton);
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

      recordId.value = id;

      if (data.attachments) {
        attachmentsContainer.innerHTML = "";
        data.attachments.forEach((attachment) => {
          const fileName = attachment.attachment_name;
          const underScore = fileName.indexOf("_");
          const finalFileName = fileName.substring(underScore + 1);

          const paragraph = document.createElement("p");
          const link = document.createElement("a");
          link.href = attachment.attachment_url;
          link.target = "_blank";
          link.textContent = finalFileName;
          paragraph.appendChild(link);
          attachmentsContainer.appendChild(paragraph);
        });
      }

      messageByPf.innerText = data.message;
    } else {
      messageByPf.innerText = data.message;
    }
  } catch (error) {
    console.error(error);
  }
};

const newAttachment = () => {
  recordAttachmentsDiv.setAttribute("hidden", true);
  addAttachmentDiv.removeAttribute("hidden");
};

const addAttachment = async (event) => {
  event.preventDefault();
  const addAttachmentMessage = document.getElementById("addAttachmentMessage");
  const route = "addAttachment";

  try {
    const { files } = document.getElementById("attachments");
    const formData = new FormData(addAttachmentDiv);
    formData.append("route", route);

    if (files.length === 0) {
      return;
    }

    const { data } = await axios.post(endPoint, formData);
    addAttachmentMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};

// Helper function to create a table row with cells from a record object
const createTableRow = (record) => {
  const row = document.createElement("tr");
  for (const key in record) {
    if (record.hasOwnProperty(key)) {
      const cell = document.createElement("td");
      cell.textContent = record[key];
      row.appendChild(cell);
    }
  }
  return row;
};

// Helper function to create a button element with provided text content
const createButton = (text) => {
  const button = document.createElement("button");
  button.textContent = text;
  return button;
};

// Helper function to add a cell to a table row
const addCellToRow = (row, cell) => {
  const viewHistoryCell = document.createElement("td");
  viewHistoryCell.appendChild(cell);
  row.appendChild(viewHistoryCell);
};

// Call the initial function
getAllRecord();
