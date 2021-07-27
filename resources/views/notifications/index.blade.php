<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Notificações') }}
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
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col">#</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Mensagem</th>
                    <th scope="col">Criado</th>

                    
                </tr>
            </thead>
            <tbody>
                @foreach($notifications ?? '' as $notification)
                <tr>
                    <th scope="row">{{ $notification->id }}</th>
                    <td>{{ $notification->type}}</td>
                    <td>{{ json_decode($notification->data)->message }}</td>
                    <td>{{ date('d/m/Y \à\s H:i\h', strtotime($notification->created_at )) }}</td>
                    
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $notifications->links() }}
    </div>
</x-app-layout>

