<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Estatísticas') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="container" style="padding-top: 20px;">
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Público</th>
                            <th scope="col">Aprovados</th>
                            <th scope="col">Fila de espera</th>
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
                                <td>{{intval(count($publico->candidatos()->where('aprovacao', "!=", $aprovacao[0])->get())/2)}}</td>
                                <td>{{count($publico->candidatos()->where('aprovacao', $aprovacao[0])->get())}}</td>
                                <td>{{$publico->total_pessoas_vacinadas_pri_dose}}</td>
                                <td>{{$publico->total_pessoas_vacinadas_seg_dose}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>