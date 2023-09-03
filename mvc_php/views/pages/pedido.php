<h2>Cliente: <?php echo ($_POST['nombre']); ?></h2>
<h3 class=" total"></h3>

<button class="btn btn-success btn-sm btn_pedido">Crear Pedido</button>
<a href="index.php" class="btn btn-danger btn-sm float-right">Atras</a>

<table class="table table-hover  mt-2">
    <thead>
        <tr>
            <th>#</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Valor</th>
            <th>acciones</th>
        </tr>
    </thead>
    <tbody id="action"></tbody>
</table>


<!--modals create y edit -->
<div class="modal fade" id="mdlPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="formulario_cuenta">
                <form id="form-pedido" method="POST">
                    <input type="hidden" name="id" id="hidden">
                    <input type="hidden" name="cuenta_id" id="cuenta_id" value="<?php echo ($_POST['id']) ?>">
                    <div class="form-group">
                        <label for="producto">Nombre</label>
                        <input type="text" name="producto" id="producto" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="number" name="valor" id="valor" class="form-control">
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

    function loadPedidoTabla() {
        $.ajax({
            url: "http://127.0.0.1:8000/api/pedido-show",
            method: "POST",
            data: {
                id: <?php echo ($_POST['id']); ?>
            },
            success: function(response) {
                var resul = response;
                var cont = "";
                $.each(resul, function(index, value) {
                    cont += '<tr>' +
                        '<td>' + value.id + '</td>' +
                        '<td><span>' + value.producto + '</span></td>' +
                        '<td><span >' + value.cantidad + '</span></td>' +
                        '<td><span>' + value.valor + '</span></td>' +
                        '<td>' +
                        '<button class="btn btn-success btn-sm btn_pedido" data-pedido_id="' + value.id + '"><i class="fas fa-pencil-alt"></i> Edit</button> ' +
                        '<button class="btn btn-danger btn-sm delete_pedido" data-pedido_id="' + value.id + '"><i class="fas fa-trash"></i> Cancelar</button></td>' +
                        '</tr>';

                });

                $("#action").html(cont);
            }
        });

        $.ajax({
            url: "http://127.0.0.1:8000/api/show_total",
            method: "POST",
            data: {
                id: <?php echo ($_POST['id']); ?>
            },
            success: function(response) {
                var resul = response;
                var cont = "";
                $.each(resul, function(index, value) {
                    cont += '<h3 class="float-right text-success">Total. $' + value.total + '</h4><br>' 
                });

                $(".total").html(cont);
            }
        });

    }

    loadPedidoTabla();

    $("#form-pedido").validate({

        submitHandler: function() {

            $.ajax({
                method: "POST",
                url: "http://localhost:8000/api/pedido-create",
                data: $("#form-pedido").serialize(),
                success: function(result) {
                    //$("#formulario_cuenta").html(result);
                    $("#mdlPedido").modal('hide');
                    loadPedidoTabla();
                    $("#form-pedido")[0].reset();
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
            producto: {
                required: true,
                //minlength: 5,
            },
            cantidad: {
                required: true,
            },

            valor: {
                required: true,
            },

            cuenta_id: {
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

    $(document).on("click", ".btn_pedido", function() {
        var id = $(this).data("pedido_id");
        $.ajax({
            url: "views/pages/formulario.php",
            method: "POST",
            data: {
                id: id
            },
            success: function(response) {

                $("#mdlPedido").modal("show");

                if (Number(id)) {
                    $.ajax({
                        url: "http://127.0.0.1:8000/api/pedido-edit",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            $("#hidden").val(response['id']);
                            $("#producto").val(response['producto']);
                            $("#cantidad").val(response['cantidad']);
                            $("#valor").val(response['valor']);
                            loadPedidoTabla();
                        }

                    })
                }
            }
        })
    });

    $(document).on("click", ".delete_pedido", function() {
        var id = $(this).data("pedido_id");
        var confirmacion = window.confirm("desea eliminar esta cuenta");
        if (confirmacion) {

            $.ajax({
                url: 'http://127.0.0.1:8000/api/pedido/' + id,
                method: "DELETE",
                success: function(response) {
                   loadPedidoTabla();
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
