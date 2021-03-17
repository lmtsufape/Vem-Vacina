<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar uma nova etapa') }}
        </h2>
    </x-slot>

    <form action="{{route('etapas.store')}}" method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <label for="faixa_etaria">Faixa etária</label>
                    <input id="faixa_etaria" type="number" name="">
                </div>
            </div>
        </div>
    </form>
</x-app-layout>