<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <link rel="stylesheet" href="/src/styles/index.css" />
  <title>Settings</title>
</head>

<body class="">
  <div class='relative bg-gray-100 h-full overflow'>
    <?php
    //HEADER COMPONENT
    require_once './frontend/components/header.php';
    ?>
    <div class="flex h-full w-full">
      <?php
      //NAVBAR COMPONENT
      require_once './frontend/components/navbar.php';
      ?>
      <!-- MODALS -->
      <div class='hidden' id='add-template-modal'>
        <?php
        //Add template COMPONENT
        require_once './frontend/components/add_template_modal.php';
        ?>
      </div>
      <div class='hidden' id='edit-template-modal'>
        <?php
        //Edit template COMPONENT
        require_once './frontend/components/edit_template_modal.php';
        ?>
      </div>

      <!-- MAIN CONTENT -->
      <div class='bg-gray-300 h-full w-full p-3 pt-[60px] overflow-auto'>
        <div class='bg-gray-100 h-full w-full py-3 px-6 flex flex-col flex flex-col min-h-[500px] min-w-[900px]'>
          <!-- HEADER -->
          <h1 class='text-gray-700 font-medium text-2xl pb-5 font-noto'>Settings</h1>
          <!-- CONTENT -->
          <div class='w-full px-10 pt-5 border border-gray-300 rounded overflow-y-auto flex-grow'>
            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">User</summary>
              <div>
                <div class="px-5 pt-5">
                  <h3 class='text-gray-600 font-medium pb-3'>Personal and account information</h3>
                  <div class='flex flex-col'>
                    <p class="text-gray-500 mb-1">Username</p>
                    <input type="text" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]" value="username001" disabled>
                  </div>
                  <div class='flex flex-col'>
                    <p class="text-gray-500 mb-1">Email</p>
                    <input type="text" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]" value="email@test.com" disabled>
                  </div>
                </div>
                <div class="p-5">
                  <h3 class='text-gray-600 font-medium pb-3'>Manage password</h3>
                  <div class='flex flex-col'>
                    <p class="text-gray-500 mb-1">Current password</p>
                    <input type="password" id="currentPassword" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]" placeholder="current password">
                  </div>
                  <div class='flex flex-col'>
                    <p class="text-gray-500 mb-1">New password</p>
                    <input type="password" id="newPassword" placeholder="new password" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-2 max-w-[250px]">
                  </div>
                  <div class='flex flex-col'>
                    <p class="text-gray-500 mb-1">Confirm new password</p>
                    <input type="password" id="RetypeNewPassword" placeholder="confirm new password" class="px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 mb-5 max-w-[250px]">
                  </div>
                  <div class='flex'>
                    <button type="button" onclick="" class="bg-blue-500 text-gray-200 py-2 px-3 rounded-md">
                      Change password
                    </button>
                  </div>

                </div>
              </div>
            </details>

            <hr />
            <!-- 
              COMPLAINTS SETTINGS
              complaints-container
              complaints-add
              complaints-search-input
              complaints-search-button
              complaints-table
            -->

            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Manage Complaints</summary>
              <div class="px-3 pb-5">
                <div class='w-full' id="complaints-container">
                  <div class="flex pt-5 gap-5 pb-5">
                    <div class='w-[50%]'>
                      <h1 class='font-medium text-xl text-gray-700 pb-2'>Complaints Templates Management</h1>
                      <p class='text-gray-500'>Manage, Create, and Delete templates for Clinic form's Complaint Suggestions.</p>
                    </div>
                    <div class='w-[50%] flex flex-col justify-between gap-3'>
                      <div class='flex justify-end gap-3'>
                        <button id='complaints-add' type="button" class="bg-blue-600 px-3 py-2 rounded text-gray-200">
                          New complaint
                        </button>
                      </div>
                      <div class='flex gap-3'>
                        <input id='complaints-search-input' type="text" placeholder="Search..." class="flex-grow px-3 py-2 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" />
                        <button id='complaints-search-button' type="button" class="bg-blue-600 px-3 py-2 rounded">
                          <svg class="w-4 h-4 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class='overflow-scroll max-h-[300px] pe-2'>
                    <table class="min-w-full table-auto border-collapse" id="complaints-table">
                      <thead>
                        <tr class='border-b border-gray-300'>
                          <th class="py-3 text-gray-600 text-start pe-3">ID</th>
                          <th class="py-3 text-gray-600 text-start pe-3">Complaint</th>
                        </tr>
                      </thead>
                      <tbody class="">
                        <tr class='border-b border-gray-200'>
                          <td class='py-3 pe-3 text-gray-600 font-medium'>1</td>
                          <td class='py-3 pe-3 text-gray-500 w-1/2'>Test complaint</td>
                          <td class="text-end"><button class="underline text-blue-500">edit</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </details>

            <hr />
            <!-- 
              TREATMENTS SETTINGS
              treatments-container
              treatments-add
              treatments-search-input
              treatments-search-button
              treatments-table
            -->

            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Manage Treatments</summary>
              <div class="px-3 pb-5">
                <div class='w-full' id="treatments-container">
                  <div class="flex pt-5 gap-5 pb-5">
                    <div class='w-[50%]'>
                      <h1 class='font-medium text-xl text-gray-700 pb-2'>Treatments Templates Management</h1>
                      <p class='text-gray-500'>Manage, Create, and Delete templates for Clinic form's Treatment Suggestions.</p>
                    </div>
                    <div class='w-[50%] flex flex-col justify-between gap-3'>
                      <div class='flex justify-end gap-3'>
                        <button id='treatments-add' type="button" class="bg-blue-600 px-3 py-2 rounded text-gray-200">
                          New treatment
                        </button>
                      </div>
                      <div class='flex gap-3'>
                        <input id='treatments-search-input' type="text" placeholder="Search..." class="flex-grow px-3 py-2 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" />
                        <button id='treatments-search-button' type="button" class="bg-blue-600 px-3 py-2 rounded">
                          <svg class="w-4 h-4 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class='overflow-scroll max-h-[300px] pe-2'>
                    <table class="min-w-full table-auto border-collapse" id="treatments-table">
                      <thead>
                        <tr class='border-b border-gray-300'>
                          <th class="py-3 text-gray-600 text-start pe-3">ID</th>
                          <th class="py-3 text-gray-600 text-start pe-3">Treatment</th>
                        </tr>
                      </thead>
                      <tbody class="">
                        <tr class='border-b border-gray-200'>
                          <td class='py-3 pe-3 text-gray-600 font-medium'>1</td>
                          <td class='py-3 pe-3 text-gray-500 w-1/2'>Test treatment</td>
                          <td class="text-end"><button class="underline text-blue-500">edit</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </details>


            <hr />
            <!-- 
              LABORATORIES SETTINGS
              laboratories-container
              laboratories-add
              laboratories-search-input
              laboratories-search-button
              laboratories-table
            -->

            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Manage Laboratories</summary>
              <div class="px-3 pb-5">
                <div class='w-full' id="laboratories-container">
                  <div class="flex pt-5 gap-5 pb-5">
                    <div class='w-[50%]'>
                      <h1 class='font-medium text-xl text-gray-700 pb-2'>Laboratories Templates Management</h1>
                      <p class='text-gray-500'>Manage, Create, and Delete templates for Clinic form's Laboratory Suggestions.</p>
                    </div>
                    <div class='w-[50%] flex flex-col justify-between gap-3'>
                      <div class='flex justify-end gap-3'>
                        <button id='laboratories-add' type="button" class="bg-blue-600 px-3 py-2 rounded text-gray-200">
                          New laboratory
                        </button>
                      </div>
                      <div class='flex gap-3'>
                        <input id='laboratories-search-input' type="text" placeholder="Search..." class="flex-grow px-3 py-2 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" />
                        <button id='laboratories-search-button' type="button" class="bg-blue-600 px-3 py-2 rounded">
                          <svg class="w-4 h-4 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class='overflow-scroll max-h-[300px] pe-2'>
                    <table class="min-w-full table-auto border-collapse" id="laboratories-table">
                      <thead>
                        <tr class='border-b border-gray-300'>
                          <th class="py-3 text-gray-600 text-start pe-3">ID</th>
                          <th class="py-3 text-gray-600 text-start pe-3">Laboratory</th>
                        </tr>
                      </thead>
                      <tbody class="">
                        <tr class='border-b border-gray-200'>
                          <td class='py-3 pe-3 text-gray-600 font-medium'>1</td>
                          <td class='py-3 pe-3 text-gray-500 w-1/2'>Test laboratory</td>
                          <td class="text-end"><button class="underline text-blue-500">edit</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </details>

            <hr />
            <!-- 
              STORAGES SETTINGS
              storages-container
              storages-add
              storages-search-input
              storages-search-button
              storages-table
            -->

            <details class="p-2">
              <summary class="font-medium text-gray-600 text-lg">Manage Storages</summary>
              <div class="px-3 pb-5">
                <div class='w-full' id="storages-container">
                  <div class="flex pt-5 gap-5 pb-5">
                    <div class='w-[50%]'>
                      <h1 class='font-medium text-xl text-gray-700 pb-2'>Storages Templates Management</h1>
                      <p class='text-gray-500'>Manage, Create, and Delete templates for Add medicine form's Storages.</p>
                    </div>
                    <div class='w-[50%] flex flex-col justify-between gap-3'>
                      <div class='flex justify-end gap-3'>
                        <button id='storages-add' type="button" class="bg-blue-600 px-3 py-2 rounded text-gray-200">
                          New storage
                        </button>
                      </div>
                      <div class='flex gap-3'>
                        <input id='storages-search-input' type="text" placeholder="Search..." class="flex-grow px-3 py-2 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md hover:ring-gray-400 focus:ring-gray-400" />
                        <button id='storages-search-button' type="button" class="bg-blue-600 px-3 py-2 rounded">
                          <svg class="w-4 h-4 text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class='overflow-scroll max-h-[300px] pe-2'>
                    <table class="min-w-full table-auto border-collapse" id="storages-table">
                      <thead>
                        <tr class='border-b border-gray-300'>
                          <th class="py-3 text-gray-600 text-start pe-3">ID</th>
                          <th class="py-3 text-gray-600 text-start pe-3">Storage</th>
                        </tr>
                      </thead>
                      <tbody class="">
                        <tr class='border-b border-gray-200'>
                          <td class='py-3 pe-3 text-gray-600 font-medium'>1</td>
                          <td class='py-3 pe-3 text-gray-500 w-1/2'>Test storage</td>
                          <td class="text-end"><button class="underline text-blue-500">edit</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </details>
            <hr />
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
  <script type="module" src="/src/js/pages/settings.js"></script>
</body>

</html>