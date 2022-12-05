<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-10">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Estatísticas') }}
                </h2>
            </div>
            <div class="col-md-2" style="text-align: right">

                @can('ver-fila')
                    <a href="{{ route('fila.index') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Fila de Espera') }}
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{ route('estatistica.index') }}" method="get">
                    <select class="custom-select" style="height: 200px" name="publicos[]" multiple>
                        @foreach ($todosPublicos as $publico)
                            <option value="{{ $publico->id }}">{{ $publico->texto_home }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary mt-1">
                        Ver
                    </button>

                </form>
                <br>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Público</th>
                        <th scope="col">Aprovados</th>
                        <th scope="col">Fila de espera (1ª e 2ª dose)</th>
                        <th scope="col">Fila de espera(3ª dose)</th>
                        <th scope="col">Fila de espera(4ª dose)</th>
                        @foreach($doses as $dose)
                            <th scope="col">Fila de espera ({{$dose->nome}})</th>
                        @endforeach
                        <th scope="col">Vacinados com 1ª dose</th>
                        <th scope="col">Vacinados com 2ª dose</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($publicos as $publico)
                        <tr>
                            <td>
                                {{$publico->texto_home}}
                            </td>
                            <td>
                                <a href="{{route('dashboard')}}?aprovado=on&publico_check=on&publico={{$publico->id}}">
                                    {{
                                        intval(count($publico->candidatos()->where('aprovacao', $aprovacao[1])->get()))

                                    }}
                                </a>
                            </td>
                            <td>
                                <a href="{{route('fila.index')}}?publico_check=on&publico={{$publico->id}}">
                                    {{count($publico->candidatos()->where('aprovacao', $aprovacao[0])->whereIn('dose', ["1ª Dose", '2ª Dose', "Dose única"])->get())}}
                                </a>
                            </td>
                            <td>
                                <a href="{{route('fila.index')}}?publico_check=on&publico={{$publico->id}}">
                                    {{count($publico->candidatos()->where('aprovacao', $aprovacao[0])->where('dose', "3ª Dose")->get())}}
                                </a>
                            </td>
                            <td>
                                <a href="{{route('fila.index')}}?publico_check=on&publico={{$publico->id}}">
                                    {{count($publico->candidatos()->where('aprovacao', $aprovacao[0])->where('dose', "4ª Dose")->get())}}
                                </a>
                            </td>
                            @foreach($doses as $dose)
                                <td>
                                    <a href="{{route('fila.index')}}?publico_check=on&publico={{$publico->id}}">
                                        {{count($publico->candidatos()->where('aprovacao', $aprovacao[0])->where('dose_id', $dose->id)->get())}}
                                    </a>
                                </td>
                            @endforeach
                            <td>
                                <a href="{{route('dashboard')}}?dose_check=on&dose=1ª Dose&publico_check=on&publico={{$publico->id}}">
                                    {{$publico->total_pessoas_vacinadas_pri_dose}}
                                </a>
                            </td>
                            <td>
                                <a href="{{route('dashboard')}}?dose_check=on&dose=2ª Dose&publico_check=on&publico={{$publico->id}}">
                                    {{$publico->total_pessoas_vacinadas_seg_dose}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
