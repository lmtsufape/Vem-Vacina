<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar uma nova etapa') }}
        </h2>
    </x-slot>

    <div style="margin-top: 30px;">
        <form action="{{route('etapas.store')}}" method="post">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inicio_faixa_etaria">Inicio da faixa etaria</label>
                        <input id="inicio_faixa_etaria" class="form-control @error('inicio_faixa_etaria') is-invalid @enderror" type="number" name="inicio_faixa_etaria" placeholder="80" value="{{old('inicio_faixa_etaria')}}">

                        @error('inicio_faixa_etaria')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fim_faixa_etaria">Fim da faixa etaria</label>
                        <input id="fim_faixa_etaria" class="form-control @error('fim_faixa_etaria') is-invalid @enderror" type="number" name="fim_faixa_etaria" placeholder="85" value="{{old('fim_faixa_etaria')}}">

                        @error('fim_faixa_etaria')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <label for="texto">Texto adicional</label>
                        <textarea id="texto" class="form-control @error('texto') is-invalid @enderror" name="texto" cols="30" rows="5">{{old('texto')}}</textarea>
                    
                        @error('texto')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="pri_dose">Total de pessoas vacinadas na 1ª dose</label>
                        <input id="pri_dose" class="form-control @error('primeria_dose') is-invalid @enderror" type="number" name="primeria_dose" placeholder="0" value="{{old('primeria_dose')}}">

                        @error('primeria_dose')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="seg_dose">Total de pessoas vacinadas na 2ª dose</label>
                        <input id="seg_dose" class="form-control @error('dose_unica') is-invalid @enderror" type="number" name="dose_unica" placeholder="0" value="{{old('dose_unica')}}">

                        @error('dose_unica')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <input id="atual" type="checkbox" name="atual" @if(old('atual')) checked @endif>
                        <label for="atual">Esta é a etapa que está ocorrendo atualmente.</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <button type="submit" class="btn btn-success" style="width: 25%;">Adicionar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
