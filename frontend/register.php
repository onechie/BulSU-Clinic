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

<body class="">
    <div class='relative bg-gray-100 h-full overflow-hidden'>
        <?php
        //HEADER COMPONENT
        require_once './frontend/components/notification.php';
        ?>
        <!-- MAIN CONTENT -->
        <div class='h-full w-full flex flex-col items-center p-3 py-5 overflow-y-auto'>
            <form
                class="p-6 space-y-4 sm:space-y-6 w-full rounded-md border bg-gray-800 border-gray-700 max-w-2xl my-auto"
                id='registerForm'>
                <h1 class="text-2xl font-medium leading-tight tracking-tight text-gray-300">
                    Create account
                </h1>
                <div class='flex flex-col gap-2 sm:gap-3'>
                    <div class='flex justify-center items-center gap-4'>
                        <div id='profilePicturePreview'
                            class='relative outline-none ring-2 ring-gray-500 hover:ring-gray-600 cursor-pointer rounded-full h-[100px] w-[100px] overflow-hidden bg-center bg-cover bg-[url=("")]'>
                            <div class="absolute hover:bg-gray-600/20 h-full w-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-gray-600"
                                    id='profileIcon'>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class=''>
                            <p class="text-gray-300 text-lg font-medium">Profile photo</p>
                            <label for="profilePicture"
                                class="text-gray-400 underline cursor-pointer hover:text-gray-500">
                                Upload image
                            </label>
                            <input type="file" class='sr-only' name="profilePicture" id='profilePicture'>
                        </div>
                    </div>

                    <div class='flex flex-col sm:flex-row gap-3 w-full'>
                        <div class="w-full sm:w-[50%]">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-400">Your
                                Username</label>
                            <input type="text" name="username"
                                class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500"
                                placeholder="Username" required="">
                        </div>
                        <div class="w-full sm:w-[50%]">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-400">Your email</label>
                            <input type="email" name="email"
                                class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500"
                                placeholder="Email" required="">
                        </div>

                    </div>
                    <div class='flex gap-3 flex-col sm:flex-row w-full'>
                        <div class='w-full sm:w-[50%]'>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-400">Password</label>
                            <input type="password" name="password" placeholder="Password"
                                class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500"
                                required="">
                        </div>
                        <div class='w-full sm:w-[50%]'>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-400">Confirm
                                Password</label>
                            <input type="password" name="confirmPassword" placeholder="Confirm Password"
                                class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md w-full hover:ring-gray-500 focus:ring-gray-500"
                                required="">
                        </div>
                    </div>
                    <div class='flex gap-3 flex-col sm:flex-row w-full'>
                        <div class='w-full sm:w-[50%]'>
                            <label for="otp" class="block mb-2 text-sm font-medium text-gray-400">One-time
                                password</label>
                            <div class='flex gap-3'>
                                <input type="text" name="otp" id='otp' placeholder="One-time password"
                                    class="outline-none ring-1 ring-gray-600 bg-gray-700 p-2.5 text-sm text-gray-400 rounded-md flex-grow hover:ring-gray-500 focus:ring-gray-500"
                                    required="">
                                <div class="w-[90px] flex items-center">
                                    <button id='sendOtpButton' type="button"
                                        class="text-gray-200 ring-1 ring-gray-600 hover:bg-gray-600 rounded-md w-full h-[40px] text-center disabled:bg-gray-700">
                                        <svg id="otpButtonLoading" hidden xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            class="w-6 h-6 animate-spin text-white mx-auto">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                        <span id="otpButtonReady" class="text-gray-200 text-sm">Send OTP</span>
                                    </button>
                                    <p class='font-medium text-gray-400 hidden text-center' id="otpButtonTimer">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='my-3'>
                        <input type="checkbox" name="agreement"
                            class="w-4 h-4 accent-white ring-1 ring-gray-600 rounded-md">
                        <label class="ms-3 text-sm text-gray-400" for="agreement">I have read and agree to the Terms and
                            Policies.</label>
                    </div>
                </div>
                <button type="submit" id="registerButton"
                    class="w-full text-gray-200 bg-green-700 hover:bg-green-600 font-medium rounded-md h-[40px] text-center disabled:bg-gray-700">
                    <svg id="buttonLoading" hidden xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin text-white mx-auto">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <span id="buttonReady" class="text-gray-200 text-sm">Register</span>
                </button>
                <hr class="border-b-2 border-gray-700" />
                <p class="text-end text-sm font-light text-gray-400">
                    Already have an account? <a href="/login"
                        class="text-sm font-semibold hover:underline text-primary-500">Sign in</a>
                </p>
            </form>
        </div>
    </div>
    <!-- SCRIPTS -->
    <script type="module" src="/src/js/pages/register.js"></script>
</body>

</html>