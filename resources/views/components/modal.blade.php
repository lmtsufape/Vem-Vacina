<div class="modal fade" id="visualizar_candidato" tabindex="-1" aria-labelledby="visualizar_candidato" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="visualizar_candidato">Cadastro de lote </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="container">
            <div class="modal-body">
                <form action="{{ route('lotes.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nome">Código do lote</label>
                            <input id="nome" type="text" class="form-control" name="numero_lote">
                        </div>
                        @error('numero_lote')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="data_nacimento">Fabricante</label>
                            <input id="data_nacimento" type="text" class="form-control" name="fabricante" >
                        </div>
                        <div class="col-md-6">
                            <label for="cpf">Nº de vacinas</label>
                            <input id="cpf" type="number" class="form-control" name="qtdVacina" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sexo">Fabricação</label>
                            <input id="sexo" type="date" class="form-control" name="data_fabricacao">
                        </div>
                        <div class="col-md-6">
                            <label for="sexo">Validade</label>
                            <input id="sexo" type="date" class="form-control" name="data_validade" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="input-group mt-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <label for="doseUnica " class="mr-2 mt-2">É dose única?</label>
                                    <input id="doseUnica" class="mb-2 mt-2" type="checkbox" name="dose_unica" value="true" aria-label="Checkbox for following text input">
                                  </div>
                                </div>
                            </div>
                        </div>
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
</div>
