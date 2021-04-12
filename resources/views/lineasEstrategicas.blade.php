@extends('layouts.adminlte')

@section('content')
    <div class="container-fluid">
        <div id="abm">
            {{csrf_field()}}
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h2 class="box-tittle">Tipologias de accion</h2>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="table" class="table table-hover">
                        </table>
                    </div>
                    <div class="box-footer">
                        @if(Auth::user()->id_provincia == 25)

                            <button class="btn btn-success pull-right" id="nueva_linea_estrategica"><i
                                        class="fa fa-plus"
                                        aria-hidden="true"
                                ></i>Nueva
                                tipologia de accion
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="alta" style="display: none;">
        </div>
    </div>
@endsection

@section('script')
    <!-- Moment.js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

    <script type="text/javascript">

        function createdAtValidDate(created_at) {
            var created_date = moment(created_at);
            var current_date = moment();

            diff = current_date.diff(created_date, 'days');

            return diff <= 7; // se creo la misma semana
        }

        function acciones(deleted_at, created_at, id) {
            buttons = '<a data-id="' + id + '" class="btn btn-circle editar" ' +
                'title="Editar" style="margin-right: 1rem;"><i class="fa fa-pencil" aria-hidden="true" style="color: dodgerblue;"></i></a>';

            if (deleted_at)
                buttons += '<a data-id="' + id + '" class="btn btn-circle darAlta" ' +
                    'title="Dar de alta" style="margin-right: 1rem;"><i class="fa fa-plus" aria-hidden="true" style="color: forestgreen;"></i></a>';
            else
                buttons += '<a data-id="' + id + '" class="btn btn-circle darBaja" ' +
                    'title="Dar de baja" style="margin-right: 1rem;"><i class="fa fa-minus" aria-hidden="true" style="color: firebrick;"></i></a>';

            if (createdAtValidDate(created_at))
                buttons += '<a data-id="' + id + '" class="btn btn-circle eliminar" ' +
                    'title="Eliminar" style="margin-right: 1rem;"><i class="fa fa-trash" aria-hidden="true" style="color: dimgray;"></i></a>';

            return buttons;
        }

        function getFormData() {
            data = $.merge(
                $('form').serializeArray(),
                [
                    {
                        name : 'ids_modalidad',
                        value: $('#modalidad').val()
                    },
                ]
            );

            console.log(data);

            return data;
        }

        $(document).ready(function () {

            $('#table').DataTable({
                scrollCollapse: true,
                ajax          : 'lineasEstrategicasTabla',
                columns       : [
                    {
                        title    : 'Numero',
                        data     : 'numero',
                        orderable: false
                    },
                    {
                        title: 'Nombre',
                        data : 'nombre'
                    },
                    {
                        title    : 'Modalidades',
                        data     : 'id_modalidad',
                        orderable: false,
                        render   : function (data, type, row, meta) {
                            var data = row.modalidades;
                            var concatenated = '';
                            for (var i in data) {
                                var r = data[i];
                                concatenated = concatenated + r.nombre + ', ';
                            }
                            return concatenated.slice(0, concatenated.length - 2);
                        }
                    },
                    {
                        title: 'Descripción',
                        data : 'descripcion',
                        width: '40%',
                    },
                        @if(Auth::user()->id_provincia == 25)
                    {
                        title : 'Acciones',
                        data  : 'deleted_at',
                        render: function (data, type, row, meta) {
                            return acciones(data, row.created_at, row.id_linea_estrategica);
                        }
                    }
                    @endif
                ]
            });

            $('#abm').on('click', '#nueva_linea_estrategica', function () {
                console.log("Test");
                $.ajax({
                    url    : 'lineasEstrategicas/alta',
                    method : 'get',
                    success: function (data) {
                        $('#alta').html(data);
                        $('#alta').show();
                        $('#abm').hide();
                    }
                });
            });

            $('#abm').on('click', '.editar', function () {

                var linea = $(this).data('id');

                $.ajax({
                    url    : 'lineasEstrategicas/' + linea,
                    method : 'get',
                    success: function (data) {
                        $('#alta').html(data);
                        $('#alta').show();
                        $('#abm').hide();
                    }
                });
            });

            $('#abm').on("click", ".eliminar", function () {
                var linea = $(this).data('id');
                var data = '_token=' + $('#abm input').first().val();
                jQuery('<div/>', {
                    id  : 'dialogABM',
                    text: ''
                }).appendTo('.container-fluid');

                $("#dialogABM").dialog({
                    title        : "Verificacion",
                    show         : {
                        effect: "fold"
                    },
                    hide         : {
                        effect: "fade"
                    },
                    modal        : true,
                    width        : 360,
                    height       : 220,
                    closeOnEscape: true,
                    resizable    : false,
                    dialogClass  : "alert",
                    open         : function () {
                        jQuery('<p/>', {
                            id  : 'dialogABM',
                            text: '¿Esta seguro que quiere dar de baja al tipo de accion?'
                        }).appendTo('#dialogABM');
                    },
                    buttons      :
                        {
                            "Aceptar" : function () {
                                $(this).dialog("destroy");
                                $("#dialogABM").html("");

                                console.log(linea);

                                $.ajax({
                                    url    : 'lineasEstrategicas/' + linea + '/hard',
                                    method : 'delete',
                                    data   : data,
                                    success: function (data) {
                                        console.log('Se borro la linea estrategica.');
                                        alert('Se borro la linea estrategica.');
                                        $('#table').DataTable().clear().draw();
                                    },
                                    error  : function (data) {
                                        alert("Hay un curso usando ese tipo de accion. No se puede borrar el registro");
                                        console.log('Hubo un error.');
                                        console.log(data);
                                        location.reload();
                                    }
                                });


                            },
                            "Cancelar": function () {
                                $(this).dialog("destroy");
                                $("#dialogABM").html("");
                                location.reload();
                            }
                        }
                });
            });

            $('#alta').on('click', '#modificar', function () {

                var linea = $(this).data('id');

                $.ajax({
                    url    : 'lineasEstrategicas/' + linea,
                    method : 'put',
                    data   : getFormData(),
                    success: function (data) {
                        console.log("Success.");
                        location.reload();
                    },
                    error  : function (data) {
                        console.log("Error.");
                    }
                });
            });

            $('#alta').on('click', '#volver', function () {
                $('#abm').show();
                $('#alta').hide();
                console.log('Vuelve sin hacer cambios.');
            });

            $('#alta').on('click', '#crear', function () {
                var validator = $('#alta #form-alta').validate({
                    rules        : {
                        nombre: {
                            required: true,
                        },
                        numero: {
                            required: true,
                            number  : true
                        }
                    },
                    messages     : {
                        nombre: "Campo obligatorio",
                        numero: "Tiene que ser un numero"
                    },
                    highlight    : function (element) {
                        console.log("highlight");
                        console.log(element);
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    success      : function (element) {
                        console.log("validate success");
                        $(element).text('').addClass('valid')
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            method : 'post',
                            url    : 'lineasEstrategicas',
                            data   : getFormData(),
                            success: function (data) {
                                console.log("Success.");
                                alert('Se creo la tipologia de accion.');
                                location.reload();
                            },
                            error  : function (data) {
                                console.log("Error.");
                            }
                        });
                    }
                });

                if (validator.valid()) {
                    $('#alta #form-alta').submit();
                }
            });

            $('#abm').on('click', '.darBaja', function () {

                var linea = $(this).data('id');
                var data = '_token=' + $('#abm input').first().val();
                console.log(linea);
                console.log(data);
                $.ajax({
                    url    : 'lineasEstrategicas/' + linea,
                    method : 'delete',
                    data   : data,
                    success: function (data) {
                        console.log("Se dio de baja la tipologia de accion");
                        alert("Se dio de baja la tipologia de accion");
                        $('#table').DataTable().clear().draw();
                    },
                    error  : function (data) {
                        console.log("Error.");
                        console.log(data);
                    }
                });
            });


            $('#abm').on('click', '.darAlta', function () {

                var linea = $(this).data('id');
                var data = '_token=' + $('#abm input').first().val();

                $.ajax({
                    url    : 'lineasEstrategicas/' + linea + '/alta',
                    method : 'put',
                    data   : data,
                    success: function (data) {
                        console.log("Se dio de alta la tipologia de accion");
                        alert("Se dio de alta la tipologia de accion");
                        $('#table').DataTable().clear().draw();
                    },
                    error  : function (data) {
                        console.log("Error.");
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection
