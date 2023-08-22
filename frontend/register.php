<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>Register</title>
</head>

<body class="bg-gray-100">

  <?php
  //HEADER COMPONENT
  require_once './frontend/components/header.php';
  require_once './frontend/components/notification.php'
  ?>

  <div class="flex items-center justify-center px-6 py-8 h-full min-h-[800px]">
    <div class="w-full rounded-md border bg-gray-800 border-gray-700 max-w-2xl">
      <div class="p-6 space-y-6 sm:p-8">
        <h1 class="text-xl font-medium leading-tight tracking-tight text-gray-300 md:text-2xl">
          Create account
        </h1>
        <div class='flex flex-col gap-3'>
          <div class='flex justify-center items-center gap-4'>
            <div class='relative outline-none ring-2 ring-gray-500 hover:ring-gray-600 cursor-pointer rounded-full h-[100px] w-[100px] overflow-hidden bg-center bg-cover bg-[url("/src/images/logo.png")]'>
              <div class="absolute hover:bg-gray-600/20 h-full w-full"></div>
            </div>
            <div class=''>
              <p class="text-gray-300 text-lg font-medium">Profile photo</p>
              <label for="fileInput" class="text-gray-400 underline cursor-pointer hover:text-gray-500">
                Upload image
              </label>
              <input type="file" class='sr-only' id='profilePicture'>
            </div>
          </div>

          <div class='flex gap-3 w-full'>
            <div class="w-[50%]">
              <label for="username" class="block mb-2 text-sm font-medium text-gray-400">Your Username</label>
              <input type="text" id="username" class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500" placeholder="Username" required="">
            </div>

            <div class="w-[50%]">
              <label for="email" class="block mb-2 text-sm font-medium text-gray-400">Your email</label>
              <input type="email" id="email" class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500" placeholder="Email" required="">
            </div>

          </div>
          <div class='flex gap-3'>
            <div class='w-[50%]'>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-400">Password</label>
              <input type="password" id="password" placeholder="Password" class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500" required="">
            </div>
            <div class='w-[50%]'>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-400">Confirm Password</label>
              <input type="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500" required="">
            </div>
          </div>

          <div class='my-3'>
            <input type="checkbox" id="agreement" class="w-4 h-4 accent-white ring-1 ring-gray-600 rounded-md">
            <label class="ms-3 text-sm text-gray-400" for="agreement">I have read and agree to the Terms and Policies.</label>
          </div>
        </div>
        <button type="button" id="registerButton" onclick="(submitUserData())" class="w-full text-gray-200 bg-green-700 hover:bg-green-600 font-medium rounded-md h-[40px] text-center">
          <svg id="buttonLoading" hidden xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin text-white mx-auto">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
          </svg>
          <span id="buttonReady" class="text-gray-200 text-sm">Register</span>
        </button>
        <hr class="border-b-2 border-gray-700" />
        <p class="text-end text-sm font-light text-gray-400">
          Already have an account? <a href="/login" class="text-sm font-semibold hover:underline text-primary-500">Sign in</a>
        </p>
      </div>
    </div>
  </div>
  </div>

  <script src="/src/js/register.js"></script>
</body>

</html>