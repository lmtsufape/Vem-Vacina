<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Exportar dados') }}
                </h2>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="container">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="list-group">
                        @can('baixar-export')
                            <a href="{{ route('export.candidato') }}" class="list-group-item list-group-item-action">
                                Exportar candidatos <span class="badge badge-success">{{ $candidatos }}</span>
                            </a>
                            <a href="{{ route('export.lote') }}" class="list-group-item list-group-item-action">
                                Exportar Lotes <span class="badge badge-success">{{ $lotes }}</span>
                            </a>
                            <a href="{{ route('export.posto') }}" class="list-group-item list-group-item-action">
                                Exportar Postos <span class="badge badge-success">{{ $qtd_postos }}</span>
                            </a>
                            @foreach ($postos as $posto)
                            <a href="{{ route('export.exportPostoCandidato', ['id' => $posto->id]) }}" class="list-group-item list-group-item-action">
                                Exportar agendamentos do ponto {{$posto->nome}} <span class="badge badge-success">{{ $posto->candidatos->count() }}</span>
                            </a>
                            @endforeach
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Importar dados') }}
                </h2>
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="container">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('candidato.import.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="agendamentos">
                                @error('agendamentos')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary mx-2">
                                    Importar Fila
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

    </x-slot>
</x-app-layout>
