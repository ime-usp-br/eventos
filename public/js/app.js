$(function(){
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
});