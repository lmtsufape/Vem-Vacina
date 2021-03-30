<x-app-layout>
    <x-slot name="header">
        <ul class="nav nav-pills justify-content-center">
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.pendentes')) active @endif " href="{{ route('candidato.pendentes') }}">Pendentes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.aprovados')) active @endif " href="{{ route('candidato.aprovados') }}">Aprovados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.vacinados')) active @endif " href="{{ route('candidato.vacinados') }}">vacinados</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.primeira.dose')) active @endif " href="{{ route('candidato.primeira.dose') }}">1ª Dose</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.segunda.dose')) active @endif " href="{{ route('candidato.segunda.dose') }}">2ª Dose</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.dose.unica')) active @endif " href="{{ route('candidato.dose.unica') }}">Dose Única</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.pontos')) active @endif " href="{{ route('candidato.pontos') }}">Pontos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.fila.espera')) active @endif " href="{{ route('candidato.fila.espera') }}">Fila</a>
            </li>
            <li class="nav-item">
              <a class="nav-link @if(request()->routeIs('candidato.reprovados')) active @endif " href="{{ route('candidato.reprovados') }}">Reprovado</a>
            </li>


          </ul>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

</x-app-layout>
