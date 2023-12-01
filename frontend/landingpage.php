<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="/src/styles/index.css" />
    <title>Bulsu Clinic</title>
</head>

<body class="container min-h-screen bg-[url('/src/images/BHC.jpg')] bg-center bg-cover">
     <div>
      
        <div class="w-full flex justify-between h-[50px] bg-lime-900 absolute shadow-[inset 0 2px 4px 0 rgb(0 0 0 / 0.05)] top-0 print:bg-white print:h-[100px]">
          <div class="h-full flex items-center px-5" fixed>
            <img src="./src/images/logo.png" class="h-[45px] print:h-[90px]" />
            <h1 class="text-lime-50 ms-3 font-poppins text-xl font-medium print:text-3xl print:text-gray-700">
            <span class='text-2xl print:text-4xl'>B</span><small class=''>UL</small>SU
            <span class='text-2xl print:text-4xl'>H</span><small class=''>EALTH</small>
            <span class='text-2xl print:text-4xl'>S</span><small class=''>ERVICES</small>
            </h1>
          </div>
        </div>

        <div class="text-white mt-48 max-w-2lg p-5">
            <h1 class="text-6xl font-semibold leading-normal">BULSU<br>HEALTH <span class="font-light">SERVICES</span></h1>
            <p>A Bulsu Health Services is a medical facility in Bulsu Hagonoy Campus. Its primary purpose is to provide basic healthcare services to students, faculty, and staff.</p>

            <div class="mt-10">
                <a href="/login" class="bg-lime-900 rounded-3xl py-3 px-8 font-medium inline-block mr-4 hover:bg-transparent hover:border-lime-900 hover:text-white duration-300 hover:border border border-transparent">Sign-in Now</a>
                <a href="/register" class="hover:text-lime-800">Register Now <span >&#10148</span></a>
            </div>
        </div>

     </div>
</body>

</html>