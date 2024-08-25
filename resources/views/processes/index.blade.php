@props(['processes'])

<div class="-my-2 overflow-x-auto pt-6 sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="divide-y divide-gray-200">
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($processes as $process)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="/processes/{{ $process->id }}">
                                        {{ $process->ponente }}
                                    </a>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ date('d-m-Y', strtotime($process->ultima_actualizacion)) }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                <a href="/processes/{{ $process->id }}">
                                    {{ __('Show') }}
                                </a>
                            </x-secondary-button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="/processes/{{ $process->id }}" method="post">
                                @csrf
                                @method('delete')

                                <x-danger-button>
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </form>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $processes->links() }}
        </div>
    </div>
</div>