<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Espera') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <livewire:fila-distribuir/>

</x-app-layout>

