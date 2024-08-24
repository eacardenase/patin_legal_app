@props(['processes'])

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        @include('processes.partials.search-process-form')
                    </div>
                @if ($processes->count())
                    @include('processes.index', ['processes' => $processes])
                @else
                    <p class="text-center">No processes yet, please add one!</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
