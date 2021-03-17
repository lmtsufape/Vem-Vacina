<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-9">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Etapas') }}
                </h2>
            </div>
            
            <div class="col-md-3" style="text-align: right;">
                <a href="{{route('etapas.create')}}">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Adicionar etapa
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container" style="margin-top: 30px;">
        @if(session('mensagem'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <p>{{session('mensagem')}}</p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>