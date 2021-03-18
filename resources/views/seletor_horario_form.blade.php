<script>

 function selecionar_dia_vacinacao(select_dia) {

     Array.from(document.getElementsByClassName("seletor_horario_dia_div")).forEach((div) => {
         div.style.display = "none";
         div.children[1].name = "";
         div.children[1].required = false;
     });

     if(!select_dia.value) {return;}
     let div = document.getElementById("seletor_horario_dia_" + select_dia.value);
     div.style.display = "block";
     div.children[1].name = "horario_vacinacao";
     div.children[1].required = true;
     console.log(div);
 }
 
</script>

@if(count($horarios_por_dia) <= 0)
    Não existem horários disponíveis no momento, por favor, tente novamente amanhã
@else
    <label>Dia da vacinação (obrigatório)</label>
    <select name="dia_vacinacao" id="dia_vacinacao" required onchange="selecionar_dia_vacinacao(this)">
        <option value="">-- Selecione o dia --</option>
        @foreach($horarios_por_dia as $dia => $horarios)
	          @if (old('dia_vacinacao') == $dia)
  		          <option value="{{$dia}}" selected>{{$dia}}</option>
  	        @else
  		          <option value="{{$dia}}">{{$dia}}</option>
	          @endif
        @endforeach
    </select>
    <br>

    @foreach($horarios_por_dia as $dia => $horarios)

        <div class="seletor_horario_dia_div"  id="seletor_horario_dia_{{$dia}}" style="display:none;">
            
            <label>Horários da vacinação (obrigatório)</label>

            <!-- é isso mesmo, o js que bota o name -->
            <select name="">
                <option value="">-- Selecione o horário --</option>
                @foreach($horarios as $horario)
  		              <option value="{{$horario->format("H:i:s")}}">{{$horario->format("H:i:s")}}</option>
                @endforeach
            </select>

        </div>
    @endforeach

@endif



