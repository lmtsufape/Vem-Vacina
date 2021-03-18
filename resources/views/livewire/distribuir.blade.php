<div>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form action="{{ route('lotes.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Nº de vacinas do lote: {{ $lote->qtdVacina }}</h4>
                            {{-- <label for="nome"></label> --}}

                        </div>

                    </div>
                    <div class="row">
                        @foreach ($postos as $posto)
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <button class="btn btn-info" type="button">Confirmar</button>
                                    </div>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" value="{{ $posto->vacinas_disponiveis }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{ $posto->nome }}</span>
                                          </div>
                                    </div>
                                  </div>
                            </div>
                        @endforeach
                    </div>



                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
