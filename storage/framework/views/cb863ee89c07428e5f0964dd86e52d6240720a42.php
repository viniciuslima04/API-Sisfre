<script type="text/javascript">
    
    $(document).ready(function() {
    	
        var ajax = suporte_ajax();
        var sse  = suporte_sse();

        // VERIFICAR SE O BROSWER DO USUÁRIO SUPORTA SSE, CASO CONTRÁRIO EXIBE ALERTA
        if(sse == false) {
            $("#modal_sse").on('show.bs.modal', function(event){ 
                $(this).find('#texto').text('O seu Broswer não dá suporte a Server-sent events(SSE).\nPortanto será necessário ficar atualizando para recuperação de alterações do sistema!!');
            });

            $('#modal_sse').modal('show');
        }

        //VERIFICA SE O BROSWER DO USUÁRIO SUPORTA AJAX, CASO CONTRÁRIO EXIBE ALERTA

        if(ajax == false){
            $("#entrar").prop('disabled', true);
            $("#modal_sse").on('show.bs.modal', function(event){ 
                $(this).find('#texto').text('O seu Broswer não dá suporte a requisições AJAX.Sendo essa parte fundamental para o funcionamento do sistema. Atualize seu Broswer, Por favor. E desculpe o transtorno');
            });

            $('#modal_sse').modal('show');
        }

    });

    function suporte_ajax(){

        var xmlHttp;

        try{
            // Firefox, Opera 8.0+, Safari
            xmlHttp=new XMLHttpRequest();
            return true;
        }
        catch (e){

            // Internet Explorer
            try{
                xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                return true;
            }
            catch (e){

                try{
                    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                    return true;
                }
                catch (e){
                    return false;
                }
            }
        }
    }

    function suporte_sse(){
        return typeof(EventSource) !== "undefined";
    }

</script>