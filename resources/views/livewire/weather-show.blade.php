<div x-data="{ weatherShow: false}"
    x-init="Livewire.on('weatherFetched', data => {
        weatherShow = true;
    })">
    {{-- 🔎 Search --}}
    <div class="px-2 sm:px-0 flex justify-center relative">
        <div class="w-full sm:w-3/4 md:w-3/4 lg:w-1/2">
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
            wire:loading.class="cursor-not-allowed opacity-50"
            wire:loading.attr="disabled"
        > 
            Search 
        </button>

        <div 
            wire:loading wire:target="search" 
            class="absolute -bottom-48">

            <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-sky-600 self-center"></div>
        </div>
    </div>


    @if($errors->has('technicalIssue'))
        <p class="mt-2 px-2 text-base text-red-600">
            {{ $errors->first('technicalIssue') }}  
        </p>
    @endif

    {{-- 💁 Info --}}
    <div x-show="weatherShow" x-cloak 
        wire:loading.remove wire:target="search" 
        class="py-8 px-2 sm:px-8 md:px-16 lg:px-32">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6">
            <div class="flex items-center justify-center">
                <div class="items-center flex flex-col md:flex-row md:justify-center">
                    <div class="w-64 h-64 bg-white rounded-lg border shadow flex flex-col gap-y-2 justify-center items-center text-center p-6">
                        <div class="text-md font-bold flex flex-col text-gray-900">
                            <span class="uppercase">
                                {{ data_get($weather, 'location.name') }}
                            </span>
                            
                            <span class="font-normal text-gray-700 text-sm">
                                {{ data_get($weather, 'location.localtime') }}
                            </span>
                        </div>
                        
                        <div class="w-32 h-16 flex items-center justify-center">
                            <img src="{{ data_get($weather, 'current.weather_icons.0') }}"/>
                        </div>
                        
                        <p class="text-gray-700">
                            {{ data_get($weather, 'current.weather_descriptions.0') }}
                        </p>
            
                        <div class="text-3xl font-bold text-gray-900">
                            {{ data_get($weather, 'current.temperature') }}
                            {{ config(sprintf('weather.%s.temperature', $units)) }}
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div class="flex flex-col gap-1 text-sm text-gray-900">
                                <div>
                                    Wind
                                </div>
                                <div>
                                    {{ data_get($weather, 'current.wind_speed') }} 
                                    {{ config(sprintf('weather.%s.speed', $units)) }}
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 text-sm text-gray-900">
                                <div>
                                    Direction
                                </div>
                                <div>
                                    {{ data_get($weather, 'current.wind_dir') }}
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 text-sm text-gray-900">
                                <div>
                                    Humidity
                                </div>
                                <div>
                                    {{ data_get($weather, 'current.humidity') }} %
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center">
                <div class="items-center flex flex-col md:flex-row md:justify-center">
                    <div class="w-64 h-64 bg-white rounded-lg border shadow flex flex-col gap-y-2 justify-center items-center text-center p-6">
                        <div class="text-md font-bold flex flex-col text-gray-900">
                            <span class="uppercase">
                                Best choice
                            </span>
                        </div>

                        @foreach ($wardrobeSuggestions as $key => $suggestions)
                        <p class="text-gray-700">
                            {{ ucfirst($key) }}: 
                            @foreach($wardrobeSuggestions[$key] as $item)
                                @if($loop->last && !$loop->first)
                                    or
                                @endif
                                {{ $item }} 
                                @if(!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
