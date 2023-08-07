<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

  <link rel="stylesheet" href="/src/styles/index.css" />
</head>

<body class="overflow-hidden">
  <div class="w-full h-full relative min-w-[1200px] min-h-[675px]">
    <?php
    require_once __DIR__ . "/components/notification.html";
    require_once __DIR__ . "/components/backToHome.html";
    require_once __DIR__ . "/components/header.html"
    ?>

    <div class="w-full flex justify-center items-center h-full bg-slate-100">
      <div class="w-full h-full max-w-[1200px] flex justify-center items-center pt-[30px]">
        <div class="w-[400px] h-[450px] bg-white flex flex-col p-9 rounded-tr-[20px] rounded-bl-[20px] shadow-xl">
          <h1 class="text-4xl mb-6 text-lime-900">Dashboard</h1>

        </div>
      </div>
    </div>
  </div>
  <script src="/src/js/dashboard.js"></script>
</body>

</html>