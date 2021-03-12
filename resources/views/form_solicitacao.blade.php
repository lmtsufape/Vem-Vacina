<x-guest-layout>


    <script>
     function checkbox_visibilidade(div_alvo, checkbox) {
         if(checkbox.checked) {
             div_alvo.style.display = "block";
         } else {
             div_alvo.style.display = "none";
         }
     }


     function buscar_CEP(input, evt) {
         let theEvent = evt || window.event;
         
         if(evt.keyCode == 8) {
             theEvent.returnValue = true;
             return;
         }

         let key = "";
         if (theEvent.type === 'paste') {
         } else {
             // Handle key press
             key = theEvent.keyCode || theEvent.which;
             key = String.fromCharCode(key);
         }
         var regex = /[0-9]|\./;
         if( !regex.test(key) ) {
             theEvent.returnValue = false;
             if(theEvent.preventDefault) theEvent.preventDefault();
             return;
         }

         // enquanto não tiver suficiente, deixa preencher
         if(input.value.length < 7) {
             theEvent.returnValue = true;
             return;
         }

         // caso já esteja preenchido, não adiciona mais numeros
         if(input.value.length === 8) {
             theEvent.returnValue = false;
             return;
         }
         
         // colocou o ultimo valor do cep
         theEvent.returnValue = true;


         // pega o valor do cep
         let cep = input.value + key;


         let url = "http://" + document.location.host + "/cep/" + cep;
         console.log(url);
         
         fetch(url).then((resposta) => {
             return resposta.json();
         }).then((json) => {

             if(json.resultado != 1) {
                 // todo: erro
                 return;
             }

             document.getElementById("cidade").value = json.cidade;
             document.getElementById("bairro").value = json.bairro;
             document.getElementById("logradouro").value = json.tipo_logradouro + " " + json.logradouro;

         });
         
     }
     

     
    </script>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    

    <form method="POST" action="{{ route('solicitacao.candidato.enviar') }}" enctype="multipart/form-data">
        @csrf


        <!-- informações pessoais -->
        <label>NOME COMPLETO (obrigatório)</label><input type="text" name="nome_completo" value="{{old('nome_completo')}}" required><br>
        <label>DATA NASCIMENTO (obrigatório)</label><input type="date" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="data_de_nascimento" value="{{old('data_de_nascimento')}}" required><br>
        <label>CPF (obrigatório)</label><input type="text" name="cpf" value="{{old('cpf')}}" required><br>
        <label>NÚMERO DE CARTÃO DO SUS (obrigatório)</label><input type="text" name="numero_cartao_sus" value="{{old('numero_cartao_sus')}}" required><br>

        <label>SEXO (obrigatório)</label>
        <select name="sexo" required>
            <option value="">-- Selecione o sexo --</option>
            @foreach($sexos as $sexo)
	              @if (old('sexo') == $sexo)
  		              <option value="{{$sexo}}" selected>{{$sexo}}</option>
  	            @else
		                <option value="{{$sexo}}">{{$sexo}}</option>
	              @endif
            @endforeach
        </select>
        <br>

        <label>NOME DA MÃE (obrigatório)</label><input type="text" name="nome_da_mae" value="{{old('nome_da_mae')}}" required><br>
        <label>FOTO DA FRENTE DO RG (obrigatório)</label><input type="file" name="foto_frente_rg" required><br>
        <label>FOTO DA TRÁS DO RG (obrigatório)</label><input type="file" name="foto_tras_rg" required><br>

        <!-- outras informações -->
        <input type="checkbox" name="paciente_acamado" value="1" {{ (is_array(old('paciente_acamado')) and in_array("1", old('paciente_acamado'))) ? ' checked' : '' }}><label>PACIENTE É ACAMADO</label><br>
        <input type="checkbox" name="paciente_agente_de_saude" value="1" {{ (is_array(old('paciente_acamado')) and in_array("1", old('paciente_acamado'))) ? ' checked' : '' }} onclick="checkbox_visibilidade(document.getElementById('unidade_agente'), this)"><label>PACIENTE TEM VÍNCULO COM A EQUIPE DE SAÚDE DA FAMÍLIA (AGENDE DE SAÚDE)</label><br>
        <div id="unidade_agente" style="display:none;">
            <label>Qual o nome da sua unidade? (Caso tenha vínculo)</label><input type="text" name="unidade_caso_agente_de_saude" value="{{old('unidade_caso_agente_de_saude')}}"><br>
        </div>

        <!-- contato -->
        <label>TELEFONE (obrigatório)</label><input type="text" name="telefone" value="{{old('telefone')}}" required><br>
        <label>WHATSAPP</label><input type="text" name="whatsapp" value="{{old('whatsapp')}}"><br>
        <label>EMAIL</label><input type="text" name="email" value="{{old('email')}}"><br>


        <!-- endereço -->
        <label>CEP (obrigatório, apenas números)</label><input type="text" name="cep" onkeydown="buscar_CEP(this, event)" value="{{old('cep')}}" required><br>
        <label>CIDADE</label><input type="text" name="cidade" value="{{old('cidade')}}" id="cidade" readonly><br>
        <label>BAIRRO</label><input type="text" name="bairro" value="{{old('bairro')}}" id="bairro" readonly><br>
        <label>LOGRADOURO</label><input type="text" name="logradouro" value="{{old('logradouro')}}" id="logradouro" readonly><br>
        <label>NÚMERO DA RESIDÊNCIA (obrigatório)</label><input type="text" name="numero_residencia" value="{{old('numero_residencia')}}" required><br>
        <label>COMPLEMENTO</label><input type="text" name="complemento_endereco" value="{{old('complemento_endereco')}}"><br>


        <!-- informações do atendimento -->
        <!-- TODO -->
        <!-- vai ter um select que vai ser selecionado a posto de atendimento -->
        <!-- depois que for selecionado, vai ser baixado o html com a lista dos dias e horarios de possiveis atendimentos -->
        <!-- quando o usuario escolher, e enviar, a vaga da lista já pode ter sido tomada -->
        <!-- então o controller deve avisar isso ao usuario e pedir pra escolher outro horario dos novos disposiveis -->
        <!-- por isso que essa seção tá em todo, é necessaria primeiro a lista dos postos -->

        <br><br>
        <input type="submit" value="ENVIAR">

    </form>

</x-guest-layout>
