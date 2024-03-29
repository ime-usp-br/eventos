$(function(){
    $('.custom-timepicker').bootstrapMaterialDatePicker({
      date: false,
      format: 'HH:mm',
      shortTime: false,
      clearButton: true,
      nowButton: false,
      switchOnClick: true,
      cancelText: 'Cancelar',
      minuteStep: 10,
      showMeridian: false,
      explicitMode: true,
      changeMinute: 10,
      
    }); 
    $('.custom-datepicker').datepicker({
      showOn: 'both',
      buttonText: '<i class="far fa-calendar"></i>',
      dateFormat: 'dd/mm/yy',
    });
    $('#btn-addAttachment').on('click', function(e) {
      var count = document.getElementById('count-new-attachment');
      var id = parseInt(count.value)+1;
      count.value = id;
      var html = ['<div class="row custom-form-group justify-content-start" id="anexo-new'+id+'">',
          '<div class="col-lg-auto"><input class="custom-form-input btn-sm" id="anexosNovos[new'+id+'][arquivo]" name="anexosNovos[new'+id+'][arquivo]" type="file" >',
          '<a class="btn btn-link btn-sm text-dark text-decoration-none"',
          '    style="padding-left:0px"',
          '    id="btn-remove-anexo-new'+id+'"',
          '    onclick="removeAnexo(\'new'+id+'\')"',
          '>',
          '    <i class="fas fa-trash-alt"></i>',
          '</a>',
          '<br/>',
      '</div></div>'].join("\n");
      $('#novos-anexos').append(html);
    });
    $('#btn-createLocation').on('click', function(e) {
      var locationName = $("#locationName").val();
      $("#local").prop("selected", false);
      
      $("#local").append("<option value='"+locationName+"' selected>"+locationName+"</option>");

      $('#locationCreateModal').hide();
      $('body').removeClass('modal-open');
      $('.modal-backdrop').remove(); 
    });
    $('#btn-createKind').on('click', function(e) {
      var kindName = $("#kindName").val();
      $("#tipo").prop("selected", false);
      
      $("#tipo").append("<option value='"+kindName+"' selected>"+kindName+"</option>");

      $('#kindCreateModal').hide();
      $('body').removeClass('modal-open');
      $('.modal-backdrop').remove(); 
    });
});