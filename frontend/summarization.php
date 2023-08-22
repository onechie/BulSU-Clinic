<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>Summarization</title>
</head>

<body class="">
  <div class='relative bg-slate-100 h-full'>
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
          <h1 class='text-gray-700 font-medium text-2xl'>Summarization</h1>
          <!-- CONTENT -->
          <div class='w-full p-10 mt-5 border border-gray-399 rounded-md overflow-hidden'>
            <div class='flex flex gap-[50px] pb-3'>
              <!-- Table info -->
              <div class='w-[50%]'>
                <h1 class='font-medium text-xl text-gray-700 pb-2'>Medicine Consumption Analysis</h1>
                <p class='text-gray-500'>Brand of medicines and their consumption per month.</p>
              </div>
              <div class="w-[50%] flex flex-col justify-between">
                <!-- Buttons -->
                <div class='flex gap-[20px] justify-end'>
                  <button class='rounded-md ring-1 bg-green-600 text-gray-200 px-3 py-2 hover:bg-green-500' type="button">Print</button>
                </div>
                <!-- Search -->
                <div class='flex justify-end pt-3 gap-3 w-full'>
                  <input type="search" id="default-search" class="w-full px-3 py-2 outline-none ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" placeholder="Search...">
                  <button class="bg-blue-600 px-3 py-2 rounded-md">
                    <svg class="w-4 h-4 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            <!-- Chart -->
            <div class="h-[90%] overflow-y-auto flex">
              <div class='relative h-[100vh] w-[95%]'>
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
  <script src="/src/js/summarization.js"></script>
</body>

</html>