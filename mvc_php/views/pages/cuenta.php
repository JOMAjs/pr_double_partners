
<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            Panel Control
        </div>
        <div class="card-body" id="body-info">
            <button class="btn btn-success btn-sm btn_button">Crear Cliente</button>
            <table class="table table-hover  mt-2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>nombre</th>
                        <th>email</th>
                        <th>telefono</th>
                        <th>acciones</th>
                    </tr>
                </thead>
                <tbody id="action"></tbody>
            </table>
        </div>
    </div>
</div>

<!--modals create y edit -->
<div class="modal fade" id="mdlCuenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Cuenta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="formulario_cuenta">
                <form id="form-cuenta" method="POST">
                    <input type="hidden" name="id" id="hidden">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="telefono">telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <button class="btn btn-sm btn-success crateCuenta float-right">SaveAll</button>
                    <button type="button" class="btn btn-secondary btn-sm float-left" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--script para cerate todo -->

<script>
    function loadCuentaTabla() {
        $.ajax({
            url: "http://127.0.0.1:8000/api/cuenta",
            method: "GET",
            data: {},
            success: function(response) {
                var resul = response;
                var cont = "";
                $.each(resul, function(index, value) {
                    cont += '<tr>' +
                        '<td>' + value.id + '</td>' +
                        '<td><span>' + value.nombre + '</span></td>' +
                        '<td><span >' + value.email + '</span></td>' +
                        '<td><span>' + value.telefono + '</span></td>' +
                        '<td><button class="btn btn-info btn-sm pedido" data-cuenta_id="' + value.id + '">pedidos</button> ' +
                        '<button class="btn btn-success btn-sm btn_button" data-cuenta_id="' + value.id + '"><i class="fas fa-edit"></i></button> ' +
                        '<button class="btn btn-danger btn-sm btn_delete" data-cuenta_id="' + value.id + '"><i class="fas fa-trash"></i> </button></td>' +
                        '</tr>';
                });
                $("#action").html(cont);
            }
        });
    }

    loadCuentaTabla();

    $("#form-cuenta").validate({

        submitHandler: function() {

            $.ajax({
                method: "POST",

                url: "http://localhost:8000/api/cuenta",
                data: $("#form-cuenta").serialize(),
                success: function(result) {
                    //$("#formulario_cuenta").html(result);
                    $("#mdlCuenta").modal('hide');
                    loadCuentaTabla();
                    $("#form-cuenta")[0].reset();
                    $.toast({
                        heading: 'Mensaje del sistema',
                        text: 'Se registro completamete',
                        position: 'bottom-right',
                        stack: false,
                        icon: 'success'
                    });
                },
                error: function(obj, typeError, text, data) {

                }
            });
            //form.submit();
            return false;
        },
        rules: {
            nombre: {
                required: true,
                //minlength: 5,
            },
            telefono: {
                required: true,
            },

            email: {
                required: true,
            },

        },
        highlight: function(element, errorClass) {
            $(element).parent().addClass('has-feedback has-error');
            $(element).parent().removeClass('has-feedback has-success');
        },
        unhighlight: function(element, errorClass) {
            $(element).parent().removeClass('has-feedback has-error');
            $(element).parent().addClass('has-feedback has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass("no-label")) {

            } else if (element.parents('.input-group').length > 0) {
                error.insertAfter(element.parents('.input-group'));
            } else if (element.parents('.form-group').find('.chosen-container').length > 0) {

            } else if (element.parents('.radio').find('.chosen-container').length > 0) {
                error.insertAfter(element.parents('.radio').find('.chosen-container'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    $(document).on("click", ".pedido", function() {
        var pedido = $(this).data("cuenta_id");
        if (Number(pedido)) {
            $.ajax({
                url: "http://127.0.0.1:8000/api/cuenta-show",
                method: "POST",
                data: {
                    id: pedido
                },
                success: function(response) {
                    var url = "pedido.php";
                    var id = response['id'];
                    var nombre = response['nombre'];
                    var email = response['email'];
                    var telefono = response['telefono'];
                    $.ajax({
                        url: "views/pages/pedido.php",
                        method: "POST",
                        data: {
                            nombre: nombre,
                            id: id
                        },
                        success: function(resul) {
                            $("#body-info").html(resul);
                            
                        }

                    })
                }
            })
        }
    })

    $(document).on("click", ".btn_button", function() {
        var id = $(this).data("cuenta_id");
        $.ajax({
            url: "views/pages/formulario.php",
            method: "POST",
            data: {
                id: id
            },
            success: function(response) {

                //$("#formulario_cuenta").html(response);
                $("#mdlCuenta").modal("show");

                if (Number(id)) {
                    $.ajax({
                        url: "http://127.0.0.1:8000/api/cuenta-show",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $("#hidden").val(response['id']);
                            $("#nombre").val(response['nombre']);
                            $("#email").val(response['email']);
                            $("#telefono").val(response['telefono']);
                        }

                    })
                }
            }
        })
    });

    $(document).on("click", ".btn_delete", function() {
        var id = $(this).data("cuenta_id");
        var confirmacion = window.confirm("desea eliminar esta cuenta");
        if (confirmacion) {

            $.ajax({
                url: 'http://127.0.0.1:8000/api/cuenta/' + id,
                method: "DELETE",
                success: function(response) {
                    $.toast({
                        heading: 'Mensaje del sistema',
                        text: 'Se ha eliminado',
                        position: 'bottom-right',
                        stack: false,
                        icon: 'success'
                    });

                }

            });

        } else {

            $.toast({
                heading: 'Mensaje del sistema',
                text: 'Se ha eliminado',
                position: 'bottom-right',
                stack: false,
                icon: 'danger'
            });

        }
    });

    var table = $("table").DataTable({
        scrollY: "400px",
        scrollX: true,
        paging: false,
        "bAutoWidth": false,
        "aaSorting": [],
        "searching": false,
        "language": {
            "url": "vendor/datatables/Spanish.json",

        },
    });
</script>