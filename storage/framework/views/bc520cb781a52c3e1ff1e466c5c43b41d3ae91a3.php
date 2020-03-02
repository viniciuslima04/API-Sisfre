<script type="text/javascript">
    
    $(document).ready(function() {
      $('#table-relatorio').hide();

      relatorio_carregaSelects();

      function relatorio_carregaSelects(){
        var dia       = $('#dia').find('option:selected').val();
        var turno     = $('#turno').find('option:selected').val();

        if(dia != '0'){

          relatorio_getTurnos(1);

          if(turno != '0'){
            ativa_download_visualizar(dia, turno);
          }
        }
        else{
          relatorio_getTurnos(0);
        }
      }

      function relatorio_getTurnos(status){

        $('#table-relatorio').hide();

        if(status == 0){

          $("#turno").prop('disabled', true);
        }
        else{
          $("#turno").prop('disabled', false);
        }

      };

      function relatorio_getLinks(dia, turno){

        var link = ''; 

        if(dia != '0' && turno != '0'){
            link = 'dia='+dia+'&turno='+turno;
        }
        else{
            $('#table-relatorio').hide();
        }

        return link;
      }

      function ativa_download_visualizar(dia, turno){

        var link = relatorio_getLinks(dia, turno);

        var download_professor   = $('#download-professor').data('url');
        var visualizar_professor = $('#visualizar-professor').data('url');


        if(link != ''){

          $('#download-professor').attr('href', download_professor+'&'+link);
          $('#visualizar-professor').attr('href', visualizar_professor+'?'+link);

          $('#table-relatorio').show();
        }
        else{

            $('#table-relatorio').hide();
        }
   
      };

      $('#dia').on('change', function(event) {
        relatorio_carregaSelects();
      });

      $('#turno').on('change', function(event) {

        relatorio_carregaSelects();

      });

    });

</script>