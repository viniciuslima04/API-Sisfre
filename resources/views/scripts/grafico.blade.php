<script type="text/javascript">
    
  $(document).ready(function() {

    function grafico_getSemestres(ano, token){
        $.ajax({
             url: "{{ route('ajax.semestre.ano') }}",
             method: 'POST',
             data: {ano:ano, _token:token},
            error: function(result){
              alert(result.responseJSON.response);
            },
            success: function(result) {
                $("#semestre1").html('');
                $("#semestre1").html(result.options);
            }
        });
    };

    function grafico_resetarSemestres(){
        $("#semestre1").html('');
        $("#semestre1").append('<option data-tokens="ketchup mustard" value="0"> --- SELECIONE O ANO --- </option>');
    };

    function grafico_carregaSelects(){
      
      $('#table-grafico').hide();

      var ano       = $('#ano1').find('option:selected').val();
      var token     = $("input[name='_token']").val();

      if(ano != '0' && ano !=  undefined){
        grafico_getSemestres(ano, token);
      }
      else{
        grafico_resetarSemestres();
      }
    };

    function grafico_ativaDownloadVisualizar(){
        var semestre = $('#semestre1').find('option:selected').val();

        if(semestre != '0'){
          $('#table-grafico').show();
        }
    }

    function grafico_verificarImpressao(){
      var download = $('#print-grafico');

      if(download.length){
        var imprimir = download.data('download');

        if(imprimir == true){
          setTimeout(grafico_imprimir, 500);
        }
      }
    }

    function grafico_imprimir(){
       window.print();
    }

    $('#ano1').on('change', function(event) {
      var ano       = $('#ano1').find('option:selected').val();
      var token     = $("input[name='_token']").val();
      grafico_resetarSemestres();
      $('#table-grafico').hide();
      grafico_getSemestres(ano, token);
    });

    $('#semestre1').on('change', function(event){
        grafico_ativaDownloadVisualizar();
    });

    $('#download-graficoFalta').on('click', function(){
      var semestre = $('#semestre1').find('option:selected').val();

      if(semestre != '0'){
        var url = $(this).data('url');
        window.open(url+'&semestre='+semestre);
      }

    });

    $('#visualizar-graficoFalta').on('click', function(){
      var semestre = $('#semestre1').find('option:selected').val();

      if(semestre != '0'){
        var url = $(this).data('url');
        window.open(url+'?semestre='+semestre);
      }
    });

    grafico_carregaSelects();
    grafico_ativaDownloadVisualizar()
    grafico_verificarImpressao();

  });

</script>