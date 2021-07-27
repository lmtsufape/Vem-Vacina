<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Relatórios') }}
                </h2>
            </div>
        </div>
    </x-slot>
    <div class="container mb-4" style="padding-top: 20px;">
        @if(session('message'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <p>{{session('message')}}</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="GET" action={{ route('relatorios.index') }}>
            <div class="row">
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="checkbox" name="data_inicio_check" id="data_inicio_check_input" onclick="mostrarFiltro(this, 'data_inicio_check')" @if($request->data_inicio_check != null && $request->data_inicio_check) checked @endif>
                            <label>Por data inicio</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" name="data_fim_check" id="data_fim_check_input" onclick="mostrarFiltro(this, 'data_fim_check')" @if($request->data_fim_check != null && $request->data_fim_check) checked @endif>
                            <label>Por data fim</label>
                        </div>
                        {{-- <div class="col-md-3">
                            <input type="checkbox" name="mes_check" id="mes_check_input" onclick="mostrarFiltro(this, 'mes_check')" @if($request->mes_check != null && $request->mes_check) checked @endif>
                            <label>Por mês</label>
                        </div> --}}
                        <div class="col-md-3">
                            <input type="checkbox" name="ponto_check" id="ponto_check_input" @if($request->ponto_check != null && $request->ponto_check) checked @endif onclick="mostrarFiltro(this, 'ponto_check')">
                            <label>Ponto</label>
                        </div>
                        {{-- <div class="col-md-3">
                            <input type="checkbox" name="publico_check" id="publico_check_input" @if($request->publico_check != null && $request->publico_check) checked @endif onclick="mostrarFiltro(this, 'publico_check')">
                            <label>Público</label>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div id="data_inicio_check" class="col-md-3" style="@if($request->data_inicio_check != null && $request->data_inicio_check) display: block; @else display: none; @endif">
                            <input type="date" class="form-control" name="data_inicio" id="data_inicio" @if($request->data_inicio != null) value="{{$request->data_inicio}}" @endif>
                        </div>
                        <div id="data_fim_check" class="col-md-3" style="@if($request->data_fim_check != null && $request->data_fim_check) display: block; @else display: none; @endif">
                            <input type="date" class="form-control" name="data_fim" id="data_fim" @if($request->data_fim != null) value="{{$request->data_fim}}" @endif>
                        </div>
                        <div id="mes_check" class="col-md-3" style="@if($request->mes_check != null && $request->mes_check) display: block; @else display: none; @endif">
                            <input type="month" class="form-control" name="mes" id="mes" @if($request->mes != null) value="{{$request->mes}}" @endif>
                        </div>
                        <div id="ponto_check" class="col-md-3" @if($request->ponto_check != null && $request->ponto_check) style="display: block;" @else style="display:none;" @endif>
                            <select id="ponto" name="ponto" class="form-control">
                                <option value="">-- ponto --</option>
                                @foreach ($postos as $posto)
                                    <option @if($request->ponto == $posto->id) selected @endif value="{{ $posto->id }}">{{ $posto->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="publico_check" class="col-md-3" @if($request->publico_check != null && $request->publico_check) style="display: block;" @else style="display:none;" @endif>
                            <select id="publico" name="publico" class="form-control">
                                <option value="">-- Público --</option>
                                @foreach ($publicos as $publico)
                                    <option @if($request->publico == $publico->id) selected @endif value="{{ $publico->id }}">{{ $publico->texto_home }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 5px;">
                            <button type="submit" class="btn btn-primary" name="action" value="filtrar" style="width: 100%;">Filtrar</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 5px;">
                            <button type="submit" class="btn btn-primary" name="action" value="export" target="_blank" style="width: 100%;" >Export to PDF</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href={{ route('relatorios.index') }}><button type="button" class="btn btn-secondary" style="width: 100%;">Limpar filtros</button></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <br>
        @include('subviews.table_pdf')
        </div>
    <script>
        function mostrarFiltro(check, id) {
            if(check.checked) {
                document.getElementById(id).style.display = "block";
            } else {
                document.getElementById(id).style.display = "none";
            }
        }
    
    </script>
</x-app-layout>

