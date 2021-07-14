<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de edição de data de agendamento') }}
                </h2>
                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                    {{ " Quantidade: " . $candidatos->total() }}
                </h2>
            </div>
            <div class="col-md-4" style="text-align: right;">

            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                @include('subviews.filtros', ['rota' => "admin.editar.lista.data"])

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
                <form action="{{ route('admin.update.lista.data') }}" method="post">

                    <div class="row justify-content-center">
                        <div class="col-6">
                            @csrf

                            @component('components.basic-input', ['disabled' => false, 'class' => null,'name' => 'chegada','label' => 'Data agendamento', 'type' => 'date', 'value' => '', 'id' => null, 'placeholder' => null])
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
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">
                                    <input type="checkbox" name="" id="input_all">
                                </th>
                                <th scope="col">Nome</th>
                                <th scope="col">Dose</th>
                                <th scope="col">Data</th>
                                <th scope="col">Ponto</th>
                              </tr>
                            </thead>
                            <tbody>


                                @foreach ($candidatos as $candidato)
                                    <tr>
                                        <th scope="row">
                                            <input type="checkbox" class="input" name="ids[]" value="{{ $candidato->id }}">
                                        </th>
                                        <td>{{ $candidato->nome_completo }}</td>
                                        <td>{{ $candidato->dose }}</td>
                                        <td>{{ date('d/m/Y \à\s H:i', strtotime($candidato->chegada ))  }}</td>
                                        <td>{{ $candidato->posto->nome }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </form>

            </div>
        </div>
    </div>


<script>
    function mostrarFiltro(check, id) {
        if(check.checked) {
            document.getElementById(id).style.display = "block";
        } else {
            document.getElementById(id).style.display = "none";
        }
    }

    var input_all = document.getElementById('input_all');

    input_all.addEventListener('change', (e)=>{
        var checkboxes = document.getElementsByClassName('input');
        // console.log(e.target.checked)
        if(e.target.checked) {
            for (var checkbox of checkboxes) {
                checkbox.checked = true;
            }

        }else{
            for (var checkbox of checkboxes) {
                checkbox.checked = false;
            }

        }
    });


</script>

</x-app-layout>
