<!-- 
  ID modal:
    viewHistoryName
    viewHistoryTable
    viewHistoryClose
 -->

<div class='fixed h-[100vh] w-[100vw] bg-gray-500 bg-opacity-75 z-100 top-0 left-0 flex justify-center items-center'>
    <div class='pt-6 px-6 pb-3 bg-gray-100 rounded-md w-[90%] max-w-[1200px] max-h-[90%] overflow-y-auto flex flex-col'>
        <!-- HEADER -->
        <h1 class='text-2xl font-medium text-gray-600 mb-3'>Patient name: <span class='text-gray-500' id='viewHistoryName'></span></h1>
        <!-- BODY -->
        <div class='overflow-auto p-2 '>
            <table class='table-auto border-collapse w-full min-w-[600px]' id='viewHistoryTable'>
                <thead class="">
                    <tr class='border-b border-gray-300'>
                        <th class='py-3 text-gray-600 text-start pe-3'>Date of entry </th>
                        <th class='py-3 text-gray-600 text-start pe-3'>Complaint</th>
                        <th class='py-3 text-gray-600 text-start pe-3'>Medication</th>
                    </tr>
                </thead>
                <tbody class="">
                    <tr class='border-b border-gray-200'>
                        <td class='py-3 text-gray-500'>00-00-0000</td>
                        <td class='py-3 text-gray-500'>Complaint</td>
                        <td class='py-3 text-gray-500'>Medicine</td>
                        <td class="max-w-[35px]"><button class="underline text-blue-500">see attachments</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- FOOTER -->
        <div class='flex justify-end gap-3 mt-5'>
            <button class="ring-1 ring-inset ring-gray-300 rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 px-3 font-medium py-2" id='viewHistoryClose' type='button'>Close</button>
        </div>
    </div>
</div>