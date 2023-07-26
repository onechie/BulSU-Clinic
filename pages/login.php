<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Login</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="../src/styles/index.css" />
</head>

<body class="overflow-hidden">
  <div class="w-full h-full relative min-w-[1200px] min-h-[675px]">
    <?php
    require_once "./pages/components/notification.html";
    require_once "./pages/components/backToHome.html";
    require_once "./pages/components/header.html"
    ?>

    <div class="w-full flex justify-center items-center h-full bg-slate-100">
      <div class="w-full h-full max-w-[1200px] flex justify-center items-center pt-[30px]">
        <div class="w-[400px] h-[450px] bg-white flex flex-col p-9 rounded-tr-[20px] rounded-bl-[20px] shadow-xl">
          <h1 class="text-4xl mb-6 text-lime-900">Sign In</h1>
          <label for="username">Username/Email <span class="text-red-500">*</span></label>
          <input type="text" placeholder="username" id="usernameOrEmail" class="mb-4 px-2 py-1 rounded border focus:outline-none focus:ring-1 focus:ring-lime-800" />
          <label for="username">Password <span class="text-red-500">*</span></label>
          <input type="password" placeholder="password" id="password" class="mb-4 px-2 py-1 rounded border focus:outline-none focus:ring-1 focus:ring-lime-800" />
          <div>
            <input type="checkbox" id="agreement" class="me-1 mt-4">
            <label class="text-sm" for="agreement">Keep me logged in.</label>
          </div>
          <button type="button" id="loginButton" onclick="(submitUserData(event))" class="py-1 px-5  bg-lime-900 mt-6 mb-10 rounded enabled:hover:bg-lime-950 disabled:opacity-75 disabled:bg-gray-600">
            <svg id="buttonLoading" hidden xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin text-white mx-auto">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            <span id="buttonReady" class="text-lg text-white">Login</span>
          </button>
          <p class="text-end">
            Don't have an account? <a href="../register" class="text-lime-900 underline text-base hover:text-lime-950">Register</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <script src="../src/js/login.js"></script>
</body>

</html>