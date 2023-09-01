import { getRecords } from "../api/records.js";
import {
  getAttachments,
  addAttachments,
  deleteAttachments,
} from "../api/attachments.js";
import { createTableRows } from "../utils/utils.js";

const PAGE_SIZE = 10;

const searchInput = document.getElementById("searchInput");
const clinicRecordTable = document.getElementById("clinicRecordTable");
const pageCountElement = document.getElementById("pageCount");
const pageNumberInput = document.getElementById("pageNumber");

const viewHistoryModal = document.getElementById("viewHistoryModal");
const viewHistoryName = document.getElementById("viewHistoryName");
const viewHistoryTable = document.getElementById("viewHistoryTable");
const viewHistoryClose = document.getElementById("viewHistoryClose");

const seeAttachmentsModal = document.getElementById("seeAttachmentsModal");
const seeAttachmentsName = document.getElementById("seeAttachmentsName");
const seeAttachmentsComplaint = document.getElementById(
  "seeAttachmentsComplaint"
);
const seeAttachmentsMedication = document.getElementById(
  "seeAttachmentsMedication"
);
const seeAttachmentsTreatment = document.getElementById(
  "seeAttachmentsTreatment"
);
const seeAttachmentsLaboratory = document.getElementById(
  "seeAttachmentsLaboratory"
);
const seeAttachmentsBloodPressure = document.getElementById(
  "seeAttachmentsBloodPressure"
);
const seeAttachmentsPulse = document.getElementById("seeAttachmentsPulse");
const seeAttachmentsWeight = document.getElementById("seeAttachmentsWeight");
const seeAttachmentsTemperature = document.getElementById(
  "seeAttachmentsTemperature"
);
const seeAttachmentsRespiration = document.getElementById(
  "seeAttachmentsRespiration"
);
const seeAttachmentsOxygenSaturation = document.getElementById(
  "seeAttachmentsOxygenSaturation"
);
const seeAttachmentsFiles = document.getElementById("seeAttachmentsFiles");
const seeAttachmentsClose = document.getElementById("seeAttachmentsClose");
const seeAttachmentsAdd = document.getElementById("seeAttachmentsAdd");

const addAttachmentsModal = document.getElementById("addAttachmentsModal");
const addAttachmentsForm = document.getElementById("addAttachmentsForm");
const addAttachmentsList = document.getElementById("addAttachmentsList");
const addAttachmentsUpload = document.getElementById("addAttachmentsUpload");
const addAttachmentsMessage = document.getElementById("addAttachmentsMessage");
const addAttachmentsCancel = document.getElementById("addAttachmentsCancel");

let recordsData = [];
let recordsTableData = [];
let pages = [];
let currentPage = 1;

const customTDFunction = (key, value, td) => {
  if (key === "viewHistory") {
    td.innerText = "";
    td.classList.remove("text-gray-500", "pe-3");
    td.classList.add("text-end");
    const button = document.createElement("button");
    button.className = "underline text-blue-500";
    button.innerText = "view history";
    button.addEventListener("click", () => {
      handleViewHistoryClick(value);
    });
    td.appendChild(button);
  } else if (key === "complaint") {
    td.classList.add("w-1/5");
  }
};

const setupEventListeners = () => {
  document
    .getElementById("searchButton")
    .addEventListener("click", handleSearch);
  document
    .getElementById("pageNext")
    .addEventListener("click", () => handlePageChange(1));
  document
    .getElementById("pagePrev")
    .addEventListener("click", () => handlePageChange(-1));
  pageNumberInput.addEventListener("change", handlePageInputChange);
  viewHistoryClose.addEventListener("click", handleViewHistoryClose);
  seeAttachmentsClose.addEventListener("click", () => {
    seeAttachmentsModal.classList.add("hidden");
  });
  seeAttachmentsAdd.addEventListener("click", HandleSeeAttachmentsAdd);
  addAttachmentsUpload.addEventListener("change", handleAddAttachmentsUpload);
  addAttachmentsCancel.addEventListener("click", handleAddAttachmentsCancel);
  addAttachmentsForm.addEventListener("submit", handleAddAttachmentsSubmit);
};

