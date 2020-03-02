<script type="text/javascript">
    
  $(document).ready(function() {

    $("#cadDisc").on("submit", function(e) {
      
      var disciplina = $(this).find('#disciplina').val();
      var sigla = $(this).find('#sigla').val();

      var curso0 = $(this).find('#curso0').find('option:selected').val();
      var duracao0 = $(this).find('#periodo0').find('#titulo').data('duracao');
      var val_periodo = 0;

      var cursos = $(this).find('#curso0').data('cursos');
      var valor = $('#option').prop('checked');
      var quantidade = $('#qtd').val();

      var val_sigla = valida_sigla(sigla);
      var val_disci = valida_disciplina(disciplina);
      var val_curso = valida_curso(curso0,0,0);
      
      if(val_curso == 0){
         val_periodo = val_periodo + valida_periodo(duracao0, curso0, 0);
      }

      if(valor == true){
        var curso;
        var id;
        var idd;
        var duracao;
        var val_quant = valida_quantidade(quantidade, cursos);

        if(val_quant == false){
          for (var i = 1; i <= quantidade; i++) {
            curso = $(this).find("#curso"+i).find('option:selected').val();
            val_curso = val_curso + valida_curso(curso,i,quantidade);
            if(val_curso == 0){
              duracao = $(this).find('#periodo'+i).find('#titulo').data('duracao');
              val_periodo = val_periodo + valida_periodo(duracao, curso, i);
            }
          }
        }

        if(val_sigla == false && val_disci == false && val_curso == 0 && val_periodo == 0 && val_quant == false ){
          return true; 
        }
        else{
          return false;
        }
      }

      if(val_sigla == false && val_disci == false && val_curso == 0 && val_periodo == 0){
        return true; 
      }
      else{
        return false;
      }
      
    });

  });

    function esconde_exibe_qtd(){
      var valor = $('#option').prop('checked');

        if(valor == true){

        }
        else{
           $("#esconder").hide();
           $("#addCursos").html('');
           $('#qtd').val('')
       }
    };

  function valida_periodo(duracao, curso, num){
    var qtd = 0;
    var semestre;

    for (var i = 1; i <= duracao; i++) {
      semestre = $('#periodo'+curso+i).val();

      if(semestre == 0 || semestre == ''){
        qtd = qtd+1;
      }
    }

    if(qtd == duracao){
        $('#periodo'+num).addClass('has-error');
        $('#periodo'+curso+curso+curso).css({"color": "#a94442"});
        $('#periodo'+curso+curso+curso).text('Ao menos um semestre dever conter aulas da disciplina!!');

        return 1;
    }else{
      var val_valor = 0;

        for (var i = 1; i <= duracao; i++) {
          semestre = $('#periodo'+curso+i).val();
          if(semestre!= 0 || semestre != ''){
            val_valor = val_valor + valida_valor(semestre,curso,i);
          }
          else{
            $('#periodo'+curso+i).removeClass('has-error');
          }
        }
        if(val_valor == 0){
          $('#periodo'+num).removeClass('has-error');
          $('#periodo'+curso+curso+curso).text('');
          return 0;
        }
        return 1;
    }
    return 0;
  }

  function valida_valor(semestre,curso,i){

    if(isNumeric(semestre)){

      if(semestre <= 0 || semestre > 6){
        $('.periodo'+curso+i).addClass('has-error');
        $('#periodo'+curso+curso+curso).css({"color": "#a94442"});
        $('#periodo'+curso+curso+curso).text('Informe um valor maior que zero e menor que 7');
        return 1;
      }
      else{
        $('.periodo'+curso+i).removeClass('has-error');
        $('#periodo'+curso+curso+curso).text('');
      }
    }
    else{
      $('.periodo'+curso+i).addClass('has-error');
      $('#periodo'+curso+curso+curso).css({"color": "#a94442"});
      $('#periodo'+curso+curso+curso).text('Informe um valor númerico');
      return 1;
    }

    $('.periodo'+curso+i).removeClass('has-error');
    $('#periodo'+curso+curso+curso).text('');
    
    return 0;
  };

  function valida_quantidade(quantidade, cursos){
      if(quantidade == ''){
        $('.qtd').addClass('has-error');
        $('#qtd1').text('Informe um valor maior que zero!!'); 
        return true;
      }
      else{
        $('.qtd').removeClass('has-error');
        $('#qtd1').text('');
      }

      if(isNumeric(quantidade) == false){
        $('.qtd').addClass('has-error');
        $('#qtd1').text('Informe um valor númerico!!'); 
        return true;
      }
      else{
        $('.qtd').removeClass('has-error');
        $('#qtd1').text('');
      }

      if(quantidade >= cursos){
        $('.qtd').addClass('has-error');
        $('#qtd1').text('O valor deve ser menor que '+cursos); 
        return true;
      }
      else{
        $('.qtd').removeClass('has-error');
        $('#qtd1').text('');
      }
      return false;
  };

  function valida_disciplina(disciplina){
      if(disciplina == ''){
        $('.disciplina').addClass('has-error');
        $('#disciplina1').text('Não deixe esse campo vazio!!'); 
        return true;
      }else{
        $('.disciplina').removeClass('has-error');
        $('#disciplina1').text('');
      }

      if(disciplina.length < 6){
        $('.disciplina').addClass('has-error');
        $('#disciplina1').text('O nome da disciplina deve possuir ao menos 6 letras');
        return true; 
      }else{
        $('.disciplina').removeClass('has-error');
        $('#disciplina1').text('');
      }

       return false;
  };

  function valida_sigla(sigla){
      if(sigla == ''){
        $('.sigla').addClass('has-error');
        $('#sigla1').text('Não deixe esse campo vazio!!'); 
        return true;
      }else{
        $('.sigla').removeClass('has-error');
        $('#sigla1').text('');
      }

      if(sigla.length < 3){
        $('.sigla').addClass('has-error');
        $('#sigla1').text('A sigla da disciplina deve possuir ao menos 3 letras');
        return true; 
      }else{
        $('.sigla').removeClass('has-error');
        $('#sigla1').text('');
      }

      if(sigla.length > 8){
        $('.sigla').addClass('has-error');
        $('#sigla1').text('A sigla da disciplina não deve possuir mais que 8 letras');
        return true; 
      }else{
        $('.sigla').removeClass('has-error');
        $('#sigla1').text('');
      }
      return false;
  };

  function valida_curso(curso,num,quantidade){
    if(curso <= 0){
        $('.curso'+num).addClass('has-error');
        $('#curso'+num+num).text('Selecione o curso'); 
        return 1;
    }else{
          $('.curso'+num).removeClass('has-error');
          $('#curso'+num+num).text('');
    }

    if(curso > 0 && quantidade != 0){
      var cursoTeste;
      var qtd = 0;

      for (var i = 0; i <= quantidade; i++) {
        if(i != num){
          cursoTeste = $("#curso"+i).find('option:selected').val();
           if(curso == cursoTeste){
            $('.curso'+i).addClass('has-error');
            $('#curso'+i+i).text('Não pode selecionar o mesmo curso mais de uma vez!!');
            qtd = qtd + 1;
          }
        }
      }

      if(qtd != 0){
          $('.curso'+num).addClass('has-error');
          $('#curso'+num+num).text('Não pode selecionar o mesmo curso mais de uma vez!!');
          return 1;
      }
      else{
          $('.curso'+num).removeClass('has-error');
          $('#curso'+num+num).text('');

          for (var i = 1; i <= quantidade; i++) {
            cursoTeste = $(this).find("#curso"+i).find('option:selected').val();

            $('.curso'+i).removeClass('has-error');
            $('#curso'+i+i).text('');
          }
      }
    }
    return 0;
  };

  function isNumeric(str) {  
     var er = /^[0-9]+$/;  
     return (er.test(str));
  };


</script>