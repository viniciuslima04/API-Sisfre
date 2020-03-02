<script type="text/javascript">
    
  $(document).ready(function() {
    
    horario_carregarVerificacoes();

    $("#CadHora").on("submit", function(e) {
      var total_aulas         = $("#titulo").data('total');
      var turno               = $("#titulo").data('turno');
      var qtd_disciplinas     = $('#tituloDisciplina').data('disciplinas');

      var val_aulas      = verifica_qtdAulas_disciplinas(qtd_disciplinas, turno);
      var val_totalAulas = verifica_total_aulas(total_aulas, turno);
      var val_professor  = verifica_professor();
      
      if(val_totalAulas && val_professor == 0 && val_aulas){
        return true;
        
      }
      return false;
    });

    function horario_carregarVerificacoes(){
      var total_aulas         = $("#titulo").data('total');
      var turno               = $("#titulo").data('turno');
      var qtd_disciplinas     = $('#tituloDisciplina').data('disciplinas');

      verifica_qtdAulas_disciplinas(qtd_disciplinas, turno);
      verifica_total_aulas(total_aulas, turno);
      verifica_professor();
    }

    function verifica_qtdAulas_disciplinas(quantidadeDisciplinas, turno){
      var disciplina_id        = 0;
      var disciplina_nome      = "";
      var disciplina_qtd_aulas = 0;
      var total_aulas          = 0;
      var erros                = 0;

      for (var i = 1; i <= quantidadeDisciplinas; i++) {
          disciplina_id         = $("#disciplina"+i).data('id');
          disciplina_nome       = $("#disciplina"+i).data('nome');
          disciplina_qtd_aulas  = $("#disciplina"+i).data('ch');

          total_aulas = verifica_aulas_disciplinas(disciplina_id, turno);

          if(total_aulas != disciplina_qtd_aulas){
            $(".disciplina"+disciplina_id).addClass('has-error');
            $('#disciplina'+disciplina_id+disciplina_id).text('A disciplina: '+ disciplina_nome +' necessita ter '+ disciplina_qtd_aulas +' aulas semanais. Mas possui '+ total_aulas +' aula(s) selecionada(s)');

            erros = erros + 1;
          }
          else{
            $(".disciplina"+disciplina_id).removeClass('has-error');
            $('#disciplina'+disciplina_id+disciplina_id).text('');
          }
      }

      return erros == 0;

    };

    function verifica_total_aulas(total, turno){
      var soma_aulas = 0;
      var qtd_aulas = 0;
      var qtd_aulas_atribuidas = 0;
      var disciplina = 0;

      if(turno == 'D'){
        for (var aula = 1; aula <= 8; aula++) {

          for (var dia = 1; dia <= 5; dia++) {
            qtd_aulas = $("#horario"+aula+dia).find('option:selected').data('ch');
            disciplina = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina != 0){
              soma_aulas ++;
              qtd_aulas_atribuidas = verifica_aulas_disciplinas(disciplina, turno);
            
              if(qtd_aulas_atribuidas != qtd_aulas){
                marca_aulas_erradas(turno, disciplina, 1);
              }
              else{
                marca_aulas_erradas(turno, disciplina, 0);
              }
            }
          }
        }
      }
      else if(turno == 'M'){
        for (var aula = 1; aula <= 4; aula++) {

          for (var dia = 1; dia <= 5; dia++) {
            qtd_aulas = $("#horario"+aula+dia).find('option:selected').data('ch');
            disciplina = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina != 0){
              soma_aulas ++;
              qtd_aulas_atribuidas = verifica_aulas_disciplinas(disciplina, turno);
            
              if(qtd_aulas_atribuidas != qtd_aulas){
                marca_aulas_erradas(turno, disciplina, 1);
              }
              else{
                marca_aulas_erradas(turno, disciplina, 0);
              }
            }
          }
        }
      }
      else if(turno == 'T'){
        for (var aula = 5; aula <= 8; aula++) {

          for (var dia = 1; dia <= 5; dia++) {
            qtd_aulas = $("#horario"+aula+dia).find('option:selected').data('ch');
            disciplina = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina != 0){
              soma_aulas ++;
              qtd_aulas_atribuidas = verifica_aulas_disciplinas(disciplina, turno);
            
              if(qtd_aulas_atribuidas != qtd_aulas){
                marca_aulas_erradas(turno, disciplina, 1);
              }
              else{
                marca_aulas_erradas(turno, disciplina, 0);
              }
            }
          }
        }
      }
      else if(turno == 'N'){
        for (var aula = 9; aula <= 12; aula++) {

          for (var dia = 1; dia <= 5; dia++) {
            qtd_aulas = $("#horario"+aula+dia).find('option:selected').data('ch');
            disciplina = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina != 0){
              soma_aulas ++;
              qtd_aulas_atribuidas = verifica_aulas_disciplinas(disciplina, turno);
            
              if(qtd_aulas_atribuidas != qtd_aulas){
                marca_aulas_erradas(turno, disciplina, 1);
              }
              else{
                marca_aulas_erradas(turno, disciplina, 0);
              }
            }
          }
        }
      }

      if(soma_aulas != total){

        $('#table-1').css({"color": "#a94442"});
        $("#table-1").text('É necessário ter '+total+' aulas na semana para essa turma. E possui '+soma_aulas+' aula(s) selecionada(s)!!');

        $('#table-2').css({"color": "#a94442"});
        $("#table-2").text('É necessário ter '+total+' aulas na semana para essa turma. E possui '+soma_aulas+' aula(s) selecionada(s)!!');

        return false;
      }
      else{
        $("#table-1").text('');
        
        $("#table-2").text('');
        return true;  
      }

    };

    function marca_aulas_erradas(turno, $disciplina, situacao){
      var disciplina_atual;

      if(turno == 'D'){
        for (var aula = 1; aula <= 8; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina_atual == $disciplina && situacao == 1){
              $("#horario"+aula+dia).parent().addClass('has-error');
            }
            else{
              $("#horario"+aula+dia).parent().removeClass('has-error');
            }
          }
        }
      }
      else if(turno == 'M'){
        for (var aula = 1; aula <= 4; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina_atual == $disciplina && situacao == 1){
              $("#horario"+aula+dia).parent().addClass('has-error');
            }
            else{
              $("#horario"+aula+dia).parent().removeClass('has-error');
            }
          }
        }
      }
      else if(turno == 'T'){
        for (var aula = 5; aula <= 8; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina_atual == $disciplina && situacao == 1){
              $("#horario"+aula+dia).parent().addClass('has-error');
            }
            else{
              $("#horario"+aula+dia).parent().removeClass('has-error');
            }
          }
        }
      }
      else if(turno == 'N'){
        for (var aula = 9; aula <= 12; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();

            if(disciplina_atual == $disciplina && situacao == 1){
              $("#horario"+aula+dia).parent().addClass('has-error');
            }
            else{
              $("#horario"+aula+dia).parent().removeClass('has-error');
            }
          }
        }
      }
    }

    function verifica_aulas_disciplinas(disciplina, turno){
      var qtd_aulas_atribuidas = 0;
      var disciplina_atual = 0;

      if(turno == 'D'){
        for (var aula = 1; aula <= 8; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();
            
            if(disciplina_atual == disciplina){
              qtd_aulas_atribuidas ++;
            }
          }
        }
      }
      else if(turno == 'M'){
        for (var aula = 1; aula <= 4; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();
            
            if(disciplina_atual == disciplina){
              qtd_aulas_atribuidas ++;
            }
          }
        }
      }
      else if(turno == 'T'){
        for (var aula = 5; aula <= 8; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();
            
            if(disciplina_atual == disciplina){
              qtd_aulas_atribuidas ++;
            }
          }
        }
      }
      else if(turno == 'N'){
        for (var aula = 9; aula <= 12; aula++) {
          for (var dia = 1; dia <= 5; dia++) {
            disciplina_atual = $("#horario"+aula+dia).find('option:selected').val();
            
            if(disciplina_atual == disciplina){
              qtd_aulas_atribuidas ++;
            }
          }
        }
      }

      return qtd_aulas_atribuidas;
    };

    function verifica_professor(){
      var qtd_disciplinas = $("#titulo").data('qtd_disciplina');
      var disciplina_id;
      var professor_id;
      var erros = 0;

      for (var i = 1; i <= qtd_disciplinas; i++) {
        disciplina_id = $('#disciplina'+i).data('id');
        professor_id =  $('#professor'+disciplina_id).find('option:selected').val();

        if(professor_id == 0){
          $(".professor"+disciplina_id).addClass('has-error');
          $('#professor'+disciplina_id+disciplina_id).text('Selecione um professor para a disciplina:\n'+$('#disciplina'+i).val());
          erros++; 
        }
        else{
          if(verifica_qtd_professor(professor_id, qtd_disciplinas) >2){
            $(".professor"+disciplina_id).addClass('has-error');
            $('#professor'+disciplina_id+disciplina_id).text('O professor selecionado não pode ter mais de 2 disciplinas associadas');
            erros++; 
          }
          else{
            $(".professor"+disciplina_id).removeClass('has-error');
            $('#professor'+disciplina_id+disciplina_id).text(''); 
          }
        }
      }
      return erros;
    };

    function verifica_qtd_professor(professor, disciplinas){
      var professor_atual;
      var disciplina_id;
      var qtd_professor = 0;

      for (var i = 1; i <= disciplinas; i++) {
        disciplina_id = $('#disciplina'+i).data('id');
        professor_atual =  $('#professor'+disciplina_id).find('option:selected').val();

        if(professor_atual == professor){

          qtd_professor++;
        }
      }

      return qtd_professor;
    }

  });

</script>