<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Feed') }}
                </h2>
                
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a class="btn btn-primary" href="{{ route('admin.feed.create') }}">
                    Adicionar feed
                </a>
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
                <div class="container">
                    <div class="row">
                        @foreach ($feeds as $feed)
                            <div class="col-12 mb-4">
                                <div class="card" style="width: 40rem;">
                                    <img src="{{ asset('storage/'.$feed->path) }}" style="height: 40em;width:40em;" class="card-img-top" alt="...">
                                    {{-- <div class="card-body">
                                      <h5 class="card-title">Card title</h5>
                                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div> --}}
                                    
                                    <div class="card-body">
                                      <a href="{{ route('admin.feed.edit', ['id' => $feed->id]) }}" class="btn btn-success">
                                            Editar
                                      </a>
                                      <a href="{{ route('admin.feed.delete', ['id' => $feed->id]) }}" class="btn btn-danger">
                                            Excluir
                                      </a>
                                    </div>
                                </div>
                               
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
