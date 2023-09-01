<!-- 
  ID modal:
    showLogAction
    showLogDateTime
    showLogUser
    showLogDescription
    showLogClose
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
    <div class='pt-6 px-6 pb-3 bg-gray-100 rounded-md max-h-[90%] w-[90%] max-w-[800px] flex flex-col'>
        <!-- HEADER -->
        <h1 class='text-2xl font-medium text-gray-600 mb-3'>Activity Details</h1>
        <!-- BODY -->
        <div class='overflow-y-auto p-2'>
            <div class='flex flex-col gap-5'>
                <div class='grid grid-cols-2 md:grid-cols-3 gap-x-3'>
                    <h1 class='text-gray-500 font-medium'>Action</h1>
                    <p id='showLogAction' class='text-gray-500 md:col-span-2'>Add Medicine</p>
                    <h1 class='text-gray-500 font-medium'>Date and Time</h1>
                    <p id='showLogDateTime' class='text-gray-500 md:col-span-2'>0000-00-00 00:00:00</p>

                </div>
                <div class='grid grid-cols-2 md:grid-cols-3 gap-x-3'>
                    <h1 class='text-gray-500 font-medium'>Description</h1>
                    <p id='showLogDescription' class='text-gray-500 md:col-span-2'>This is description.</p>
                </div>
                <div class='grid grid-cols-2 md:grid-cols-3 gap-x-3'>
                    <h1 class='text-gray-500 font-medium'>User</h1>
                    <p id='showLogUser' class='text-gray-500 md:col-span-2'>nurse001</p>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <div class='flex justify-end gap-3 mt-5'>
            <button class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" id='showLogClose' type='button'>Close</button>
        </div>
    </div>
</div>