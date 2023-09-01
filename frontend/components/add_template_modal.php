<!-- 
  ID modal:
    add-title
    add-type
    add-description
    add-message
    add-cancel
    add-submit
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
    <div class='pt-6 px-6 pb-3 bg-gray-100 rounded-md max-h-[90%] w-[90%] max-w-[600px] flex flex-col'>
        <!-- HEADER -->
        <h1 class='text-2xl font-medium text-gray-600 mb-3' id='add-title'>Add complaint</h1>
        <!-- BODY -->
        <input type="hidden" id='add-type'>
        <div class='flex flex-col'>
            <p class='text-gray-500 font-medium mb-1'>Description <span class='text-red-500'>*</span></p>
            <input id='add-description' autocomplete="off" type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="enter description...">
        </div>

        <div class='flex justify-end gap-3 mt-5'>
            <div class='flex-grow ps-2'>
                <p class='text-red-500 text-sm' id='add-message'></p>
            </div>
            <button id='add-cancel' class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" type='button'>Cancel</button>
            <button id='add-submit' class="rounded-md text-gray-200 bg-blue-600 hover:bg-blue-500 px-3 font-medium py-2" type='button'>Add</button>
        </div>
    </div>
</div>