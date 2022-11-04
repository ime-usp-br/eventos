<div class="modal fade" id="addInstitutionModal">
   <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Instituição</h4>
            </div>
            <div class="modal-body">
                <input id="member_id" value="" type="hidden">
                <div id="error-modal"></div>
                <div class="row custom-form-group align-items-center">
                    <div class="col-12 col-lg-3 text-right">
                        <label for="institution_name_modal">Nome:</label>   
                    </div> 
                    <div class="col-12 col-lg-8">
                        <input class="custom-form-control" type="text" name="institution_name_modal"
                            id="institution_name_modal" value=''
                        />
                    </div>
                </div>
                <div class="row custom-form-group align-items-center">
                    <div class="col-12 col-lg-3 text-right">
                        <label for="institution_abbreviation_modal">Sigla*:</label>   
                    </div> 
                    <div class="col-12 col-md-4">
                        <input class="custom-form-control" type="text" name="institution_abbreviation_modal"
                            id="institution_abbreviation_modal" value=''
                        />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn-addInstitution2" class="btn btn-default" type="button" data-dismiss="modal">Adicionar</button>
                <button class="btn btn-default" type="button" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>