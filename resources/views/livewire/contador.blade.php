<div wire:poll="contador">
    <div class="row">
        <div class="col-sm-12 table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table" >
                <thead>
                    <tr>
                        <th scope="col">Público</th>
                        <th scope="col">Aprovados</th>
                        <th scope="col">Fila de espera</th>
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

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
