<div class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none justify-center items-center" id="modal-id">
  <div class="relative w-auto my-6 mx-auto max-w-3xl">
    <!--content-->
    <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
      <!--header-->
      <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t bg-green-200">
        <h3 class="text-3xl font-semibold text-lime-950">
          Emergency No.
        </h3>
        <button class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none" onclick="toggleModal('modal-id')">
          <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
            ×
          </span>
        </button>
      </div>
      <!--body-->
      <div class="relative p-6 flex-auto">
        <ul>
          <li class="p-2">
            <h1 class="font-serif text-xl font-bold">Hagonoy Rescue Hotline</h1>
            <p class="font-normal">793-5811</p>
          </li>
          <hr>
          <li class="p-2">
            <h1 class="font-serif text-xl font-bold">BFP R3 Hagonoy,Bulacan</h1>
            <p class="font-normal">(044) 793-2018</p>
            <p class="font-normal">0915-029-5184</p>
          </li>
          <hr>
          <li class="p-2">
            <h1 class="font-serif text-xl font-bold">Perez Hospital</h1>
            <p class="font-normal">+63(44) 793-0092</p>
          </li>
          <hr>
          <li class="p-2">
            <h1 class="font-serif text-xl font-bold">Hagonoy, Bulacan Municipal Station</h1>
            <p class="font-normal">(044) 794-6123</p>
            <p class="font-normal">0998-598-5382</p>
          </li>
        </ul>

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