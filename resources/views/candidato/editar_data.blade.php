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
                    @if(session('message'))
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('message')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row justify-content-center">
                    <div class="col-10">
                        <h3>{{ "Nome: ". $candidato->nome_completo }}</h3>
                        <h3>{{ "Data: ". date('d/m/Y \à\s H:i\h', strtotime($candidato->chegada))  }}</h3>
                        <h3>{{ "Dose: ". $candidato->dose  }}</h3>
                        <br>
                    </div>
                    <div class="col-6">
                        <form method="post" action="{{ route('candidato.editarData', ['id' => $candidato->id]) }}">
                            @csrf

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'chegada','label' => 'Data agendamento', 'type' => 'datetime-local', 'value' => $candidato->chegada->format('Y-m-d\TH:i'), 'id' => null, 'placeholder' => null])
                            @endcomponent

                            <br>
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

                            {{-- @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'nome_completo','label' => 'nome', 'type' => 'text', 'value' => $candidato->nome_completo , 'id' => null, 'placeholder' => null])
                            @endcomponent


                            @component('components.basic-input', ['disabled' => false, 'class' => 'cpf','name' => 'cpf','label' => 'cpf', 'type' => 'text', 'value' => $candidato->cpf, 'id' => null, 'placeholder' => "Ex.: 000.000.000-00"])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'data_de_nascimento','label' => 'data de nascimento', 'type' => 'date', 'value' => $candidato->data_de_nascimento, 'id' => null, 'placeholder' => null])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'numero_cartao_sus','label' => 'sus', 'type' => 'text', 'value' => $candidato->numero_cartao_sus, 'id' => null, 'placeholder' => null])
                            @endcomponent

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'nome_da_mae','label' => 'nome da mãe', 'type' => 'text', 'value' => $candidato->nome_da_mae, 'id' => null, 'placeholder' => null])
                            @endcomponent --}}



                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


