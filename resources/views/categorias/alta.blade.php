<div class="col-sm-6 col-sm-offset-3">
    <div class="box box-success ">
        <div class="box-header">Nueva Categoria</div>
        <div class="box-body">
            <form id="form-alta">
                {{ csrf_field() }}
                <div class="row">
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
                            <select class="form-control" id="provincial" name="provincial">
                                <option value="false" data-id="false" title="NO">NO</option>
                                <option value="true" data-id="true" title="SÍ">SÍ</option>
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

    function validarForm() {

        $('#alta form').validate({
            rules        : {
                nombre    : "required",
                numero    : "required",
                provincial: "required"
            },
            messages     : {
                nombre    : "Campo obligatorio",
                numero    : "Campo obligatorio",
                provincial: "Campo obligatorio",
            },
            highlight    : function (element) {
                console.log(element);
                $(element).closest('.form-control').removeClass('success').addClass('error');
            },
            success      : function (element) {
                $(element).text('').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
            },
            submitHandler: function (form) {

                console.log($('form').serialize());

                $.ajax({
                    method : 'post',
                    url    : 'categorias',
                    data   : $('form').serialize(),
                    success: function (data) {
                        console.log("Success.");
                        alert("Se creo la categoria");
                        location.reload();
                    },
                    error  : function (data) {
                        console.log("Error.");
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        validarForm();
    });


</script>