const renderPage = (pageNumber) => {
  pageNumber = Math.min(Math.max(1, pageNumber), pages.length);
  createTableRows(pages[pageNumber - 1], clinicRecordTable, customTDFunction);
  currentPage = pageNumber;
  pageNumberInput.value = currentPage;
};

const handlePageChange = (change) => {
  renderPage(currentPage + change);
};
const handlePageInputChange = () => {
  renderPage(parseInt(pageNumberInput.value));
};
const handleSearch = () => {
  const searchValue = searchInput.value.toLowerCase();
  const searchOutput = recordsTableData.filter((medicine) =>
    Object.values(medicine).some((value) =>
      value.toString().toLowerCase().includes(searchValue)
    )
  );

  pageCountElement.innerText = Math.ceil(searchOutput.length / PAGE_SIZE);
  pages = Array.from(
    { length: Math.ceil(searchOutput.length / PAGE_SIZE) },
    (_, i) => searchOutput.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
  );

  renderPage(1);
};

const handleViewHistoryClick = (name) => {
  viewHistoryModal.classList.remove("hidden");
  const records = recordsData.filter((record) => record.name === name);
  const newRecords = records.map((record) => ({
    date: record.date,
    complaint: record.complaint,
    medication: record.medication,
    id: record.id,
  }));

  viewHistoryName.innerText = name;
  const thisTDFunction = (key, value, td) => {
    if (key === "id") {
      td.innerText = "";
      td.classList.remove("text-gray-500", "pe-3");
      td.classList.add("text-end");
      const button = document.createElement("button");
      button.className = "underline text-blue-500";
      button.innerText = "see attachments";
      button.addEventListener("click", () => {
        handleSeeAttachments(value);
      });
      td.appendChild(button);
    } else if (key === "complaint") {
      td.classList.add("w-1/3");
    }
  };
  createTableRows(newRecords, viewHistoryTable, thisTDFunction);
};

