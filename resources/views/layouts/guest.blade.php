<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="{{asset('js/jquery-3.3.1.js')}}" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function(){
                $('.cep').mask('00000000');
                $('.cpf').mask('000.000.000-00');
                $(".apenasLetras").mask("#", {
                    maxlength: false,
                    translation: {
                        '#': {pattern: /[A-zÀ-ÿ ]/, recursive: true}
                    }
                });
                $('.numero').mask('0000000000000');
                var SPMaskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };
                $('.celular').mask(SPMaskBehavior, spOptions);
                $('.sus').mask('000 0000 0000 0000');
            });
        </script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            <!-- menu -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="box-shadow: 2px 10px 53px -6px rgba(0,0,0,0.16);
            -webkit-box-shadow: 2px 10px 53px -6px rgba(0,0,0,0.16);
            -moz-box-shadow: 2px 10px 53px -6px rgba(0,0,0,0.16);">
                @auth
                    <div class="container">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                  
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('dashboard')}}">Área de controle</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endauth
            </nav>
            {{ $slot }}
        </div>
    </body>
</html>
