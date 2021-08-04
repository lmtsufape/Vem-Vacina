<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuário') }}
            {{ " : " .  $user->name }}

        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    @if(session('mensagem'))
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('mensagem')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row justify-content-center">
                    <div class="col-8 ">
                        <form method="post" action="{{ route('admin.update.user', ['id' => $user->id ]) }}">
                            @csrf
                            
                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'name','label' => 'Nome', 
                                                                  'type' => 'text', 'value' =>  $user->name  , 'id' => null, 'placeholder' => null])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'email','label' => 'Email', 
                                                                  'type' => 'text', 'value' =>  $user->email  , 'id' => null, 'placeholder' => null])
                            @endcomponent

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="inputGroupSelect01">Ponto</label>
                                </div>
                                <select class="custom-select" name="pontos[]" id="inputGroupSelect01" multiple>
                                  @foreach ($pontos as $ponto)
                                    <option value="{{ $ponto->id }}">{{ $ponto->nome }}</option>
                                  @endforeach
                                  
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-info">
                                        Atualizar
                                    </button>
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-danger" href="{{ route('dashboard') }}">
                                        Cancelar
                                    </a>
                                </div>
                            </div>

                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


