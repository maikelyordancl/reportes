


<!-- jQuery 3 -->
<script src="<?=base_url('assets/adminlte')?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url('assets/adminlte')?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url('assets/adminlte')?>/plugins/iCheck/icheck.min.js"></script>

<!-- jQuery Confirm -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            beforeSend: function(xhr, settings) {
                if(settings.type == "POST"){
                    xhr.setRequestHeader("X-CSRFToken", $('[name="csrfmiddlewaretoken"]').val());
                }
            }
        });

        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('#form_login').submit(function( event ) {
            //alert( "Handler for .submit() called." );
            event.preventDefault();

            var form = $('#form_login');

            var action = $(form).attr('action');
            var method = $(form).attr('method');
            var remote_login = $("#remote_login").val();

            var text_btn = $("#btn_logon").text();

            $("#btn_logon").removeClass('btn-primary');
            $("#btn_logon").addClass('btn-default');
            $("#btn_logon").attr('disabled');
            $("#btn_logon").text('Iniciando sesión...');

            $.ajax({
                method: 'GET',
                url: remote_login,
                data: $(form).serialize(),
                dataType: "json"
            }).done(function( data ) {
                var result = data.datos[0];
                switch (result.resultado){
                    case "0": //LOGIN OK
                        $.ajax({
                            method: method,
                            url: action,
                            data: $(form).serialize()+"&user_id="+result.user_id,
                            dataType:"json"
                        }).done(function( msg ) {

                            switch (msg.status)
                            {
                                case "ok":
                                    window.location.href = msg.action;
                                    break;
                                case "error":
                                    $("#btn_logon").removeClass('btn-default');
                                    $("#btn_logon").addClass('btn-primary');
                                    $("#btn_logon").removeAttr('disabled');
                                    $("#btn_logon").text(text_btn);
                                    $.alert({
                                        theme: 'supervan',
                                        title: 'Oops!',
                                        content: msg.message,
                                    });
                                    break;
                            }
                        });
                        break;
                    case "1":
                        $("#btn_logon").removeClass('btn-default');
                        $("#btn_logon").addClass('btn-primary');
                        $("#btn_logon").removeAttr('disabled');
                        $("#btn_logon").text(text_btn);

                        $.alert({
                            theme: 'supervan',
                            title: 'Oops!',
                            content: result.mensaje,
                        });
                        break
                    case "2":
                        $("#btn_logon").removeClass('btn-default');
                        $("#btn_logon").addClass('btn-primary');
                        $("#btn_logon").removeAttr('disabled');
                        $("#btn_logon").text(text_btn);

                        $.alert({
                            theme: 'supervan',
                            title: 'Oops!',
                            content: result.mensaje,
                        });
                        break;
                }
            });
            return false;

        });
    });
</script>
</body>
</html>