<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>Records</title>
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
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px]'>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-2xl'>Clinic Records</h1>
          <!-- CONTENT -->
          <div class='w-full p-10 mt-5 border border-gray-300 rounded-md overflow-y-auto'>
            <div class='flex flex gap-[50px]'>
              <!-- Table info -->
              <div class='w-[50%]'>
                <h1 class='font-medium text-xl text-gray-700 pb-2'>Patients Record Overview</h1>
                <p class='text-gray-500'>Name of patient and their complaint, date of entry, and medication.</p>
              </div>
              <div class="w-[50%] flex flex-col justify-between">
                <!-- Search -->
                <div class='flex justify-end pt-3 gap-3 w-full'>
                  <input type="search" id="default-search" class="w-full px-3 py-2 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" placeholder="Search...">
                  <button class="bg-blue-600 px-3 py-2 rounded-md hover:bg-blue-500">
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
                  <tr class='border-b border-gray-300'>
                    <th class='py-3 text-gray-600 text-start '>Name</th>
                    <th class='py-3 text-gray-600 text-start '>Complaint</th>
                    <th class='py-3 text-gray-600 text-start '>Date of entry</th>
                    <th class='py-3 text-gray-600 text-start '>Medication</th>
                    <th class='py-3 text-gray-600 text-start '>Nurse</th>
                  </tr>
                </thead>
                <tbody id="tableBody" class="">
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 001</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 002</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 003</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 004</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 005</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 006</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 007</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 008</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 009</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                  <tr class='border-b border-gray-200'>
                    <td class='py-3 text-gray-600 font-medium'>Patient 010</td>
                    <td class='py-3 text-gray-500'>Headache</td>
                    <td class='py-3 text-gray-500'>01-01-2023</td>
                    <td class='py-3 text-gray-500'>Medicol</td>
                    <td class='py-3 text-gray-500'>Nurse 001</td>
                    <td class="max-w-[35px]"><button class="underline text-blue-500">view history</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class='flex mt-4 justify-end'>
              <!-- PAGE PREVIOUS BUTTON -->
              <button class='ring-1 ring-inset ring-gray-300 py-1 px-3 rounded-md hover:bg-gray-200'>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-600/50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
              </button>
              <div class="flex items-center mx-2 text-gray-500">
                <!-- PAGE NUMBER INPUT -->
                <input type="text" class="rounded-md w-[50px] outline-none ring-1 ring-inset ring-gray-300 text-center me-2 hover:ring-gray-400 focus:ring-gray-400" value="1">
                <p>/ <span>100</span></p>
              </div>
              <!-- PAGE NEXT BUTTON -->
              <button class='ring-1 ring-inset ring-gray-300 py-1 px-3 rounded-md hover:bg-gray-200'>
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
</body>

</html>