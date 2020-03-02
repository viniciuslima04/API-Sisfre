<script type="text/javascript">
    
    $(document).ready(function() {

        // MODAL DE EXCLUSÃO GERAL
        $("#modal").on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var entidade = button.data('entidade');
            var entidadeM = entidade.toUpperCase();
            var url = button.data('url');

            $(this).find('.modal-title').text('DESEJA REALMENTE EXCLUIR ESSA(ESSE) '+entidadeM+' ?');
            $(this).find('.modal-body').text('Se você clicar em "SIM" o registro da(o) '+entidade+' será removida(o) de forma definitiva do sistema !!');
            $('#sim').attr('href',url);

        });

        // MODAL DE CONFIRMAÇÃO OU NÃO DE FALTAS/REPOSIÇÕES/ANTEPOSIÇÕES
        $("#modal_confirmar_remover").on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var entidade = button.data('entidade');
            var url = button.data('url');
            var modo = button.data('modo');

            if(modo == 'remover'){

                if(entidade == 'falta'){
                    $(this).find('.modal-title').text('DESEJA REALMENTE CANCELAR ESSA FALTA?');
                    $(this).find('#texto').text('Se você clicar em "SIM" o registro da falta será removido de forma definitiva do sistema !!');
                }
                else if(entidade == 'reposicao'){
                    $(this).find('.modal-title').text('DESEJA REALMENTE CANCELAR ESSA REPOSIÇÃO?');
                    $(this).find('#texto').text('Se você clicar em "SIM" o registro da reposição será removido do sistema !!');
                }
                else{
                    $(this).find('.modal-title').text('DESEJA REALMENTE CANCELAR ESSA ANTEPOSIÇÃO?');
                    $(this).find('#texto').text('Se você clicar em "SIM" o registro da anteposição será removido do sistema !!');
                }
            }
            else if(modo == 'confirmar'){
                if(entidade == 'falta'){
                    $(this).find('.modal-title').text('DESEJA REALMENTE CONFIRMAR ESSA FALTA?');
                    $(this).find('#texto').text('Se você clicar em "SIM" o registro da falta ficará disponível para o professor marcar a reposição da mesma ou em caso de existir alguma anteposição do professor para essa turma nessa disciplina irá verificar se a falta mudará sua situação para totalmente paga ou parcialmente paga!!');
                }
                else if(entidade == 'reposicao'){
                    $(this).find('.modal-title').text('DESEJA REALMENTE CONFIRMAR ESSA REPOSIÇÃO?');
                    $(this).find('#texto').text('Se você clicar em "SIM", o sistema automaticamente irá verificar se a falta foi totalmente paga ou parcialmente paga');
                }
                else{
                    $(this).find('.modal-title').text('DESEJA REALMENTE CONFIRMAR ESSA ANTEPOSIÇÃO?');
                    $(this).find('#texto').text('Se você clicar em "SIM", o registro da anteposição mudará sua situação para confirmada, e o sistema automaticamente irá verificar se o professor da anteposição está inadimplente com a turma nessa disciplina e fará a reposição das aulas faltosas parcialmente ou totalmente');
                }
            }

            $(this).find('#sim').attr('href',url); 

        });

    });   
</script>