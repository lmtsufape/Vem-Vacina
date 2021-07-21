<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Arquivados') }}
                </h2>
                
            </div>
            <div class="col-md-4" style="text-align: right;">

            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                

                <div class="row">
                    @if(session('message'))
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('message')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <br>
                <ul>
                    <li>
                        <a href="{{route('admin.ponto.arquivados')}}">
                            <div class="card">
                                <div class="card-body">
                                    Pontos
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="card">
                            <div class="card-body">
                                <a href="#">Lotes</a>
                            </div>
                        </div>
                        
                    </li>
                </ul>

            </div>
        </div>
    </div>




</x-app-layout>
