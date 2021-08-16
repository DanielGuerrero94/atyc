<div class="col-sm-6 col-sm-offset-3">
    <div class="box box-success ">
        <div class="box-header">Nueva Categoria</div>
        <div class="box-body">
            <form id="form-alta">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="anio" class="control-label col-xs-4">Año/s:</label>
                        <div class="col-xs-8">
                            <select
                                    class="select-2 form-control anio"
                                    id="anio"
                                    name="anio"
                                    aria-hidden="true"
                                    multiple
                                    required
                            >
                                <option
                                        data-id="{{intval(date('Y'))+1}}"
                                        value="{{intval(date('Y'))+1}}"
                                >{{intval(date('Y'))+1}}</option>
                                <option
                                        data-id="{{intval(date('Y'))}}"
                                        value="{{intval(date('Y'))}}"
                                        selected="selected"
                                >
                                    {{intval(date('Y'))}}
                                </option>
                                @for($i = intval(date('Y'))-1; $i > 2015 ; $i--)
                                    <option
                                            data-id="{{$i}}"
                                            value="{{$i}}"
                                    >
                                        {{$i}}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="numero" class="control-label col-xs-4">Número:</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="nombre" class="control-label col-xs-4">Nombre:</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="nombre" name="nombre">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="provincial" class="control-label col-xs-4">Provincial:</label>
                        <div class="col-xs-8">
                            <select class="select-2 form-control provincial" id="provincial" name="provincial" required>
                                <option></option>
                                <option value="false" data-id="false">NO</option>
                                <option value="true" data-id="true">SÍ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <a class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver</a>
                    <button class="btn btn-success pull-right" id="crear" title="Alta" type="submit"><i
                                class="fa fa-plus" aria-hidden="true"
                        ></i>Alta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    function inicializarSelect2() {
        $('.anio').select2({
            "placeholder": {
                id  : '0',
                text: " Seleccionar año/s"
            },
            "width"      : '100%'
        });

        $('.provincial').select2({
            "placeholder": "Seleccionar",
            "width"      : '100%'
        });

        $('.select-2').ready(function () {
            $('.select2-container--default .select2-selection--multiple').css('height', 'auto');
            $('.select2-container--default .select2-selection--single').css('height', 'auto');
            $('.select2-container .select2-selection--single .select2-selection__rendered').css('white-space', 'normal');
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });

        $('.select-2').on('select2:select', function () {
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });

        $('.select-2').on('select2:unselect', function () {
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });
    }

    function validarForm() {

        $('#alta form').validate({
            rules        : {
                anio      : "required",
                nombre    : "required",
                numero    : "required",
                provincial: "required"
            },
            messages     : {
                anio      : "Campo obligatorio",
                nombre    : "Campo obligatorio",
                numero    : "Campo obligatorio",
                provincial: "Campo obligatorio",
            },
            highlight    : function (element) {
                $(element).closest('.form-control').removeClass('success').addClass('error');
            },
            success      : function (element) {
                $(element).text('').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
            },
            submitHandler: function (form) {

                const input = $.merge($('form').serializeArray(), [{
                    name : 'anios',
                    value: $('#anio').val()
                }]);

                $.ajax({
                    method     : 'post',
                    url        : 'categorias',
                    data       : input,
                    success    : function (data) {
                        console.log("Success.");
                        alert("Se creo la categoria");
                        location.reload();
                    },
                    error      : function (data) {
                        console.log(data)
                        console.log("Error.");
                        alert("Error en la creación de categoria");

                    }
                });
            }
        });
    }

    $(document).ready(function () {
        inicializarSelect2();
        validarForm();
    });


</script>