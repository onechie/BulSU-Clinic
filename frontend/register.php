<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Register</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="../src/styles/index.css" />
</head>

<body class="overflow-hidden">
  <div class="w-full h-full relative min-w-[1200px] min-h-[675px]">
    <?php
    require_once "./frontend/components/notification.html";
    require_once "./frontend/components/backToHome.html";
    require_once "./frontend/components/header.html"
    ?>

    <div class="w-full flex justify-center items-center h-full bg-slate-100">
      <div class="w-full h-full max-w-[1200px] flex justify-center items-center pt-[30px]">
        <div class="w-[400px] h-[600px] bg-white flex flex-col p-9 rounded-tr-[20px] rounded-bl-[20px] shadow-xl">
          <h1 class="text-4xl mb-6 text-lime-900">Sign Up</h1>
          <label for="username">Username <span class="text-red-500">*</span></label>
          <input type="text" placeholder="username" id="username" class="mb-4 px-2 py-1 rounded border focus:outline-none focus:ring-1 focus:ring-lime-800" />
          <label for="email">Email <span class="text-red-500">*</span></label>
          <input type="email" placeholder="email" id="email" class="mb-4 px-2 py-1 rounded border focus:outline-none focus:ring-1 focus:ring-lime-800" />
          <label for="password">Password <span class="text-red-500">*</span></label>
          <input type="password" placeholder="password" id="password" class="mb-4 px-2 py-1 rounded border focus:outline-none focus:ring-1 focus:ring-lime-800" />
          <label for="confirmPassword">Confirm Password <span class="text-red-500">*</span></label>
          <input type="password" placeholder="confirm password" id="confirmPassword" class="mb-4 px-2 py-1 rounded border focus:outline-none focus:ring-1 focus:ring-lime-800" />
          <div>
            <input type="checkbox" id="agreement" class="me-1 mt-4">
            <label class="text-sm" for="agreement">I have read and agree to the Terms and Policies.</label>
          </div>
          <button type="button" id="registerButton" onclick="(submitUserData())" class="h-[36px] py-1 px-5  bg-lime-900 mt-6 mb-10 rounded enabled:hover:bg-lime-900 disabled:opacity-75 disabled:bg-gray-600">
            <svg id="buttonLoading" hidden xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin text-white mx-auto">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
            <span id="buttonReady" class="text-lg text-white">Register</span>
          </button>
          <p class="text-end">
            Already have an account? <a href="../login" class="text-lime-900 underline text-base hover:text-lime-900">Login</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <script src="../src/js/register.js"></script>
</body>
</html85