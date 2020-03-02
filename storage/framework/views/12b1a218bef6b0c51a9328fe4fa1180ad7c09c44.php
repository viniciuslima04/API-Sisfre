<script type="text/javascript">
    
    $(document).ready(function() {

        $("#CadTurma").on("submit", function(event) {
            var periodo         = $('#periodo').find('option:selected').val();
            var turno           = $('#turno').find('option:selected').val();
            var semestre        = $('#semestre').find('option:selected').val();

            var verificaPeriodo     = turma_verificarPeriodos(periodo);
            var verificaTurno       = turma_verificarTurnos(turno);
            var verificaSemestre    = turma_verificarSemestres(semestre);
            
            // Verifica se ele existe
            if(periodo > 0){
                var qtdOptativas        = $("#periodo").data('optativa');

                // SOMENTE SE O PERÍODO OFERTAR OPTATIVAS ENTÃO PODE PASSAR
                if(qtdOptativas > 0){

                  var quantidade          = $("#qtd").val();
                  var verificaQtd         = turma_verificaQuantidade(quantidade, qtdOptativas);

                  if(verificaQtd){
                      var verificaOptativas   = turma_verificarOptativas(qtdOptativas);

                    if(verificaPeriodo && verificaTurno && verificaSemestre && verificaOptativas == 0){
                        return true;
                    }

                  }

                  return false;
                }
            }  

            if(verificaPeriodo && verificaTurno && verificaSemestre){
                return true;
            }

            return false;

        });

        function isNumeric(str) {  
            var er = /^[0-9]+$/;  
            return (er.test(str));
        };

        function turma_verificaQuantidade(quantidade, optativas){

            if(quantidade == '' || quantidade == 0 || quantidade == '0'){
              $('.qtd').addClass('has-error');
              $('#qtd1').text('Informe um valor maior que zero!!'); 
              return false;
            }
            else{
              $('.qtd').removeClass('has-error');
              $('#qtd1').text('');
            }

            if(isNumeric(quantidade) == false){
              $('.qtd').addClass('has-error');
              $('#qtd1').text('Informe um valor númerico!!'); 
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

        function turma_verificarOptativas(quantidade){
            var erros = 0;

            for (var i = 1 ; i <= quantidade; i++) {
                var optativa = $('#optativa'+i).find('option:selected').val();
                erros = erros + turma_verificaValorOptativa(optativa, i);
                if(optativa > 0){
                    erros = erros + turma_verificaIgualdadeOptativas(quantidade, optativa, i)
                }
            }

            return erros;
        }

        function turma_verificaValorOptativa(optativa, indice){
            if(optativa == '0' || optativa ==''){
                $('.optativa'+indice).addClass('has-error');
                $('#optativa'+indice+indice).css({"color": "#a94442"});
                $('#optativa'+indice+indice).text('Selecione uma disciplina para a Optativa '+indice);
                return 1;
            }
            else{
                $('.optativa'+indice).removeClass('has-error');
                $('#optativa'+indice+indice).text('');     
            }
            return 0;
        }

        function turma_verificaIgualdadeOptativas(quantidade, optativa, indice){

            for (var i = 1 ; i <= quantidade; i++) {
                if(i != indice){
                    var outraOptativa = $('#optativa'+i).find('option:selected').val();

                    if(outraOptativa == optativa){
                        $('.optativa'+indice).addClass('has-error');
                        $('#optativa'+indice+indice).css({"color": "#a94442"});
                        $('#optativa'+indice+indice).text('Optativas Iguais. Selecione outra disciplina para a Optativa '+i);

                        $('.optativa'+i).addClass('has-error');
                        $('#optativa'+i+i).css({"color": "#a94442"});
                        $('#optativa'+i+i).text('Optativas Iguais. Selecione outra disciplina para a Optativa '+indice);
                        return 1;
                    }
                    else{
                        $('.optativa'+indice).removeClass('has-error');
                        $('#optativa'+indice+indice).text('');

                        $('.optativa'+i).removeClass('has-error');
                        $('#optativa'+i+i).text('');
                    }
                }
            }
            return 0;
        }

        function turma_verificarPeriodos(periodo){
            if(periodo == '0' || periodo == ''){
              $("#error-periodo").show();
              $('.periodo1').addClass('has-error');
              $('#periodo1').css({"color": "#a94442"});
              $('#periodo1').text('Selecione um período');
              return false;
            }
            else{
              $('.periodo1').removeClass('has-error');
              $("#error-periodo").hide();
              $('#periodo1').text('');   
            }

            return true;
        }

        function turma_verificarSemestres(semestre){
            if(semestre == '0' || semestre == ''){
              $("#error-semestre").show();
              $('.semestre1').addClass('has-error');
              $('#semestre1').css({"color": "#a94442"});
              $('#semestre1').text('Selecione um semestre');
              return false;
            }
            else{
              $('.semestre1').removeClass('has-error');
              $("#error-semestre").hide();
              $('#semestre1').text('');   
            }

            return true;
        }

        function turma_verificarTurnos(turno){
            if(turno == '0' || turno == ''){
              $("#error-turno").show();
              $('.turno1').addClass('has-error');
              $('#turno1').css({"color": "#a94442"});
              $('#turno1').text('Selecione um turno');
              return false;
            }
            else{
              $('.turno1').removeClass('has-error');
              $("#error-turno").hide();
              $('#turno1').text('');   
            }

            return true;
        }

    });

</script>