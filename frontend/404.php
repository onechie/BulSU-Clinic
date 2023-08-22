<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>404 - Not Found</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/src/styles/index.css" />
  </head>

  <body class="-overflow-hidden">
    <div class="w-full h-[400px] bg-white relative">
      <div class="w-full flex justify-center z-10 h-[80px] absolute">
        <div class="w-full max-w-[1200px]">
          <div class="h-full flex items-center ps-3">
            <img src="/src/images/logo.png" class="h-[60px]" />
            <h1 class="text-2xl font-bold text-lime-950 ms-3">BulSU CLINIC</h1>
          </div>
        </div>
      </div>
      <div class="w-full flex justify-center absolute">
        <div
          class="bg-[url('/src/images/effects-2.png')] h-[400px] max-w-[1200px] bg-center bg-cover w-full"
        ></div>
      </div>
      <div class="w-full h-[400px] absolute flex justify-center">
        <div class="w-full h-full flex justify-between max-w-[1200px]">
          <div class="h-full w-full pt-[120px] pb-[100px]">
            <div class="text-4xl font-bold text-lime-950 my-5 flex">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-11 h-11"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                />
              </svg>
              <span class="ps-3">Error 404</span>
            </div>
            <div class="flex w-full gap-[40px] text-gray-900 mt-10">
              <p class="flex text-lime-900 text-xl">
                Apologies, but the page you're looking for cannot be found.
              </p>
            </div>
            <div class="mt-5 underline">
              <a href="/">Back to home</a>
            </div>
          </div>
          <div class="h-full w-full pt-[120px] pb-[100px] flex justify-center">
            <div
              class="bg-[url('/src/images/logo.png')] h-[200px] w-[200px] bg-center bg-cover"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full h-full flex justify-center mt-5">
      <div
        class="w-full h-full max-w-[1200px] grid grid-cols-4 grid-rows-6 gap-5 p-5"
      >
        <!-- BOTTOM -->
      </div>
    </div>
  </body>
</html>
