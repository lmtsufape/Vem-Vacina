<div class="row">

        <div class="row">
            @if (session()->has('mensagem'))
                <div class="alert alert-success">
                    {{ session('mensagem') }}
                </div>
            @endif
        </div>
    <form id="form" method="POST">
        @csrf
        <div class="col px-0">
            <h4>Informações pessoais</h4>
        </div>
        @can('editar-candidato')
            <div class="col-2 pl-0">
                <button type="button" id="buttonEditar{{$candidato->id}}" style="display: block;" onclick="editar({{$candidato->id}})" class="btn btn-info">Editar</button type="button">
                <button type="submit" id="buttonAtualizar{{$candidato->id}}" style="display: none;" onclick="editar({{$candidato->id}})" class="btn btn-info">Atualizar</button type="button">
            </div>
        @endcan

        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="nome_{{$candidato->id}}">Nome completo</label>
                <input id="nome_{{$candidato->id}}" type="text" class="form-control" value="{{ $candidato->nome_completo }}"    >
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label for="data_nacimento_{{$candidato->id}}">Data de nascimento</label>
                <input id="data_nacimento_{{$candidato->id}}" type="date" class="form-control" disabled value="{{ $candidato->data_de_nascimento }}"  >
            </div>
            <div class="col-md-6">
                <label for="cpf_{{$candidato->id}}">CPF</label>
                <input id="cpf_{{$candidato->id}}" type="text" class="form-control" disabled value="{{ $candidato->cpf }}" >
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="n_cartao_sus_{{$candidato->id}}">Número do cartão do SUS</label>
                <input id="n_cartao_sus_{{$candidato->id}}" type="text" class="form-control" disabled value="{{ $candidato->numero_cartao_sus }}"  >
            </div>
            <div class="col-md-6">
                <label for="sexo_{{$candidato->id}}">Sexo</label>
                <input id="sexo_{{$candidato->id}}" type="text" class="form-control" disabled value="{{$candidato->sexo}}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="nome_mae_{{$candidato->id}}">Nome completo da mãe</label>
                <input id="nome_mae_{{$candidato->id}}" type="text" class="form-control" disabled value="{{ $candidato->nome_da_mae }}" >
            </div>
        </div>
    </form>
    <script>
        var inputNome;
        function editar(id){
        buttonEditar = document.getElementById("buttonEditar"+id);
        buttonAtualizar = document.getElementById("buttonAtualizar"+id);
            console.log(id)
            inputNome = document.getElementById("nome_"+id);
            inputCpf = document.getElementById("cpf_"+id);
            inputNascimento = document.getElementById("data_nacimento_"+id);
            inputSus = document.getElementById("n_cartao_sus_"+id);
            inputMae = document.getElementById("nome_mae_"+id);
            if (buttonEditar.style.display == "block") {
                buttonAtualizar.style.display = "block";
                buttonEditar.style.display = "none";
                buttonEditar.classList.add("btn-success");
                inputNome.disabled = false;
                inputSus.disabled = false;
                inputCpf.disabled = false;
                inputNascimento.disabled = false;
                inputMae.disabled = false;
                console.log(inputNome)

                buttonEditar.innerHTML = "Atualizar";
            } else {
                buttonAtualizar.style.display = "none";
                buttonEditar.style.display = "block";
                buttonEditar.classList.remove("btn-success");
                inputNome.disabled = true;
                inputSus.disabled = true;
                inputCpf.disabled = true;
                inputNascimento.disabled = true;
                inputMae.disabled = true;
                buttonEditar.innerHTML = "Editar";
            }

        }


    </script>
</div>
