<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>Dashboard</title>
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
      //Emergency modal COMPONENT
      //require_once './frontend/components/emergency_modal.php';
      //Request form modal COMPONENT
      //require_once './frontend/components/request_form_modal.php';
      ?>

      <!-- MAIN CONTENT -->
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px] '>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-2xl'>Dashboard</h1>
          <!-- CONTENT -->
          <div class='w-full p-10 mt-5 border border-gray-300 rounded-md overflow-y-auto'>
            <div class='flex flex gap-[50px]'>
              <!-- Table info -->
              <div class='w-[50%]'>
                <h1 class='font-medium text-xl text-gray-700 pb-2'>Medicine Inventory Overview</h1>
                <p class='text-gray-500'>Brand of medicines and their remaining stocks, expiration, and storage.</p>
                <div class='flex gap-[20px] pt-3'>
                  <div class='flex items-center'>
                    <div class='h-[15px] w-[15px] bg-red-500 rounded-md'></div>
                    <h3 class='text-sm text-gray-500 ms-3'>Expired</h3>
                  </div>
                  <div class='flex items-center'>
                    <div class='h-[15px] w-[15px] bg-blue-500 rounded-md'></div>
                    <h3 class='text-sm text-gray-500 ms-3'>Soon to expire</h3>
                  </div>
                </div>
              </div>
              <div class="w-[50%] flex flex-col justify-between">
                <!-- Buttons -->
                <div class='flex gap-3 justify-end'>
                  <button class='rounded-md font-medium bg-blue-600 text-gray-200 px-3 py-2 hover:bg-blue-500' onclick="toggleModal('requestFormModal')">Request form</button>
                  <button class='rounded-md font-medium bg-red-600 text-gray-200 px-3 py-2 hover:bg-red-500' type="button" onclick="toggleModal('modal-id')">Emergency no.</button>
                </div>
                <!-- Search -->
                <div class='flex justify-end pt-3 gap-3 w-full'>
                  <input type="search" class="w-full px-3 py-2 outline-none ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400 text-gray-500" placeholder="Search..." id='searchInput'>
                  <button class="bg-blue-600 px-3 py-2 rounded-md hover:bg-blue-500" id='searchButton'>
                    <svg class="w-4 h-4 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- Table -->
            <div class='mt-5'>
              <table class='min-w-full table-auto border-collapse' id='dashboardMedicinesTable'>
                <thead class="">
                  <tr class='border-b border-gray-300'>
                    <th class='py-3 text-gray-600 text-start'>Brand</th>
                    <th class='py-3 text-gray-600 text-start'>Remaining</th>
                    <th class='py-3 text-gray-600 text-start'>Expiration</th>
                    <th class='py-3 text-gray-600 text-start'>Storage</th>
                  </tr>
                </thead>
                <tbody id="tableBody" class="">
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine001</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine002</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine003</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine004</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine005</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine006</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine007</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine008</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine009</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine010</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class='flex mt-4 justify-end'>
              <!-- PAGE PREVIOUS BUTTON -->
              <button class='ring-1 ring-inset ring-gray-300 py-1 px-3 rounded-md hover:bg-gray-200' id='pagePrev'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600/50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </button>
              <div class="flex items-center mx-2 text-gray-500">
                <!-- PAGE NUMBER INPUT -->
                <input type="text" class="rounded-md w-[50px] outline-none ring-1 ring-inset ring-gray-300 text-center me-2 hover:ring-gray-400 focus:ring-gray-400" value="1" id='pageNumber'>
                <p>/ <span id='pageCount'>0</span></p>
              </div>
              <!-- PAGE NEXT BUTTON -->
              <button class='ring-1 ring-inset ring-gray-300 py-1 px-3 rounded-md hover:bg-gray-200'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600/50" id='pageNext'>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- SCRIPTS -->
  <script type="module" src="/src/js/pages/dashboard.js"></script>
</body>

</html>