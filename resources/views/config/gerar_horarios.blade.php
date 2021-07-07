<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Gerar horários') }}
                </h2>

            </div>
        </div>
    </x-slot>

    <div class="container" style="margin-top: 40px;">

        <div class="list-group">
            @foreach ($postos as $posto)
                <a href="#" class="list-group-item list-group-item-action">{{ $posto->nome }}</a>
            @endforeach
        </div>

    </div>
</x-app-layout>
