<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <style>
    @media print {
      @page {
        margin: 1cm;
        size: A4;
      }
    }
  </style>
  <title>Inventory</title>
</head>

<body class="">
  <div class='relative bg-gray-100 h-full overflow-hidden'>
    <?php
    //HEADER COMPONENT
    require_once './frontend/components/header.php';
    ?>
    <div class="flex h-full w-full">
      <?php
      //NAVBAR COMPONENT
      require_once './frontend/components/navbar.php';
      ?>

      <div id='addMedicineModal' class='hidden'>
        <?php
        //Add medicine COMPONENT
        require_once './frontend/components/add_medicine_modal.php';
        ?>
      </div>
      <div id='editMedicineModal' class='hidden'>
        <?php
        //Edit medicine COMPONENT
        require_once './frontend/components/edit_medicine_modal.php';
        ?>
      </div>

      <!-- MAIN CONTENT -->
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px] overflow-auto print:p-0 print:pt-[110px] print:bg-white'>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col min-h-[500px] print:w-full print:bg-white'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-2xl pb-5 font-noto print:hidden'>Inventory</h1>


          <!-- CONTENT -->
          <div class='w-full p-10 border border-gray-300 rounded-md flex flex-col flex-grow print:flex-shrink print:text-[12px] print:border-none print:p-0'>
            <div class='flex flex gap-[50px] pb-5'>
              <!-- Table info -->
              <div class='w-[50%] print:w-[100%]'>
                <h1 class='font-medium text-xl text-gray-700 pb-2'>Medicine Inventory Management</h1>
                <p class='text-gray-500'>Name and Brand of medicine and their unit, expiration, number of boxes, number of items per box, total remaining and dispensed items.</p>
              </div>
              <div class="w-[50%] flex flex-col justify-between print:hidden">
                <!-- Buttons -->
                <div class='flex gap-3 justify-end'>
                  <button class='rounded-md bg-blue-600 text-gray-200 px-3 py-2 hover:bg-blue-500' id='addMedicineButton'>New medicine</button>
                  <button class='rounded-md bg-green-600 text-gray-200 px-3 py-2 hover:bg-green-500' id='printInventory'>Print</button>
                </div>
                <!-- Search -->
                <div class='flex justify-end pt-3 gap-3 w-full'>
                  <input type="search" class="w-full px-3 py-2 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" placeholder="Search..." id='searchInput'>
                  <button class="bg-blue-600 px-3 py-2 rounded hover:bg-blue-500" id='searchButton'>
                    <svg class="w-4 h-4 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- Table -->
            <div class='overflow-scroll print:overflow-hidden flex-grow h-[150px] pe-2'>
              <table class='min-w-full table-auto border-collapse' id='inventoryMedicinesTable'>
                <thead class="">
                  <tr class='border-b border-gray-300'>
                    <th class='py-3 text-gray-600 text-start pe-3'>Name</th>
                    <th class='py-3 text-gray-600 text-start pe-3'>Brand</th>
                    <th class='py-3 text-gray-600 text-start pe-3'>Unit</th>
                    <th class='py-3 text-gray-600 text-start pe-3'>Expiration</th>
                    <th class='py-3 text-gray-600 text-start pe-3'># of Boxes</th>
                    <th class='py-3 text-gray-600 text-start pe-3'># per Box</th>
                    <th class='py-3 text-gray-600 text-start pe-3'>Total items</th>
                    <th class='py-3 text-gray-600 text-start pe-3'>Dispensed</th>
                    <th class='py-3 text-gray-600 text-start pe-3'>Remaining</th>
                  </tr>
                </thead>
                <tbody class="">
                  <tr class='border-b border-gray-200 hidden'>
                    <td class='py-3 text-gray-600 font-medium'>Name</td>
                    <td class='py-3 text-gray-500'>Brand</td>
                    <td class='py-3 text-gray-500'>Unit</td>
                    <td class='py-3 text-gray-500'>00-00-0000</td>
                    <td class='py-3 text-gray-500'>0</td>
                    <td class='py-3 text-gray-500'>0</td>
                    <td class='py-3 text-gray-500'>0</td>
                    <td class='py-3 text-gray-500'>0</td>
                    <td class="max-w-[20px]"><button class="underline text-blue-500">edit</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class='flex justify-end pt-3 print:hidden'>
              <!-- PAGE PREVIOUS BUTTON -->
              <button class='ring-1 ring-inset ring-gray-300 py-1 px-3 rounded-md hover:bg-gray-200' id='pagePrev'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600/50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </button>
              <div class="flex items-center mx-2 text-gray-500">
                <!-- PAGE NUMBER INPUT -->
                <input type="text" class="rounded-md w-[50px] outline-none ring-1 ring-inset ring-gray-300 text-center me-2 hover:ring-gray-400 focus:ring-gray-400" value="0" id='pageNumber'>
                <p>/ <span id='pageCount'>0</span></p>
              </div>
              <!-- PAGE NEXT BUTTON -->
              <button class='ring-1 ring-inset ring-gray-300 py-1 px-3 rounded-md hover:bg-gray-200' id='pageNext'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600/50">
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
  <script type="module" src="/src/js/pages/inventory.js"></script>
</body>

</html>