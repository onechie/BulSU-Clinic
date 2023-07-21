const endPoint = "./backend/route/clinicRecord.php";
const facultyRecordDiv = document.getElementById("facultyRecord");
const patientHistoryDiv = document.getElementById("patientHistory");
const recordAttachmentsDiv = document.getElementById("recordAttachments");
const addAttachmentDiv = document.getElementById("addAttachment");

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
          facultyRecordDiv.setAttribute("hidden", true);
          patientHistoryDiv.removeAttribute("hidden");
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
          patientHistoryDiv.setAttribute("hidden", true);
          recordAttachmentsDiv.removeAttribute("hidden");
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
    const recordId = document.getElementById("recordId");

    const attachmentsContainer = document.getElementById(
      "attachmentsContainer"
    );

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
    // Use destructuring to extract the files from the file input
    const { files } = document.getElementById("attachments");

    // Use FormData constructor to create the formData object
    const formData = new FormData(addAttachmentDiv);
    formData.append("route", route);

    // Remove the "attachments" key if no files are selected
    if (files.length === 0) {
      return;
    }
    const { data } = await axios.post(endPoint, formData);

    // Use template literals for setting the inner text
    addAttachmentMessage.innerText = data.message;
  } catch (error) {
    console.error(error);
  }
};
