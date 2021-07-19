<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Atualizar agendamento') }}

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
                <div class="row">
                    <div class="col-8">
                        <form method="post" action="{{ route('candidato.editar', ['id' => $candidato->id]) }}">
                            @csrf
                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'nome_completo','label' => 'nome', 'type' => 'text', 'value' => $candidato->nome_completo , 'id' => null, 'placeholder' => null])
                            @endcomponent


                            @component('components.basic-input', ['disabled' => false, 'class' => 'cpf','name' => 'cpf','label' => 'cpf', 'type' => 'text', 'value' => $candidato->cpf, 'id' => null, 'placeholder' => "Ex.: 000.000.000-00"])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'data_de_nascimento','label' => 'data de nascimento', 'type' => 'date', 'value' => $candidato->data_de_nascimento, 'id' => null, 'placeholder' => null])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'numero_cartao_sus','label' => 'sus', 'type' => 'text', 'value' => $candidato->numero_cartao_sus, 'id' => null, 'placeholder' => null])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'nome_da_mae','label' => 'nome da mãe', 'type' => 'text', 'value' => $candidato->nome_da_mae, 'id' => null, 'placeholder' => null])
                            @endcomponent

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

{{-- <div class="form-group">
    <label for="exampleInputEmail1">Nome </label>
    <input type="email" value="{{ $candidato->nome_completo }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  @component('components.basic-input', ['disabled' => false, 'label' => 'teste', 'type' => 'text', 'value' => '', 'id' => null])
  @endcomponent --}}
