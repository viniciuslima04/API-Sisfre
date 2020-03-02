<script type="text/javascript">
    
    $(document).ready(function() {
      $('#table-relatorio').hide();

      relatorio_carregaSelects();

      function relatorio_carregaSelects(){
        var ano       = $('#ano').find('option:selected').val();
        var semestre  = $('#semestre').find('option:selected').val();
        var professor = $('#professor').find('option:selected').val();

        if(ano != '0' && semestre != '0'){
          ativa_download_visualizar();

          if(professor != '0'){
            ativa_download_visualizar();
          }
          else{
            relatorio_getProfessores();
          }
        }
        else if(ano != '0'){
          relatorio_getSemestres();
        }
      }

      function relatorio_getSemestres(){
        $('#table-relatorio').hide();

        var ano = $('#ano').find('option:selected').val();

        if(ano != '0'){
        
          var token = $("input[name='_token']").val();

          $.ajax({
               url: "<?php echo e(route('ajax.semestre.ano')); ?>",
               method: 'POST',
               data: {ano:ano, _token:token},
              error: function(result){
                    alert(result.responseJSON.response);
              },
              success: function(result) {
                  $("#semestre").html('');
                  $("#semestre").html(result.options);
                  $("#semestre").prop('disabled',false);
              }
          });
        }
        else{
            $("#semestre").prop('disabled',true);
            $("#semestre").html('');
            $("#semestre").append('<option data-tokens="ketchup mustard" value="0"> --- SELECIONE O ANO --- </option>');

            $("#professor").prop('disabled', true);
            $("#professor").html('');
            $("#professor").append('<option data-tokens="ketchup mustard" value="0"> --- SELECIONE O ANO --- </option>');
        }
      };

      function relatorio_getProfessores(){

        var semestre = $('#semestre').find('option:selected').val();
        var curso    = $('#container-pesquisar').data('curso');
        var token    = $("input[name='_token']").val();

        if(semestre != '0'){
        
          $.ajax({
               url: "<?php echo e(route('ajax.professor.semestre')); ?>",
               method: 'POST',
               data: {curso:curso, semestre:semestre, _token:token},
              error: function(result){
                    alert(result.responseJSON.response);
              },
              success: function(result) {
                  $("#professor").html('');
                  $("#professor").html(result.options);
                  $("#professor").prop('disabled', false);  
              }
          });
        }
        else{
            $("#professor").prop('disabled', true);
            $("#professor").html('');
            $("#professor").append('<option data-tokens="ketchup mustard" value="0"> --- SELECIONE O SEMESTRE --- </option>');
        }
      };

      function relatorio_getLinks(){
        var professor = $('#professor').find('option:selected').val();
        var semestre  = $('#semestre').find('option:selected').val();
        var link = ''; 

        if(semestre != '0' && semestre != '' && semestre != 0){
            link = 'semestre='+semestre;

            if(professor != '0' && professor != '' && professor != 0){
              link = link+'&professor='+professor;
            }
        }
        else{
            $('#table-relatorio').hide();
        }

        return link;
      }

      function ativa_download_visualizar(){

        var link = relatorio_getLinks();

        var download_anteposicao = $('#download-anteposicao').data('url');
        var download_falta = $('#download-falta').data('url');
        var download_reposicao = $('#download-reposicao').data('url');

        var visualizar_anteposicao = $('#visualizar-anteposicao').data('url');
        var visualizar_falta = $('#visualizar-falta').data('url');
        var visualizar_reposicao = $('#visualizar-reposicao').data('url');

        if(link != ''){

          $('#download-falta').attr('href', download_falta+'&'+link);
          $('#visualizar-falta').attr('href', visualizar_falta+'?'+link);

          $('#download-reposicao').attr('href', download_reposicao+'&'+link);
          $('#visualizar-reposicao').attr('href', visualizar_reposicao+'?'+link);

          $('#download-anteposicao').attr('href', download_anteposicao+'&'+link);
          $('#visualizar-anteposicao').attr('href', visualizar_anteposicao+'?'+link);

          $('#table-relatorio').show();
        }
        else{



        }
   
      };

      $('#ano').on('change', function(event) {
          relatorio_getSemestres();
      });

      $('#semestre').on('change', function(event){
          ativa_download_visualizar();
          relatorio_getProfessores();
      });

      $('#professor').on('change', function(event){
          ativa_download_visualizar();
      });


    });

</script>