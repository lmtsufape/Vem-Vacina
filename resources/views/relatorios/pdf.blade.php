<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 7 PDF Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container mt-5">
        <h2 class=" ">Relatório criado dia: {{ date('d/m/Y', strtotime(now() ))  }}</h2>
        <h2 class="mb-3">Por: {{ Auth()->user()->email  }}</h2>
        {{-- <h2>{{$data_inicio ?? ""  }}</h2>
        <h2>{{$data_fim ?? ""  }}</h2> --}}


        @include('subviews.table_pdf')
        

    </div>

</body>

</html>
