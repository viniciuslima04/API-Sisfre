<script type="text/javascript">
    
  $(document).ready(function() {

      $('select').on('change', function(event) {
          var valor  = $(this).find('option:selected').val();
          var nome   = $(this).attr('name');
          var token  = $("input[name='_token']").val();
          var turma  = $('#turma1').find('option:selected').val();

          switch(nome) {
              case 'curso':
                  falta_resetaDisciplinas();
                  falta_resetaProfessores();
                  falta_resetaTurmas();
                  if(valor != '0'){
                    falta_getTurmas(valor, token);
                  }
                  break;
              case 'turma':
                  falta_resetaDisciplinas();
                  falta_resetaProfessores();
                  if(valor != '0'){
                    falta_getProfessores(valor, token);
                  }
                  break;
              case 'professor':
                  falta_resetaDisciplinas();
                  if(valor != '0'){
                    falta_getDisciplinas(turma, valor, token);
                  }
                  break;          
          }
      });

      function falta_getTurmas(curso, token){
        var professor  = $('#professor').find('option:selected').val();
        var disciplina = $('#disciplina1').find('option:selected').val();

        $.ajax({
             url: "{{ route('ajax.turma') }}",
             method: 'POST',
             data: {curso_id:curso, _token:token},
            error: function(result){
              falta_exibe_modal(result.responseJSON.response);
            },
            success: function(result) {

                 $("select[name='turma']").empty();
                 $("select[name='professor']").empty();
                 $("select[name='disciplina']").empty();

                 $("select[name='turma']").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>');
                 
                 if(professor == '0'){
                    $("select[name='professor']").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>');
                  }
                  if(disciplina == '0'){
                    $("select[name='disciplina']").append('<option data-tokens="ketchup mustard" value="0"> --- SELECIONE A TURMA --- </option>');
                  }
              $("#turma1").prop('disabled', false);
              $("#turma1").html('');
              $("#turma1").html(result.options);
            }
        });
      }

      function falta_getProfessores(turma, token){
        var disciplina = $('#disciplina1').find('option:selected').val();
        $.ajax({
             url: "{{ route('ajax.professor') }}",
             method: 'POST',
             data: {turma_id:turma, _token:token},
            error: function(result){
                falta_exibe_modal(result.responseJSON.response);
            },
            success: function(result) {
              $("select[name='professor']").empty();
              $("select[name='disciplina']").empty();

              $("select[name='professor']").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O PROFESSOR --- </option>');

              if(disciplina == '0'){
                $("select[name='disciplina']").append('<option data-tokens="ketchup mustard" value="0"> --- SELECIONE O PROFESSOR --- </option>');
              }

              $("#professor").prop('disabled', false);
              $("#professor").html('');
              $("#professor").html(result.options);
            }
        });
      }

      function falta_getDisciplinas(turma,professor,token){
        $.ajax({
             url: "{{ route('ajax.disciplina.professor') }}",
             method: 'POST',
             data: {turma_id:turma, _token:token,professor_id:professor},
            error: function(result){
               falta_exibe_modal(result.responseJSON.response);
            },
              success: function(result) {
                $("#disciplina1").prop('disabled', false);
                $("#disciplina1").html('');
                $("#disciplina1").html(result.options);
              }
        });
      }

      function falta_resetaTurmas(){
          $("#turma1").prop('disabled', true);
          $("#turma1").html('');
          $("#turma1").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>');
      }

      function falta_resetaProfessores(){
          $("#professor").prop('disabled', true);
          $("#professor").html('');
          $("#professor").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>');
      }

      function falta_resetaDisciplinas(){
          $("#disciplina1").prop('disabled', true);
          $("#disciplina1").html('');
          $("#disciplina1").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE O CURSO --- </option>');
      }

      function falta_carrega_selects(){
        var curso      = $('#curso').find('option:selected').val();
        var turma      = $('#turma1').find('option:selected').val();
        var professor  = $('#professor').find('option:selected').val();
        var disciplina = $('#disciplina1').find('option:selected').val();
        var token      = $("input[name='_token']").val();
            
        if(curso != '0'){
          if(turma == '0'){
            falta_getTurmas(curso, token);
          }
        }
  
        if(turma != '0'){
            if(professor == '0'){
              falta_getProfessores(turma, token);
            }
        }

        if(professor != '0'){
          if(disciplina =='0'){
            falta_getDisciplinas(turma,professor,token);
          }
        }
      };

      function falta_exibe_modal(mensagem){

        $("#modal_confirmar_remover").on('show.bs.modal', function(event){
            $(this).find('#modal-title').text('INFORME A(O) COORDENADOR(A) DO CURSO');
            $(this).find('#texto').text(mensagem);
            $(this).find('#modal-footer').empty();
        });

        $("#modal_confirmar_remover").modal('show');
      }
      falta_carrega_selects();
  });
    
</script>