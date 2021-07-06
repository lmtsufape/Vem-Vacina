<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Horários') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="container" style="padding-top: 20px;">
        <form action="{{ route('horarios.index') }}" method="get">
            <select class="custom-select" name="posto[]" multiple>
                @foreach ($todosPosto as $posto)
                    <option value="{{ $posto->id }}" >{{ $posto->nome }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary mt-1">
                Ver
            </button>

        </form>
        <br>
        <div class="row">
            <div class="col">
                @include('horarios.collapse_dia')
            </div>
        </div>
    </div>
</x-app-layout>
