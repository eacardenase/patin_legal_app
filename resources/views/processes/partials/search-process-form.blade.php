<section class="space-y-6">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'search-process')"
    >{{ __('Add Process') }}</x-primary-button>

    <x-modal name="search-process" focusable>
        <form method="post" action="/processes" class="p-6">
            @csrf

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Search process') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Aliquip fugiat proident eiusmod aute cupidatat. Tempor labore cupidatat enim laborum velit occaecat. Qui laboris incididunt voluptate incididunt magna mollit commodo eu eu laborum. Cupidatat deserunt anim do pariatur veniam eiusmod irure laborum cillum dolor fugiat mollit ea.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="process" class="sr-only" />

                <x-text-input
                    id="process"
                    name="process"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Ingrese los 23 dígitos del número de Radicación') }}"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Save Process') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</section>