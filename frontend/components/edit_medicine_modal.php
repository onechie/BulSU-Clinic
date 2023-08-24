<!-- 
  ID modal:
    editMedicineStoragesList
    editMedicineForm
    editMedicineMessage
    editMedicineCancel
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
  <form class='pt-6 px-6 pb-3 bg-gray-100 rounded-md max-h-[90%] flex flex-col' id='editMedicineForm' enctype="multipart/form-data" novalidate>
    <!-- HEADER -->
    <h1 class='text-2xl font-medium text-gray-600 mb-3'>Edit medicine</h1>
    <!-- BODY -->
    <div class="overflow-y-auto p-2">
      <h1 class='text-gray-500 mb-3'>All fields are required.</h1>
      <div class='grid md:grid-cols-3 grid-cols-2 gap-3'>
        <input type="hidden" name='id'>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Name <span class='text-red-500'>*</span></p>
          <input type="text" name='name' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Medicine name">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Brand <span class='text-red-500'>*</span></p>
          <input type="text" name='brand' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="brand">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Unit <span class='text-red-500'>*</span></p>
          <input type="text" name='unit' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="unit">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Expiration <span class='text-red-500'>*</span></p>
          <input type="date" name='expiration' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400'>
        </div>

        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Count of boxes <span class='text-red-500'>*</span></p>
          <input type="number" name='boxesCount' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0'>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Items per box <span class='text-red-500'>*</span></p>
          <input type="number" name='itemsPerBox' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0'>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Total items <span class='text-red-500'>*</span></p>
          <input type="number" name='itemsCount' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0'>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Dispensed</p>
          <input type="number" name='itemsDeducted' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0' disabled>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Remaining</p>
          <input type="number" name='itemsRemaining' class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0' disabled>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Storage <span class='text-red-500'>*</span></p>
          <input type="text" name='storage' autocomplete="off" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="editMedicineStoragesList" placeholder="Select storage">
          <datalist id='editMedicineStoragesList'>
            <option value="Storage 001"></option>
            <option value="Storage 002"></option>
            <option value="Storage 003"></option>
          </datalist>
        </div>
      </div>
    </div>
    <!-- FOOTER -->
    <div class='flex justify-end gap-3 mt-3'>
      <div class='flex-grow ps-2'>
        <p class='text-red-500 text-sm' id='editMedicineMessage'></p>
      </div>
      <button class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" id='editMedicineCancel' type='button'>Cancel</button>
      <button class="rounded-md text-gray-200 bg-blue-600 hover:bg-blue-500 px-3 font-medium py-2" type='submit'>Edit medicine</button>
    </div>
  </form>
</div>