<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>Settings</title>
</head>

<body class="">
  <div class='relative bg-gray-100 h-full'>
    <?php
    //HEADER COMPONENT
    require_once './frontend/components/header.php';
    ?>
    <div class="flex h-full w-full">
      <?php
      //NAVBAR COMPONENT
      require_once './frontend/components/navbar.php';
      ?>

      <!-- MAIN CONTENT -->
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px] '>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-2xl'>Settings</h1>
          <!-- CONTENT -->
          <div class='w-full p-10 mt-5 border border-gray-600/20 rounded overflow-y-auto'>
            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">User</summary>
              <div>
                <div class="px-5 pt-5">
                  <h3 class='text-gray-600 font-medium pb-3'>Personal and account information</h3>
                  <div class='flex flex-col'>
                    <label for="password" class="text-gray-500 mb-1">Username</label>
                    <input type="text" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]" value="username001" disabled>
                  </div>
                  <div class='flex flex-col'>
                    <label for="password" class="text-gray-500 mb-1">Email</label>
                    <input type="text" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]" value="email@test.com" disabled>
                  </div>
                </div>
                <div class="p-5">
                  <h3 class='text-gray-600 font-medium pb-3'>Manage password</h3>
                  <div class='flex flex-col'>
                    <label for="password" class="text-gray-500 mb-1">Current password</label>
                    <input type="password" id="currentPassword" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]" placeholder="current password">
                  </div>
                  <div class='flex flex-col'>
                    <label for="password" class="text-gray-500 mb-1">New password</label>
                    <input type="password" id="newPassword" placeholder="new password" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]">
                  </div>
                  <div class='flex flex-col'>
                    <label for="password" class="text-gray-500 mb-1">Confirm new password</label>
                    <input type="password" id="RetypeNewPassword" placeholder="confirm new password" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-5 max-w-[250px]">
                  </div>
                  <div class='flex'>
                    <button type="button" onclick="" class="bg-blue-500 text-gray-200 py-2 px-3 rounded-md">
                      Change password
                    </button>
                  </div>

                </div>
              </div>
            </details>

            <hr />
            <!-- COMPLAINTS SETTINGS-->
            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Complaints</summary>
              <div class="space-y-3 max-w-3xl m-3">
                <div id="complaintsContainer" hidden>
                  <table class="w-full text-center">
                    <thead>
                      <tr>
                        <th class="bg-gray-500">ID</th>
                        <th class="bg-gray-500">Complaint</th>
                        <th class="bg-gray-500">Remove</th>
                      </tr>
                    </thead>
                    <tbody id="complaintsTable"></tbody>
                  </table>

                  <span id="complaintsMessage" class="message"></span>

                  <div class="flex">
                    <input type="text" id="newComplaintValue" placeholder="Text..." class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <button type="button" onclick="(addComplaint())" class="text-white bg-lime-950 hover:bg-lime-900 focus:ring-4 focus:outline-none focus:ring-primary-950 font-medium rounded-md text-sm px-3 py-2.5 text-center dark:bg-lime-600 dark:hover:bg-lime-900 dark:focus:ring-primary-800">
                      Add Complaint
                    </button>
                  </div>

                </div>
              </div>
            </details>

            <hr />
            <!-- TREATMENTS SETTINGS-->
            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Treatments</summary>
              <div class="space-y-3 max-w-3xl m-3">
                <div id="treatmentsContainer" hidden>
                  <table class="w-full text-center">
                    <thead>
                      <tr>
                        <th class="bg-gray-500">ID</th>
                        <th class="bg-gray-500">Treatment</th>
                        <th class="bg-gray-500">Remove</th>
                      </tr>
                    </thead>
                    <tbody id="treatmentsTable"></tbody>
                  </table>
                  <p></p>
                  <span id="treatmentsMessage" class="message"></span>

                  <div class="flex">
                    <input type="text" id="newTreatmentValue" placeholder="Text..." class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <button type="button" onclick="(addTreatment())" class="text-white bg-lime-950 hover:bg-lime-900 focus:ring-4 focus:outline-none focus:ring-primary-950 font-medium rounded-md text-sm px-3 py-2.5 text-center dark:bg-lime-600 dark:hover:bg-lime-900 dark:focus:ring-primary-800">
                      Add Treatment
                    </button>
                  </div>

                </div>
              </div>
            </details>

            <hr />
            <!-- LABORATORIES SETTINGS-->
            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Laboratories</summary>
              <div class="space-y-3 max-w-3xl m-3">

                <div id="laboratoriesContainer" hidden>
                  <table class="w-full text-center">
                    <thead>
                      <tr>
                        <th class="bg-gray-500">ID</th>
                        <th class="bg-gray-500">Laboratory</th>
                        <th class="bg-gray-500">Remove</th>
                      </tr>
                    </thead>
                    <tbody id="laboratoriesTable"></tbody>
                  </table>
                  <p></p>
                  <span id="laboratoriesMessage" class="message"></span>

                  <div class="flex">
                    <input type="text" id="newLaboratoryValue" placeholder="Text..." class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <button type="button" onclick="(addLaboratory())" class="text-white bg-lime-950 hover:bg-lime-900 focus:ring-4 focus:outline-none focus:ring-primary-950 font-medium rounded-md text-sm px-3 py-2.5 text-center dark:bg-lime-600 dark:hover:bg-lime-900 dark:focus:ring-primary-800">
                      Add Laboratory
                    </button>

                  </div>
                </div>
            </details>

            <hr />
            <!-- STORAGES SETTINGS-->
            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Storages</summary>
              <div class="space-y-3 max-w-3xl m-3">

                <div id="storagesContainer" hidden>
                  <table class="w-full text-center">
                    <thead>
                      <tr>
                        <th class="bg-gray-500">ID</th>
                        <th class="bg-gray-500">Storage</th>
                        <th class="bg-gray-500">Remove</th>
                      </tr>
                    </thead>
                    <tbody id="storagesTable"></tbody>
                  </table>
                  <p></p>
                  <span id="storagesMessage" class="message"></span>

                  <div class="flex">
                    <input type="text" id="newStorageValue" placeholder="Text..." class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    <button type="button" onclick="(addStorage())" class="text-white bg-lime-950 hover:bg-lime-900 focus:ring-4 focus:outline-none focus:ring-primary-950 font-medium rounded-md text-sm px-3 py-2.5 text-center dark:bg-lime-600 dark:hover:bg-lime-900 dark:focus:ring-primary-800">
                      Add Storage
                    </button>
                  </div>

                </div>
              </div>
            </details>
            <hr />
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>