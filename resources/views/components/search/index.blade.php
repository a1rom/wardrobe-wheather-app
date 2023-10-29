<div class="px-2 sm:py-0 flex justify-center">
    <input 
        type="text" 
        name="location" 
        id="location" 
        class="w-full sm:w-3/4 md:w-3/4 lg:w-1/2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-teal-600 sm:text-sm sm:leading-6" 
        placeholder="Enter your location"
    >

    <button 
        type="button" 
        class="ml-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-600"
        wire:click="search"
    > 
        Search 
    </button>
</div>