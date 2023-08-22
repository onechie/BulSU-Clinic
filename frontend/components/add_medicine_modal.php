<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center" id="modal-id">
  <div class="relative w-3/4 my-6 mx-auto min-w-fit">
    <!--content-->
    <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
      <!--header-->
      <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t bg-green-200">
        <h3 class="text-3xl font-semibold text-lime-950">
          Add New Medicine.
        </h3>
        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id')">
          <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
            ×
          </span>
        </button>
      </div>
      <!--body-->
      <div class="relative p-3">

        <div class="grid gap-4 sm:grid-cols-2 md:grid-flow-row sm:gap-6">
          <!-- BRAND -->
          <div class="w-full">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Brand</label>
            <input type="text" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Brand" required="">
          </div>
          <!-- NAME -->
          <div class="w-full">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name of Medicine</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Name of medicine" required="">
          </div>
          <!-- NUMBER OF BOX -->
          <div class="w-full">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number of Boxs</label>
            <input type="number" id="boxesCount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required="">
          </div>

          <!-- HOW MANY PCS PER BOXS -->
          <div>
            <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">How many pcs per boxs?</label>
            <input type="number" id="itemsPerBox" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="0" required="">
          </div>
          <!-- UNIT -->
          <div>
            <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit</label>
            <input type="text" id="unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Unit of Medicine" required="">
          </div>
          <!-- ITEMS COUNT -->
          <div>
            <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Items count</label>
            <input type="number" id="itemsCount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500dark:focus:border-primary-500" placeholder="0" required="">
          </div>
          <!-- EXPIRATION -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Expiration</label>
            <input type="date" id="expiration" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Expiration" required="">
          </div>
          <!-- STORAGE -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Storage</label>
            <div class="relative">
              <select name="storage" id="storageSuggestions" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value=" " selected>Select Storage</option>
              </select>
            </div>
          </div>
        </div>
        </br>
        <button type="button" onclick="(createMedicine())" class="w-30 text-white bg-lime-950 hover:bg-lime-900 focus:ring-4 focus:outline-none focus:ring-primary-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-lime-900 dark:hover:bg-lime-900 dark:focus:ring-primary-800">Save
        </button>
        <p id="inventoryMessage" class="message"></p>
      </div>

      <!--footer-->
      <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
        <button class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" onclick="toggleModal('modal-id')">
          Close
        </button>
      </div>
    </div>
  </div>
</div>
<div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="modal-id-backdrop"></div>