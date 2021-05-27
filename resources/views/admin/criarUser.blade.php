<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Usuário') }}

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
                        <form method="post" action="{{ route('admin.create.user') }}">
                            @csrf
                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'name','label' => 'Nome', 'type' => 'text', 'value' => null , 'id' => null, 'placeholder' => null])
                            @endcomponent


                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'email','label' => 'Email', 'type' => 'email', 'value' => null, 'id' => null, 'placeholder' => null])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'password','label' => 'Senha', 'type' => 'password', 'value' => null, 'id' => null, 'placeholder' => null])
                            @endcomponent

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="inputGroupSelect01">Tipo</label>
                                </div>
                                <select class="custom-select" name="tipo" id="inputGroupSelect01">
                                  <option selected>Selecione...</option>
                                  <option value="gerente">Gerente</option>
                                  <option value="colaborador">Colaborador</option>
                                  <option value="secretaria">Secretaria</option>
                                  <option value="enfermeira">Enfermeira</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    <button type="submit" class="btn btn-info">
                                        Criar
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


