<table class="table table-bordered mb-5">
    <thead>
        <tr class="table-danger">
            <th scope="col">#</th>
            <th scope="col">Ponto</th>
            <th scope="col">Nº de Aprovados</th>
            <th scope="col">Nº de Vacinados</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($pontos ?? '' as $ponto)
        <tr>
            <th scope="row">{{ $ponto->id }}</th>
            <td>{{ $ponto->nome }}</td>
            <td>{{ $ponto->candidatos()->where('aprovacao', "Aprovado")->count() }}</td>
            <td>{{ $ponto->candidatos()->where('aprovacao', "Vacinado")->count() }}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
<table class="table table-bordered mb-5">
    <thead>
        <tr class="table-danger">
            <th scope="col">Data</th>
            <th scope="col">Aprovados</th>
            <th scope="col">Na Fila</th>
            <th scope="col">Vacinados</th>
            
        </tr>
    </thead>
    <tbody>
        <td>
            {{ date('d/m/Y', strtotime($request->data_inicio ))  ?? ""  }} 
            {{ " - " }} 
            {{date('d/m/Y', strtotime($request->data_fim ))  ?? ""}}
        </td>
        <td>{{ $candidatos->where('aprovacao', "Aprovado")->count() }}</td>
        <td>{{ $candidatos->where('aprovacao', "Não Analisado")->count() }}</td>
        <td>{{ $candidatos->where('aprovacao', "Vacinado")->count() }}</td>
        
    </tbody>
</table>