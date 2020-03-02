$(document).ready(function() {



    $('select').on('change', function(event) {
        
        var select = $(this);

        var selectName = select.attr('name');
        
        if(selectName == "tipo"){
            
            if(select.val() != '0'){
                
                var tipo_curso = select.val();
                var token = $("input[name='_token']").val();

                    $.ajax({
                         url: "{{ route('ajax.curso') }}",
                         method: 'POST',
                         data: {tipo_curso:tipo_curso, _token:token},
                        error: function(){
                           alert('DEU ERRO CARALHO');
                        },
                        success: function(result) {

                             $("select[name='curso']").empty();

                             $("select[name='curso']").append('<option data-tokens="ketchup mustard" value="0"> --- Selecione o curso --- </option>');
                             $.each(result, function(index,curso){
                                 $("select[name='curso']").append('<option data-tokens="ketchup mustard" value="'+curso.id+'">'+ curso.sigla + '- '+ curso.nome + '</option>');
                             });
                        }
                    });

                }
                else{
                        $("select[name='curso']").empty();
                        $("select[name='curso']").append('<option data-tokens="ketchup mustard" value="0"> --- Selecione o tipo --- </option>');  
                }  
        }

    }); 

});