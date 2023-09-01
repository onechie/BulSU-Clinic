<!-- 
  ID modal:
    addAttachmentsForm
    addAttachmentsList
    addAttachmentsUpload
    addAttachmentsMessage
    addAttachmentsCancel
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
    <form class='pt-6 px-6 pb-3 bg-gray-100 rounded-md max-h-[90%] w-[90%] max-w-[600px] flex flex-col' id='addAttachmentsForm' enctype="multipart/form-data" novalidate>
        <!-- HEADER -->
        <h1 class='text-2xl font-medium text-gray-600 mb-3'>Add attachments</h1>
        <!-- BODY -->
        <div class="overflow-y-auto p-2">
            <input type="hidden" name='recordId'>
            <div class='grid grid-cols-2 md:grid-cols-3 gap-3 pb-3' id='addAttachmentsList'>
                <div class="px-3 py-2 rounded-md text-gray-600 outline-none ring-1 ring-gray-300 hover:cursor-pointer hover:bg-gray-200">No attachments</div>
            </div>
            <div class='flex'>
                <label for="addAttachmentsUpload" class="px-3 py-1 text-gray-500 font-medium bg-gray-100 rounded-md cursor-pointer hover:bg-gray-200 ring-1 ring-gray-300">
                    Upload
                </label>
                <input id="addAttachmentsUpload" name='attachments[]' type="file" class='sr-only' multiple>
            </div>
        </div>

        <div class='flex justify-end gap-3 mt-5'>
            <div class='flex-grow ps-2'>
                <p class='text-red-500 text-sm' id='addAttachmentsMessage'></p>
            </div>
            <button id='addAttachmentsCancel' class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" type='button'>Cancel</button>
            <button class="rounded-md text-gray-200 bg-blue-600 hover:bg-blue-500 px-3 font-medium py-2" type='submit'>Submit</button>
        </div>
    </form>
</div>