const handleSeeAttachments = async (id) => {
  handleViewHistoryClose();
  const record = recordsData.find((record) => record.id === id);
  seeAttachmentsModal.classList.remove("hidden");
  seeAttachmentsName.innerText = record.name;
  seeAttachmentsComplaint.innerText = record.complaint;
  seeAttachmentsMedication.innerText = record.medication;
  seeAttachmentsTreatment.innerText = record.treatment || "none";
  seeAttachmentsLaboratory.innerText = record.laboratory || "none";
  seeAttachmentsBloodPressure.innerText = record.bloodPressure || "none";
  seeAttachmentsPulse.innerText = record.pulse || "none";
  seeAttachmentsWeight.innerText = record.weight || "none";
  seeAttachmentsTemperature.innerText = record.temperature || "none";
  seeAttachmentsRespiration.innerText = record.respiration || "none";
  seeAttachmentsOxygenSaturation.innerText = record.oximetry || "none";

  addAttachmentsForm.recordId.value = id;
  //TODO get files
  try {
    const attachmentsResponse = await getAttachments(null, id);
    const attachments = attachmentsResponse.attachment;
    seeAttachmentsFiles.innerHTML = "";

    for (let i = 0; i < attachments.length; i++) {
      const attachment = attachments[i];
      const attachmentContainer = document.createElement("div");
      attachmentContainer.className =
        "flex justify-between px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:bg-gray-200 gap-5";

      const attachmentFile = document.createElement("a");
      attachmentFile.className = "hover:underline truncate";
      attachmentFile.innerText = attachment.name;
      attachmentFile.href = attachment.url;
      attachmentFile.target = "_blank";
      attachmentContainer.appendChild(attachmentFile);

      const attachmentDelete = document.createElement("button");
      attachmentDelete.className =
        "text-gray-400 hover:text-gray-500 justify-self-end";
      attachmentDelete.innerHTML =
        "<svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-6 h-6'><path stroke-linecap='round' stroke-linejoin='round' d='M6 18L18 6M6 6l12 12' /></svg>";
      attachmentDelete.addEventListener("click", async () => {
        try {
          await deleteAttachments(attachment.id, null);
          await handleSeeAttachments(id);
        } catch (error) {
          console.error(error);
        }
      });
      attachmentContainer.appendChild(attachmentDelete);
      seeAttachmentsFiles.appendChild(attachmentContainer);
    }
  } catch (error) {
    seeAttachmentsFiles.innerHTML = "";
    const attachmentItem = document.createElement("div");
    attachmentItem.className =
      "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
    attachmentItem.innerText = "No attachments";
    seeAttachmentsFiles.appendChild(attachmentItem);
  }
};
const HandleSeeAttachmentsAdd = () => {
  addAttachmentsModal.classList.remove("hidden");
};
const handleAddAttachmentsUpload = () => {
  const { files } = addAttachmentsUpload;
  addAttachmentsList.innerHTML = "";
  for (let i = 0; i < files.length; i++) {
    const attachment = files[i];
    const attachmentItem = document.createElement("div");
    attachmentItem.className =
      "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
    attachmentItem.innerText = attachment.name;
    addAttachmentsList.appendChild(attachmentItem);
  }
  if (files.length <= 0) {
    const attachmentItem = document.createElement("div");
    attachmentItem.className =
      "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
    attachmentItem.innerText = "No attachments";
    addAttachmentsList.appendChild(attachmentItem);
  }
};
const handleAddAttachmentsCancel = () => {
  addAttachmentsModal.classList.add("hidden");
  addAttachmentsForm.reset();
  handleAddAttachmentsMessage("", "text-red-500");
  addAttachmentsList.innerHTML = "";

  const attachmentItem = document.createElement("div");
  attachmentItem.className =
    "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
  attachmentItem.innerText = "No attachments";
  addAttachmentsList.appendChild(attachmentItem);
};
const handleAddAttachmentsSubmit = async (event) => {
  event.preventDefault();
  const attachmentsData = new FormData(addAttachmentsForm);
  try {
    const data = await addAttachments(attachmentsData);
    handleAddAttachmentsMessage(data.message, "text-green-500");
    addAttachmentsList.innerHTML = "";
    addAttachmentsForm.reset();
    const attachmentItem = document.createElement("div");
    attachmentItem.className =
      "px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200";
    attachmentItem.innerText = "No attachments";
    addAttachmentsList.appendChild(attachmentItem);
    await handleSeeAttachments(parseInt(attachmentsData.get("recordId")));
  } catch (error) {
    handleAddAttachmentsMessage(error.message, "text-red-500");
  }
};
const handleAddAttachmentsMessage = (message, colorClass) => {
  addAttachmentsMessage.innerText = message;
  addAttachmentsMessage.classList.remove("text-red-500", "text-green-500");
  addAttachmentsMessage.classList.add(colorClass);
};
const handleViewHistoryClose = () => {
  viewHistoryModal.classList.add("hidden");
  viewHistoryName.innerText = "";
  const tableBody = viewHistoryTable.querySelector("tbody");
  tableBody.innerHTML = "";
};
const updateRecordTable = async () => {
  try {
    const recordsResponse = await getRecords();
    recordsData = recordsResponse.records;

    recordsTableData = recordsData.map((record) => ({
      name: record.name,
      complaint: record.complaint,
      date: record.date,
      medication: record.medication,
      nurse: record.userCreated,
      viewHistory: record.name,
    }));

    pageCountElement.innerText = Math.ceil(recordsTableData.length / PAGE_SIZE);
    pages = Array.from(
      { length: Math.ceil(recordsTableData.length / PAGE_SIZE) },
      (_, i) => recordsTableData.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
    );
    renderPage(1);
  } catch (error) {
    console.error(error);
  }
};

const initializeClinicRecord = async () => {
  await updateRecordTable();
  setupEventListeners();
};

initializeClinicRecord();
