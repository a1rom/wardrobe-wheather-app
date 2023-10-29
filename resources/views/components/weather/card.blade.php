@props([
    'date',
    'temperature',
    'description',
])

<div class="px-4 py-5 sm:p-6">
    <div class="text-base font-normal text-gray-900">
        {{ $date }}
    </div>

    <div class="mt-1 flex items-baseline justify-between md:block lg:flex">
        <div class="flex items-baseline text-2xl font-semibold text-sky-600">
            {{ $temperature }}
            <span class="ml-2 text-sm font-medium text-gray-500">
                {{ $description }}
            </span>
        </div>

        <div>
            <svg class="-ml-1 mr-0.5 h-5 w-5 flex-shrink-0 self-center text-sky-500" viewBox="0 0 20 20"
                fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </div>
</div>