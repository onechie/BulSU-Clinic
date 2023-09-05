<div class="w-full flex justify-between h-[50px] bg-lime-900 absolute shadow-[inset 0 2px 4px 0 rgb(0 0 0 / 0.05)] top-0">
  <div class="h-full flex items-center px-5" fixed>
    <img src="./src/images/logo.png" class="h-[45px]" />
    <h1 class="text-lime-50 ms-3 font-poppins text-xl font-medium">
      <span class='font-medium text-2xl'>B</span><small class=''>UL</small>SU
      <span class='font-medium text-2xl'>C</span><small class=''>LINIC</small>
    </h1>
  </div>
  <div class='h-full flex items-center px-5'>
    <div class="flex h-full px-2 items-center hover:bg-black/20 hover:cursor-pointer" id='user-button'>
      <div id='profile-picture' class='me-1 relative outline-none ring-1 ring-gray-200 rounded-full h-[35px] w-[35px] overflow-hidden bg-center bg-cover bg-[url("/src/images/default-profile.jpg")]'>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-200">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
      </svg>
    </div>
    <div class="relative h-full">
      <div class='bg-gray-800 absolute right-0 top-[50px] flex flex-col shadow hidden' id='user-menu'>
        <div>

        </div>
        <a href="/settings" class="flex p-3 border-b border-gray-700 hover:bg-gray-900/50 hover:cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <p class='text-gray-400 px-2 whitespace-nowrap' id='user-settings'>
            Account settings
          </p>
        </a>
        <div class="flex p-3 border-b border-gray-700 hover:bg-gray-900/50 hover:cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
          </svg>
          <p class='text-gray-400 px-2 whitespace-nowrap' id='user-logout'>
            Logout
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="module" src="/src/js/pages/header.js">
</script>