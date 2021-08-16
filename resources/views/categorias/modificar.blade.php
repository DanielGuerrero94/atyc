<div class="col-sm-6 col-sm-offset-3">
    <div class="box box-success ">
        <div class="box-header">Categoria</div>
        <div class="box-body">
            <form>
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="anio" class="control-label col-xs-4">Año/s:</label>
                        <div class="col-xs-8">
                            <select class="select-2 form-control anio" id="anio" name="anio" aria-hidden="true" multiple required>
                                    @for($i = intval(date('Y')) + 1; $i > 2015 ; $i--)
                                        @if(in_array($i, $categoria->anios->pluck('anio')->toArray()))
                                            <option data-id="{{$i}}" value="{{$i}}" selected="selected">{{$i}}</option>
                                        @else
                                            <option data-id="{{$i}}" value="{{$i}}">{{$i}}</option>
                                        @endif
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="numero" class="control-label col-xs-4">Numero:</label>
                        <div class="col-xs-8">
                            <input
                                    type="text" class="form-control" id="numero" name="numero"
                                    value="{{$categoria->numero}}" required
                            >
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="nombre" class="control-label col-xs-4">Nombre:</label>
                        <div class="col-xs-8">
                            <input
                                    type="text" class="form-control" id="nombre" name="nombre"
                                    value="{{$categoria->nombre}}" required
                            >
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="provincial" class="control-label col-xs-4">Provincial:</label>
                        <div class="col-xs-8">
                            <select class="form-control" id="provincial" name="provincial" required>
                                <option></option>
                                @if($categoria->provincial)
                                    <option value="false" data-id="false">NO</option>
                                    <option value="true" data-id="true" selected="selected">SÍ</option>
                                @else
                                    <option value="false" data-id="false" selected="selected">NO</option>
                                    <option value="true" data-id="true">SÍ</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver
            </button>
            <button
                    class="btn btn-primary pull-right" id="modificar" title="Modificar"
                    data-id="{{$categoria->id_categoria}}"
            ><i class="fa fa-plus" aria-hidden="true"></i>Modificar
            </button>
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

    $(document).ready(() => {
        inicializarSelect2()

    })
</script>