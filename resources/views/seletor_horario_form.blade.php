@if(count($horarios_por_dia) <= 0)
    Não existem horários disponíveis no momento, por favor, tente novamente amanhã
@else
    <label for="dia_vacinacao" class="style_titulo_input">DIA DA VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
    <select id="dia_vacinacao" class="form-control style_input @error('posto_vacinacao') is-invalid @enderror" name="dia_vacinacao" required onchange="selecionar_dia_vacinacao(this)">
        <option selected disabled>-- Selecione o dia --</option>
        @foreach($horarios_por_dia as $dia => $horarios)
  		      <option value="{{$dia}}">{{$dia}}</option>
        @endforeach
    </select>


    @foreach($horarios_por_dia as $dia => $horarios)
        <div class="seletor_horario_dia_div"  id="seletor_horario_dia_{{$dia}}" style="display:none;">
            <div class="form-row horario_vacina_div">
                <div class="form-group" style="width: 100%;">
                    <label for="dia_vacinacao" class="style_titulo_input">HORÁRIO DA VACINAÇÃO<span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span></label>
                    <!-- é isso mesmo, o js que bota o name e id -->
                    <select id="" name="" class="form-control style_input">
                        <option selected disabled>-- Selecione o horário --</option>
                        @foreach($horarios as $horario)
  		                      <option value="{{$horario->format("H:i")}}">{{$horario->format("H:i")}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>
    @endforeach

@endif



<style>

 #dia_vacinacao {
     margin-bottom: 16px;
 }

 .horario_vacina_div {
     margin-left: -102%;
 }
 @media screen and (max-width: 1186px) {
     #dia_vacinacao {
         margin-bottom: 32px;
     }
 }

 @media screen and (max-width: 992px) {
     .horario_vacina_div {
         margin-left: -102%;
     }
 }

 @media screen and (max-width: 768px) {
     .horario_vacina_div {
         margin-left: 0;
     }
 }



</style>
