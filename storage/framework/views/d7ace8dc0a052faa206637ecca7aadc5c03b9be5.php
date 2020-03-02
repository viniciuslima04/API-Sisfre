<script type="text/javascript">
    
    $(document).ready(function() {
        var celula;
        var qtd;
        var erro = 0;

        for (var aula = 1; aula <= 12; aula++) {
            
            for (var dia = 1; dia <= 5; dia++) {

                celula = $('#aula'+aula+dia);
                qtd = celula.data('qtd');

                if(qtd > 1){
                    celula.addClass('btn-danger');

                    if(aula >= 1 && aula <= 4){
                        $('#alert1').show();
                        $('#table1').text('Há um choque de horário, 2 ou mais disciplinas estão para serem lecionadas no mesmo horário');  
                    }
                    else if(aula >= 5 && aula <= 8){
                        $('#alert2').show();
                        $('#table2').text('Há um choque de horário, 2 ou mais disciplinas estão para serem lecionadas no mesmo horário');   
                    }
                    else if(aula >= 9 && aula <= 12){
                        $('#alert3').show();
                        $('#table3').text('Há um choque de horário, 2 ou mais disciplinas estão para serem lecionadas no mesmo horário');  
                    }
                    erro++
                }
                else{
                    celula.removeClass('btn-danger');
                }
            }
        }

        if(erro == 0){
            $('#alert1').hide();
            $('#alert2').hide();
            $('#alert3').hide();
        }

    });   
</script>