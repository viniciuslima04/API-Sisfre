<script type="text/javascript">
    
    $(document).ready(function() {
    	update_tabelas();
    });

    function update_tabelas(){
    	var tabela_update = $('#tabela-update');

    	if(tabela_update.length){
    		setTimeout(atualiza, 15000);
    	}
    }

    function atualiza(){
		window.location.reload();
    }


</script>

