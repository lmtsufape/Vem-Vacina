<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __( 'Lote: '.$lote->numero_lote ) }}
                    {{ __( ' - Fabricante: '.$lote->fabricante ) }}
                </h2>
            </div>
            <div class="...">
            </div>
          </div>
    </x-slot>

    <livewire:distribuir :lote="$lote" :postos="$postos" />

</x-app-layout>
