@props(['id' => null, 'maxWidth' => null])

<x-report :id="$id" :maxWidth="$maxWidth" {{ $attributes }} >
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900 text-center">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-gray-600">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 text-end">
        {{ $footer }}
    </div>
</x-report>
