<script type="text/javascript">
    
    $(document).ready(function() {

         //Função que exibe/esconde a quantidade de cursos
        function esconde_exibe_cursos(){
            var valor = $('#option').prop('checked');
            var quantidade = $('#qtd').val();
            var cursos = $('#curso0').data('cursos');

            if(valor == true && quantidade != 0 && quantidade < cursos){

                var token = $("input[name='_token']").val();

                $.ajax({
                     url: "<?php echo e(route('ajax.associaCurso')); ?>",
                     method: 'POST',
                     data: {quantidade:quantidade, _token:token},
                    error: function(result){
                          alert(result.responseJSON.response);
                    },
                    success: function(result) {
                        $("#addCursos").html('');
                        $("#addCursos").html(result.options);
                    }
                });
             }
            else{
                $("#addCursos").html('');
            }
        };

        // Chamada da função ao indicar a quantidade de cursos
        $('#qtd').on('keyup', function(event) {
            esconde_exibe_cursos();
        });

         //Função que exibe/esconde a quantidade de cursos
        function esconde_exibe_qtd(){
          var valor = $('#option').prop('checked');

            if(valor == true){
               $("#esconder").show();
            }
            else{
               $("#esconder").hide();
               $("#addCursos").html('');
               $('#qtd').val('')
           }
        };

         //Função que exibe/esconde a quantidade de cursos ao mudar o valor do checkbox
        $('#option').on('change', function(event) {
            esconde_exibe_qtd();
        });

        function esconde_exibe_semestres(campo){
            var select = campo;
            if(select == undefined){
              select = $("select[name='curso[]']");
            }
            var quantidade = $('#qtd').val();
            var selectName = select.attr('name');
            var periodo = select.data('periodo');
            var num = select.data('num');
            var cursoTeste;
            var qtd = 0;
            var curso_id = select.find('option:selected').val();


            if(selectName == "curso[]"){
              for (var i = 0; i <= quantidade; i++) {
                if(i != num){
                  cursoTeste = $("#curso"+i).find('option:selected').val();
                  if(curso_id == cursoTeste){
                    qtd = qtd + 1;
                  }
                }
              }

              if(select.val() != '0' && qtd == 0){

                  var token = $("input[name='_token']").val();

                  $.ajax({
                       url: "<?php echo e(route('ajax.semestre')); ?>",
                       method: 'POST',
                       data: {curso_id:curso_id, _token:token},
                      error: function(result){
                            alert(result.responseJSON.response);
                      },
                      success: function(result) {
                          $(periodo).html('');
                          $(periodo).html(result.options);
                      }
                  });
              }else{
                  $(periodo).html(''); 
              } 
            }
        }
         //Função que exibe/esconde os semestres de determinado curso ao mudar de opção
        $(document).on('change','select', function(event) {
            esconde_exibe_semestres($(this));
        });



          //EM CONSTRUÇÃO

        function esconde_exibe_optativas(inputPeriodo){
            if(inputPeriodo != undefined && inputPeriodo.length > 0){
              var periodo = inputPeriodo.data('periodo');
              alert(periodo);
            }
        }

        $('.disciplina-optativa').on('change', function(event) {
            alert($(this));
            esconde_exibe_optativas($(this));
        });

    });
    
</script>