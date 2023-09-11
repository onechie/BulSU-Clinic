<!-- 
  ID inputs:
    addRecordAttachments
    
  ID modal:
    complaintsList
    medicinesList
    medicinesStock
    treatmentsList
    laboratoriesList
    addRecordForm
    addRecordMessage
    addRecordCancel
    addRecordFileList
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
  <form class='pt-6 px-6 pb-3 bg-gray-100 rounded-md max-h-[90%] flex flex-col' id='addRecordForm' enctype="multipart/form-data" autocomplete="off">
    <!-- HEADER -->
    <h1 class='text-2xl font-medium text-gray-600 mb-3'>Clinic Request Form</h1>
    <!-- BODY -->
    <div class="overflow-y-auto p-2">
      <h1 class='text-gray-500 mb-3'>All fields with asterisk '*' are required.</h1>
      <div class='grid lg:grid-cols-4 grid-cols-3 gap-3'>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>School year <span class='text-red-500'>*</span></p>
          <input name='schoolYear' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="e.g 2024">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Patient's name <span class='text-red-500'>*</span></p>
          <input name='name' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Enter patient's name">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Date entry <span class='text-red-500'>*</span></p>
          <input name='date' type="date" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400'>
        </div>
        <div class="flex flex-col">
          <p class='text-gray-500 font-medium mb-1'>Patient type <span class='text-red-500'>*</span></p>
          <select name="type" class="text-gray-500 outline-none px-3 py-1 ring-1 ring-gray-300 rounded-md h-full focus:ring-gray-400 hover:ring-gray-400">
            <option value="" selected>select patient type</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
            <option value="staff">Staff</option>
          </select>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Complaint <span class='text-red-500'>*</span></p>
          <input name='complaint' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="complaintsList" placeholder="Patient complaint">
          <datalist id='complaintsList'>
            <option value="Complaint 001"></option>
            <option value="Complaint 002"></option>
            <option value="Complaint 003"></option>
          </datalist>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Medications <span class='text-red-500'>*</span></p>
          <input name='medication' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="medicinesList" placeholder="Select medicine">
          <datalist id='medicinesList'>
            <option value="Medicine 001"></option>
            <option value="Medicine 002"></option>
            <option value="Medicine 003"></option>
          </datalist>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Quantity <span class='text-red-500'>*</span> <span class='text-gray-400 font-normal'>(stock: <span id='medicinesStock'>0</span>)</span></p>
          <input name='quantity' type="number" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' value='0' disabled>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Treatment</p>
          <input name='treatment' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="treatmentsList" placeholder="Patient treatment">
          <datalist id='treatmentsList'>
            <option value="Treatment 001"></option>
            <option value="Treatment 002"></option>
            <option value="Treatment 003"></option>
          </datalist>
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Laboratory</p>
          <input name='laboratory' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' list="laboratoriesList" placeholder="Patient test">
          <datalist id='laboratoriesList'>
            <option value="Laboratory 001"></option>
            <option value="Laboratory 002"></option>
            <option value="Laboratory 003"></option>
          </datalist>
        </div>
      </div>
      <h1 class='text-gray-600 font-medium text-lg pt-4 pb-3'>Vital signs</h1>
      <div class='grid lg:grid-cols-4 grid-cols-3 gap-3'>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Blood pressure</p>
          <input name='bloodPressure' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient blood pressure">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Pulse</p>
          <input name='pulse' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient pulse rate">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Weight</p>
          <input name='weight' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient weight">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Temperature</p>
          <input name='temperature' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient temperature">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Respiration</p>
          <input name='respiration' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400' placeholder="Patient respiration">
        </div>
        <div class='flex flex-col'>
          <p class='text-gray-500 font-medium mb-1'>Oximetry</p>
          <input name='oximetry' type="text" class='px-3 py-1 outline-none text-gray-500 ring-1 ring-gray-300 rounded-md focus:ring-gray-400 hover:ring-gray-400 hover:ring-gray-400' placeholder="Patient oximetry">
        </div>

      </div>
      <!-- FOOTER -->
      <h1 class='text-gray-600 font-medium pt-4 pb-1'>Attachments</h1>
      <div class='grid grid-cols-2 md:grid-cols-3 gap-3 pb-3' id='attachmentsList'>
        <div class="px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200">No attachments</div>
      </div>
      <div class='flex'>
        <label for="addRecordAttachments" class="px-3 py-1 text-gray-500 font-medium bg-gray-100 rounded-md cursor-pointer hover:bg-gray-200 ring-1 ring-gray-300">
          Upload
        </label>
        <input id="addRecordAttachments" name='attachments[]' type="file" class='sr-only' multiple>
      </div>
    </div>

    <div class='flex justify-end gap-3 mt-5'>
      <div class='flex-grow ps-2'>
        <p class='text-red-500 text-sm' id='addRecordMessage'></p>
      </div>
      <button id='addRecordCancel' class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" type='button'>Cancel</button>
      <button class="rounded-md text-gray-200 bg-blue-600 hover:bg-blue-500 px-3 font-medium py-2" type='submit'>Create record</button>
    </div>
  </form>
</div>