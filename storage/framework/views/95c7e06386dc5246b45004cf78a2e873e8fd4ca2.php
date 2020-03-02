<script type="text/javascript">
    
    $(document).ready(function() {
    	
        $('#ano').mask('9999');

        var inicio = $('.editar').serialize();

        $('button').on("click", function(){
        	var id = $(this).attr('id');

        	if(id == 'Editar'){
        		$('.editar').on("submit", function(){
		          if(inicio == $('.editar').serialize() ){
		            $("#alert").show();
		            $('#mensagem').text('Nenhum dado foi alterado!!');
		            return false;
		          }
		          else{
		            $("#alert").hide();
		            $('#mensagem').text('');
		            return true;
		          }
        		});
        	}
        });

        $('#btn-arquivo').on("click", function(){
            var atributo = $('#arquivo').attr('type');

            if(atributo == 'text'){
                $('#arquivo').attr('type','file');
            }
            else if(atributo == 'file'){
                $('#arquivo').attr('type','text');
 
            }
        });
    });

</script>