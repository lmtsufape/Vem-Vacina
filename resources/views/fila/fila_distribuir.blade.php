<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-10">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Espera') }}
                </h2>
            </div>
            <div class="col-md-2" style="text-align: right">

                @can('ver-fila')
                    <a href="{{ route('fila.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Voltar') }}
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <livewire:fila-distribuir/>

</x-app-layout>

