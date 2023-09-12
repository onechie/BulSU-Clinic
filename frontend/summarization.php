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
  <style>
    @media print {
      @page {
        margin: 1cm;
        size: A4;
      }
    }
  </style>
  <title>Summarization</title>
</head>

<body class="">
  <div class='relative bg-slate-100 h-full overflow-hidden'>
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
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px] overflow-auto print:overflow-hidden print:p-0 print:pt-[110px] print:bg-white'>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col min-h-[500px] min-w-[900px]  print:w-full print:bg-white'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-2xl pb-5 font-noto print:hidden'>Summarization</h1>
          <!-- CONTENT -->
          <div class='w-full h-full p-10 border border-gray-399 rounded-md flex flex-col flex-grow print:flex-shrink print:text-[12px] print:border-none print:p-0'>
            <div class='flex flex gap-[50px] pb-5'>
              <!-- Table info -->
              <div class='w-[50%] print:w-[100%]'>
                <h1 class='font-medium text-xl text-gray-700 pb-2'>Medicine Consumption Analysis</h1>
                <p class='text-gray-500'>Brand of medicines and their consumption per month.</p>
              </div>
              <div class="w-[50%] flex flex-col justify-between print:hidden">
                <!-- Buttons -->
                <div class='flex gap-[20px] justify-end'>
                  <button class='rounded-md ring-1 bg-green-600 text-gray-200 px-3 py-2 hover:bg-green-500' id='printSummarization'>Print</button>
                </div>
                <!-- Dropdown -->
                <div class='flex justify-end pt-3 gap-3 w-full'>
                  <select id="selectMonth" class='outline-none py-3 ps-3 pe-2 text-gray-600 rounded-md border border-gray-300 bg-gray-100 hover:border-gray-400'>
                  </select>
                </div>
              </div>
            </div>
            <!-- Chart -->
            <div class="flex-grow overflow-y-auto  h-[150px] print:overflow-hidden">
              <div class='relative h-full overflow-hidden print:overflow-hidden'>
                <canvas id="barChart"></canvas>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
  <script type='module' src="/src/js/pages/summarization.js"></script>
</body>

</html>