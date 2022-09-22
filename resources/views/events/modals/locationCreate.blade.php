<div class="modal fade" id="locationCreateModal">
   <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cadastrar local</h4>
            </div>
            <form method="POST"  action="{{ route('locations.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="custom-form-group">
                        <label for="nome">Nome do Local*:</label>
                        <input class="custom-form-control" type="text" name="nome" id="nome"
                            value=""
                        />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="submit">Cadastrar</button>
                    <button class="btn btn-default" type="button" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>