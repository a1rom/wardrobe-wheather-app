<div>
    {{-- 🔎 Search --}}
    <div class="px-2 sm:px-0 flex justify-center relative">
        <div class="relative w-full sm:w-3/4 md:w-3/4 lg:w-1/2">
            <input 
                type="text" 
                name="location_search" 
                id="location_search"
                @class([
                    'w-full rounded-md py-1.5 shadow-sm ring-1 ring-inset focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6 placeholder:text-gray-400', 
                    'border-0 ring-gray-300 focus:ring-teal-600 text-gray-900' => !$errors->has('locationSearch'),
                    'border border-red-400 ring-red-300 focus:ring-red-300 text-red-600' => $errors->has('locationSearch'),
                ])
                placeholder="Enter your location"
                wire:model.defer="locationSearch"
            >
            @if($errors->has('locationSearch'))
                <p class="absolute left-0 mt-2 px-2 text-sm text-red-600">
                    {{ $errors->first('locationSearch') }}  
                </p>
            @endif
        </div>
        
        <button 
            type="button" 
            class="ml-2 inline-flex justify-center py-2 px-4 border-0 border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-600"
            wire:click="search"
        > 
            Search 
        </button>
    </div>

    {{-- 💁 Info --}}
    <div class="mx-6 mt-12">
        <h3 class="text-base font-semibold leading-6 text-gray-900">
            {{ $location }}
        </h3>
        <div class="mt-5 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-3 md:divide-x md:divide-y-0">
        
          <x-weather.card 
            date="2023-11-16"
            temperature="27 C"
            description="Windy" />
          <x-weather.card 
            date="2023-11-16"
            temperature="27 C"
            description="Windy" />
          <x-weather.card 
            date="2023-11-16"
            temperature="27 C"
            description="Windy" />
        </div>
    </div>
</div>
