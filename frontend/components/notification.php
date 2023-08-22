<!--
    IDs
    container : notification
    title : notificationTitle
    message : notificationMessage
    success icon : notificationIconSuccess
    error icon : notificationIconError
    close button : close-notification
-->
<div class="absolute z-50 top-10 -right-[340px]">
  <div
    class="bg-white h-min-[80px] w-[320px] px-5 py-3 shadow-lg rounded flex"
    id="notification"
  >
    <div class="w-[30px] me-2">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6 text-lime-700"
        id="notificationIconSuccess"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
        />
      </svg>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6 text-red-700"
        id="notificationIconError"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
        />
      </svg>
    </div>
    <div class="w-[210px]">
      <h4 class="font-medium" id="notificationTitle">This is title!</h4>
      <p class="text-gray-700 opacity-70 m-0" id="notificationMessage">
        This is message
      </p>
    </div>
    <div class="ps-4 pt-1">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-4 h-4 text-sm lext-gray-700 opacity-50 cursor-pointer hover:text-gray-900 hover:opacity-100"
        id="close-notification"
        onclick="(closeNotification())"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M6 18L18 6M6 6l12 12"
        />
      </svg>
    </div>
  </div>
</div>
