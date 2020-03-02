<script type="text/javascript">  
  $(document).ready(function() {
    
    function exibe_horario(){
      var turma_id = $('#turma').find('option:selected').val();
      var status = $('#turma').data('status');
      if(status == 100){
        if(turma_id != 0 && turma_id != undefined){
          
          var token = $("input[name='_token']").val();
          
          $.ajax({
             url: "<?php echo e(route('ajax.disciplina')); ?>",
             method: 'POST',
             data: {turma_id:turma_id, _token:token},
            error: function(result){
              alert(result.responseJSON.response);
            },
            success: function(result) {
              $("#tabela").html('');
              $("#tabela").html(result.options);
            }
          });   
        }
        else{
          $("#tabela").html('');
        } 
      }
    }
    
    exibe_horario();

  });
</script>