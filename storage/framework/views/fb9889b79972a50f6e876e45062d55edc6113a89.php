<script type="text/javascript">
    
    $(document).ready(function() {
      
      disciplina_carregarPeriodos();

      $('#curso').on('change',function(){
        $('#periodo').prop('disabled',true);
        $('#periodo').empty();
        $('#periodo').append('<option data-tokens="ketchup mustard" value="" selected> --- SEM FILTRO --- </option>');
        disciplina_carregarPeriodos();
      });


      function disciplina_carregarPeriodos(){
        var qtdPeriodos = $('#curso').find('option:selected').data('semestres');
        var periodo     = $('#periodo').find('option:selected').val();
        var periodoURL  = disciplina_periodoURL();
        
        if(qtdPeriodos != '' && qtdPeriodos != '0' && qtdPeriodos > 0 && periodo == ''){
          $('#periodo').empty();
          $('#periodo').append('<option data-tokens="ketchup mustard" value="" selected> --- SEM FILTRO --- </option>');

          if(periodoURL['periodo']) {
              $('#periodo').append('<option data-tokens="ketchup mustard" value="'+periodoURL["periodo"]+'" selected> '+periodoURL["periodo"]+' </option>');
          }

          for (var i = 1; i <= qtdPeriodos; i++) {
            $('#periodo').append('<option data-tokens="ketchup mustard" value="'+i+'"> '+i+' </option>');
          }

          $('#periodo').prop('disabled',false);
        }
      }

      function disciplina_periodoURL(){
        var query = location.search.slice(1);
        var partes = query.split('&');
        var data = {};
        partes.forEach(function (parte) {
            var chaveValor = parte.split('=');
            var chave = chaveValor[0];
            var valor = chaveValor[1];
            data[chave] = valor;
        });

        return data;
      }

    });
    
</script>