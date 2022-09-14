<div class="modal fade" id="{{ 'emailSendingConfirmationModal' . $eventoID  }}">
   <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sistema de Eventos</h4>
            </div>
            <div class="modal-body">
                <div class="custom-form-group">
                    <div class="col-12">
                        <label>Deseja que o usuário {{$evento->criador->name}} receba um e-mail informando sobre a aprovação do evento?</label>   
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST"  action="{{ route('events.validate',['event'=>$eventoID,'sendUserEmail'=>1]) }}" style="display: inline;">
                    @csrf
                    @method('put')
                    <button class="btn btn-outline-success btn-sm" type="submit">
                        Sim
                    </button>
                </form>
                <form method="POST"  action="{{ route('events.validate',['event'=>$eventoID,'sendUserEmail'=>0]) }}" style="display: inline;">
                    @csrf
                    @method('put')
                    <button class="btn btn-outline-danger btn-sm" type="submit">
                        Não
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>