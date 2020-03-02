$('select[name=estado]').change(function () {
    var id_estado = $(this).val();

   // $('select[name=cidade]').html('').append('<option value="">  Carregando...  </option>');
    $.get('/cidades/' + id_estado, function (cidades) {
        $('select[name=cidade]').empty();
        $.each(cidades, function (key, value) {
            $('select[name=cidade]').append('<option value=' + value.id_cidade + '>' + value.nome + '</option>');
        });
    });
});
