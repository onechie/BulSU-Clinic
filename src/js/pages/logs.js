import { getLogs } from "../api/logs.js";
import {
  createTableRows,
  onClick,
  getById,
  handleCancel,
} from "../utils/utils.js";

const PAGE_SIZE = 10;

const searchInput = getById("searchInput");
const activityLogsTable = getById("activityLogsTable");
const pageCountElement = getById("pageCount");
const pageNumberInput = getById("pageNumber");

const showLogModal = getById("showLogModal");
const showLogAction = getById("showLogAction");
const showLogDateTime = getById("showLogDateTime");
const showLogUser = getById("showLogUser");
const showLogDescription = getById("showLogDescription");
const showLogClose = getById("showLogClose");

let logsData = [];
let logsTableData = [];
let pages = [];
let currentPage = 1;

const formatDateTime = (dateTime) => {
  const [date, time] = dateTime.split(" ");
  const timeParts = time.split(":");
  const hours = parseInt(timeParts[0]);
  const minutes = parseInt(timeParts[1]);
  const seconds = parseInt(timeParts[2]);

  const formattedTime = `${hours % 12 === 0 ? 12 : hours % 12}:${minutes
    .toString()
    .padStart(2, "0")}:${seconds.toString().padStart(2, "0")} ${
    hours >= 12 ? "PM" : "AM"
  }`;
  return { date, time: formattedTime };
};

const customTDFunction = (key, value, td) => {
  if (key === "showDetails") {
    td.innerHTML = `<button class="underline text-blue-500">show details</button>`;
    td.classList = "py-3 text-end";
    const button = td.querySelector("button");
    onClick(button, () => {
      const log = logsData.find((log) => log.id === value);
      const { date, time } = formatDateTime(log.created_at);
      showLogModal.classList.remove("hidden");
      showLogAction.innerText = log.action;
      showLogDateTime.innerText = `${date} ${time}`;
      showLogUser.innerText = log.username;
      showLogDescription.innerText = log.description.replace(/\. /g, ".\n");
    });
  }
};

const setupEventListeners = () => {
  onClick(getById("searchButton"), handleSearch);
  onClick(getById("pageNext"), () => handlePageChange(1));
  onClick(getById("pagePrev"), () => handlePageChange(-1));
  pageNumberInput.addEventListener("change", handlePageInputChange);
  onClick(showLogClose, () => {
    handleCancel(
      showLogModal,
      [],
      [showLogAction, showLogDateTime, showLogUser, showLogDescription]
    );
  });
};

const renderPage = (pageNumber) => {
  pageNumber = Math.min(Math.max(1, pageNumber), pages.length);
  createTableRows(pages[pageNumber - 1], activityLogsTable, customTDFunction);
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
  const searchOutput = logsTableData.filter((log) =>
    Object.values(log).some((value) =>
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

const updateActivityLogsTable = async () => {
  try {
    logsData = await getLogs();

    logsTableData = logsData.map((log) => {
      const { date, time } = formatDateTime(log.created_at);

      return {
        date: date,
        time: time,
        activity: log.action,
        username: log.username,
        showDetails: log.id,
      };
    });

    pageCountElement.innerText = Math.ceil(logsTableData.length / PAGE_SIZE);
    pages = Array.from(
      { length: Math.ceil(logsTableData.length / PAGE_SIZE) },
      (_, i) => logsTableData.slice(i * PAGE_SIZE, (i + 1) * PAGE_SIZE)
    );
    renderPage(1);
  } catch (error) {
    console.error(error);
  }
};

const initializeActivityLogs = async () => {
  await updateActivityLogsTable();
  setupEventListeners();
};

initializeActivityLogs();
