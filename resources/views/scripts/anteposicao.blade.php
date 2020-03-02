<script type="text/javascript">
    
    $(document).ready(function() {

        function anteposicao_getDisciplinas(professor, turma, token){     
            $.ajax({
                 url: "{{ route('ajax.disciplina.professor') }}",
                 method: 'POST',
                 data: {turma_id:turma, _token:token,professor_id:professor},
                error: function(result){
                    alert(result.responseJSON.response);
                },
                  success: function(result) {
                    $("#disciplina3").prop('disabled', false);
                    $("#disciplina3").html('');
                    $("#disciplina3").html(result.options);
                  }
            });
        };

        function anteposicao_resetaDisciplinas(){
              $("#disciplina3").prop('disabled', true);
              $("#disciplina3").html('');
              $("#disciplina3").append('<option data-tokens="ketchup mustard" value="0" selected> --- SELECIONE A TURMA --- </option>');
        };

        $('#turma3').on('change', function(event) {
            var professor   = $('#nome').data('id');
            var turma       = $('#turma3').find('option:selected').val();
            var token       = $("input[name='_token']").val();

            anteposicao_resetaDisciplinas();
            anteposicao_getDisciplinas(professor, turma, token);
        });

        function anteposicao_carrega_selects(){
            var professor   = $('#nome').data('id');
            var turma       = $('#turma3').find('option:selected').val();
            var token       = $("input[name='_token']").val();
            var disciplina  = $('#disciplina3').find('option:selected').val();

            if(turma != '0' && disciplina == '0'){
                anteposicao_getDisciplinas(professor, turma, token);
            }
        }

        anteposicao_carrega_selects();

    });   
</script>
