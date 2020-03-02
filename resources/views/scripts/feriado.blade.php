<script type="text/javascript">
    
    $(document).ready(function() {
    	
        function esconde_dataFinal(){
          var valor = $('#tipo').find('option:selected').val();

            if(valor == 2 || valor == 3){
               $("#esconder").show();
            }
            else{
               $("#esconder").hide();
           }
        };

    $('#tipo').on('change', function(event) {
        esconde_dataFinal();
    });

      esconde_dataFinal();
    });   
</script>