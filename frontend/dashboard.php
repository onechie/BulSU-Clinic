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

<body class="overflow-hidden">
  <div class='relative bg-gray-100 h-full w-full min-w-fit min-h-[1800px] '>
    <?php
    //HEADER COMPONENT
    require_once './frontend/components/header.php';
    ?>
    <div class="flex h-full w-full">
      <?php
      //NAVBAR COMPONENT
      require_once './frontend/components/navbar.php';
      //Emergency COMPONENT
      require_once './frontend/components/emergency.php';
      ?>

      <!-- MAIN CONTENT -->
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px] '>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-3xl'>Dashboard</h1>
          <!-- SUB HEADER -->
          <!-- CONTENT -->
          <div class='w-full p-10 mt-5 border border-gray-600/20 rounded overflow-y-auto'>
            <div class='flex'>
              <!-- Table info -->
              <div class='w-[50%]'>
                <h1 class='font-medium text-xl text-gray-700 pb-2'>Medicines</h1>
                <p class='text-gray-500'>Brand of medicines and their remaining stocks, expiration, and storage.</p>
                <div class='flex gap-[20px] pt-3'>
                  <div class='flex items-center'>
                    <div class='h-[15px] w-[15px] bg-red-500 rounded'></div>
                    <h3 class='text-sm text-gray-500 ms-3'>Expired</h3>
                  </div>
                  <div class='flex items-center'>
                    <div class='h-[15px] w-[15px] bg-blue-500 rounded'></div>
                    <h3 class='text-sm text-gray-500 ms-3'>Soon to expire</h3>
                  </div>
                </div>
              </div>
              <div class="w-[50%] flex flex-col justify-between">
                <!-- Buttons -->
                <div class='flex gap-[20px] justify-end'>
                  <button class='rounded ring-2 bg-blue-600 text-gray-200 ring-inset ring-blue-600/50 px-3 py-1 hover:bg-blue-600 hover:text-gray-300'>Request form</button>
                  <button class='rounded ring-2 bg-red-600 text-gray-200 ring-inset ring-red-600/50 px-3 py-1 hover:bg-red-600 hover:text-gray-300' type="button" onclick="toggleModal('modal-id')">Emergency no.</button>
                </div>
                <!-- Search -->
                <div class='flex justify-end pt-3 w-full'>
                  <input type="search" id="default-search" class="w-full px-3 py-1 outline-none ring-2 ring-gray-600/20 rounded me-3 focus:ring-2 focus:ring-gray-600/50" placeholder="Search...">
                  <button class="bg-blue-600 px-3 rounded">
                    <svg class="w-4 h-4 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- Table -->
            <div class='mt-5'>
              <table class='min-w-full table-auto border-collapse'>
                <thead class="">
                  <tr class='border-b border-gray-600/20'>
                    <th class='py-3 text-gray-600 text-start '>Brand</th>
                    <th class='py-3 text-gray-600 text-start '>Remaining</th>
                    <th class='py-3 text-gray-600 text-start '>Expiration</th>
                    <th class='py-3 text-gray-600 text-start '>Storage</th>
                  </tr>
                </thead>
                <tbody id="tableBody" class="">
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine001</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine002</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine003</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine004</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine005</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine006</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-blue-500'>01-01-2024</td>
                    <td class='py-3 text-blue-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine007</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine008</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
                    <td class='py-3 text-gray-600 font-medium'>Medicine009</td>
                    <td class='py-3 text-gray-500'>100</td>
                    <td class='py-3 text-red-500'>01-01-2024</td>
                    <td class='py-3 text-red-500'>Drawer A</td>
                  </tr>
                  <tr class='border-b border-gray-500/10'>
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
              <button class='ring-2 ring-inset ring-gray-600/20 py-1 px-2 rounded hover:ring-gray-600/50'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600/50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </button>
              <div class="flex items-center text-lg mx-2 text-gray-600/80">
                <!-- PAGE NUMBER INPUT -->
                <input type="text" class="w-[50px] outline-none ring-2 ring-inset ring-gray-600/20 text-xl text-center me-2 hover:ring-gray-600/50" value="1">
                <p>/ <span>100</span></p>
              </div>
              <!-- PAGE NEXT BUTTON -->
              <button class='ring-2 ring-inset ring-gray-600/20 py-1 px-2 rounded hover:ring-gray-600/50'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600/50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>

</html>