<script type="text/javascript">
    
    $(document).ready(function() {
    	
        $('#periodo').on('change', function(){
            turma_resetarOptativas();
            turma_getOptativas(0);
        });

        function turma_getOptativas(quantidade){
            var periodo = $('#periodo').find('option:selected').val();
            var curso   = $('#periodo').data('curso');
            var token   = $("input[name='_token']").val();

            $.ajax({
                 url: "{{ route('ajax.disciplina.optativa') }}",
                 method: 'POST',
                 data: {periodo:periodo, curso_id:curso, quantidade:quantidade, _token:token},
                error: function(result){
                      alert(result.responseJSON.response);
                },
                success: function(result) {

                    if( isNumeric(result.options)){
                        $('#periodo').data('optativa',result.options);
                        turma_exibeQuantidade(result.options);
                    }
                    else{
                        $("#disciplinasOptativas").html('');
                        $("#disciplinasOptativas").html(result.options);
                        turma_exibeOptativas(quantidade);
                    }
                }
            });
        }

        function turma_exibeQuantidade(qtdOptativas){
            if(qtdOptativas >= 1){
                $('#esconder').show();
            }
            else{
               $("#esconder").hide();
               $("#disciplinasOptativas").html('');
               $('#qtd').val('')
            }
        }

        function turma_exibeOptativas(quantidade){
            if(quantidade >= 1){
                $("#disciplinasOptativas").show();   
            }
        }

        function turma_resetarOptativas(){
            $("#disciplinasOptativas").html('');
            $("#disciplinasOptativas").hide();
        };


        $('#qtd').on('keyup',function(){
            var quantidade   = $(this).val();
            var qtdOptativas = $('#periodo').data('optativa');

            if(turma_verificaQuantidade(quantidade, qtdOptativas)){
                turma_getOptativas(quantidade);
            }
            else{
                turma_resetarOptativas();
            }
        });

        function isNumeric(str) {  
            var er = /^[0-9]+$/;  
            return (er.test(str));
        };

        function turma_verificaQuantidade(quantidade, optativas){

            if(isNumeric(quantidade) == false){
              $('.qtd').addClass('has-error');
              $('#qtd1').text('Informe um valor númerico!!'); 
              return false;
            }
            else{
              $('.qtd').removeClass('has-error');
              $('#qtd1').text('');
            }

            if(quantidade == '' || quantidade == 0 || quantidade == '0'){
              $('.qtd').addClass('has-error');
              $('#qtd1').text('Informe um valor maior que zero!!'); 
              return false;
            }
            else{
              $('.qtd').removeClass('has-error');
              $('#qtd1').text('');
            }

            if(quantidade > optativas){
              $('.qtd').addClass('has-error');
              $('#qtd1').text('Valor superior ao N° de optativas = '+optativas); 
              return false;
            }
            else{
              $('.qtd').removeClass('has-error');
              $('#qtd1').text('');
            }
            return true;
        };

        function turma_preenchidaOptativas(quantidade){
            for (var i = 1; i <= quantidade; i++) {
                var optativa = $('#optativa'+i).find('option:selected').val();
                
                if(optativa != 0 || optativa != '' || optativa != '0'){
                    return true;
                }
            }

            return false;
        }

        function turma_buscarOptativas(){
            var periodo     = $('#periodo').find('option:selected').val();
            var quantidade   = $('#qtd').val();

            if(periodo != 0 && periodo != '0' && periodo != ''){
                turma_getOptativas(0);

                if(quantidade != 0){
                    var preenchida = turma_preenchidaOptativas(quantidade);

                    if(preenchida == false){
                        turma_resetarOptativas();
                        turma_getOptativas(quantidade);
                    }
                    
                    turma_exibeOptativas(quantidade);
                }
            }
        }

        turma_buscarOptativas();

    });

</script>