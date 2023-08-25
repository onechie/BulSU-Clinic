<!-- 
  ID modal:
    seeAttachmentsName
    seeAttachmentsComplaint
    seeAttachmentsMedication
    seeAttachmentsTreatment
    seeAttachmentsLaboratory
    seeAttachmentsBloodPressure
    seeAttachmentsPulse
    seeAttachmentsWeight
    seeAttachmentsTemperature
    seeAttachmentsRespiration
    seeAttachmentsOxygenSaturation
    seeAttachmentsFiles
    seeAttachmentClose
    seeAttachmentsAdd
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
    <div class='pt-6 px-6 pb-3 bg-gray-100 rounded-md max-h-[90%] w-[90%] max-w-[800px] flex flex-col'>
        <!-- HEADER -->
        <h1 class='text-xl font-medium text-gray-600 mb-3'>Patient name: <span class='text-gray-500' id='seeAttachmentsName'>test name</span></h1>
        <!-- BODY -->
        <div class='overflow-y-auto p-2'>
            <div class='flex flex-col gap-5'>
                <div>
                    <h1 class='text-gray-600 font-medium text-lg pb-3'>Findings</h1>
                    <div class='grid grid-cols-2 md:grid-cols-3 gap-x-3'>
                        <h1 class='text-gray-500 font-medium'>Complaint</h1>
                        <p id='seeAttachmentsComplaint' class='text-gray-500 md:col-span-2'>Acid Reflux</p>
                        <h1 class='text-gray-500 font-medium'>Medication</h1>
                        <p id='seeAttachmentsMedication' class='text-gray-500 md:col-span-2'>Omeprazole 40mg</p>
                        <h1 class='text-gray-500 font-medium'>Treatment</h1>
                        <p id='seeAttachmentsTreatment' class='text-gray-500 md:col-span-2'>Rest and give some medicine</p>
                        <h1 class='text-gray-500 font-medium'>Laboratory</h1>
                        <p id='seeAttachmentsLaboratory' class='text-gray-500 md:col-span-2'>None</p>
                    </div>
                </div>
                <div>
                    <h1 class='text-gray-600 font-medium text-lg pb-3'>Vital signs</h1>
                    <div class='grid grid-cols-2 md:grid-cols-3 gap-x-3'>
                        <h1 class='text-gray-500 font-medium'>Blood pressure</h1>
                        <p id='seeAttachmentsBloodPressure' class='text-gray-500 md:col-span-2'>value</p>
                        <h1 class='text-gray-500 font-medium'>Pulse</h1>
                        <p id='seeAttachmentsPulse' class='text-gray-500 md:col-span-2'>value</p>
                        <h1 class='text-gray-500 font-medium'>Weight</h1>
                        <p id='seeAttachmentsWeight' class='text-gray-500 md:col-span-2'>value</p>
                        <h1 class='text-gray-500 font-medium'>Temperature</h1>
                        <p id='seeAttachmentsTemperature' class='text-gray-500 md:col-span-2'>value</p>
                        <h1 class='text-gray-500 font-medium'>Respiration</h1>
                        <p id='seeAttachmentsRespiration' class='text-gray-500 md:col-span-2'>value</p>
                        <h1 class='text-gray-500 font-medium'>Oxygen saturation</h1>
                        <p id='seeAttachmentsOxygenSaturation' class='text-gray-500 md:col-span-2'>value</p>
                    </div>
                </div>
                <div>
                    <h1 class='text-gray-600 font-medium pb-1'>Attachments</h1>
                    <div class='grid grid-cols-2 md:grid-cols-3 gap-3' id='seeAttachmentsFiles'>
                        <div class="px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200">No attachments</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FOOTER -->
        <div class='flex justify-end gap-3 mt-5'>
            <button class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" id='seeAttachmentsClose' type='button'>Close</button>
            <button class="rounded-md text-gray-200 bg-blue-600 hover:bg-blue-500 px-3 font-medium py-2" id='seeAttachmentsAdd'>Add attachment</button>
        </div>
    </div>
</div>