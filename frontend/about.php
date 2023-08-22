<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>About</title>
</head>

<body class="overflow-hidden">
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
          <div>
            <h1 class='text-gray-700 font-medium text-2xl'>About us</h1>
            <div class='w-full p-10 mt-5 border border-gray-600/20 rounded overflow-y-auto'>
              <p class="text-left text-gray-600">We are students from bulacan state university.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>