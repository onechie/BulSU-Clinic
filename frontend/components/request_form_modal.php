<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
  <div class='pt-6 px-6 pb-3 bg-gray-100 rounded-md'>
    <!-- HEADER -->
    <h1 class='text-2xl font-medium text-gray-600 mb-3'>Clinic Request Form</h1>
    <!-- BODY -->
    <div class='grid lg:grid-cols-4 grid-cols-3 gap-3'>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>School year <span class='text-red-500'>*</span></p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="e.g 2024">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Patient's name <span class='text-red-500'>*</span></p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Enter patient's name">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Date entry <span class='text-red-500'>*</span></p>
        <input type="date" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400'>
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Complaint <span class='text-red-500'>*</span></p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="complaintsList" placeholder="Patient complaint">
        <datalist id='complaintsList'>
          <option value="Complaint 001"></option>
          <option value="Complaint 002"></option>
          <option value="Complaint 003"></option> 
        </datalist>
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Medications <span class='text-red-500'>*</span></p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="medicinesList" placeholder="Select medicine">
        <datalist id='medicinesList'>
          <option value="Medicine 001"></option>
          <option value="Medicine 002"></option>
          <option value="Medicine 003"></option>
        </datalist>
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Quantity <span class='text-red-500'>*</span></p>
        <input type="number" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0'>
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Treatment</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="treatmentsList" placeholder="Patient treatment">
        <datalist id='treatmentsList'>
          <option value="Treatment 001"></option>
          <option value="Treatment 002"></option>
          <option value="Treatment 003"></option>
        </datalist>
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Laboratory</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="laboratoriesList" placeholder="Patient test">
        <datalist id='laboratoriesList'>
          <option value="Laboratory 001"></option>
          <option value="Laboratory 002"></option>
          <option value="Laboratory 003"></option>
        </datalist>
      </div>
    </div>
    <h1 class='text-gray-600 font-medium text-xl pt-4 pb-3'>Vital signs</h1>
    <div class='grid lg:grid-cols-4 grid-cols-3 gap-3'>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Blood pressure</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient blood pressure">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Pulse</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient pulse rate">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Weight</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient weight">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Temperature</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient temperature">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Respiration</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient respiration">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Oximetry</p>
        <input type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 hover:ring-gray-400' placeholder="Patient oximetry">
      </div>
      <div class='flex flex-col'>
        <p class='text-gray-500 font-medium mb-1'>Attachments</p>
        <label for="fileInput" class="px-3 py-1 text-gray-500 rounded-md cursor-pointer bg-white hover:bg-gray-200 ring-1 ring-gray-300">
          Upload attachments
        </label>
        <input type="file" class='sr-only' multiple id='fileInput'>
      </div>
    </div>
    <!-- FOOTER -->

    <div class='flex justify-end gap-3 mt-5'>
      <button class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2">Cancel</button>
      <button class="rounded-md text-gray-200 bg-blue-600 hover:bg-blue-500 px-3 font-medium py-2">Create record</button>
    </div>
  </div>
</div>