<div class="col-sm-6 col-sm-offset-3">
    <div class="box box-success ">
        <div class="box-header">Tipologia de accion</div>
        <div class="box-body">
        <!-- <form action="{{url('lineasEstrategicas/set')}}" method="post"> -->
            <form>
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="numero" class="control-label col-xs-4">Número:</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="numero" name="numero" value="{{$linea->numero}}"
                                   required>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="nombre" class="control-label col-xs-4">Nombre:</label>
                        <div class="col-xs-8">
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{$linea->nombre}}"
                                   required>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="modalidad" class="control-label col-xs-4">Modalidad:</label>
                        <div class="col-xs-8">
                            <select class="select-2 form-control modalidad" id="modalidad" name="id_modalidad"
                                    aria-hidden="true" multiple>
                                @foreach ($modalidades as $modalidad)
                                    @if(in_array($modalidad->id_modalidad, $linea->modalidades()->withTrashed()->get()->map(function ($_modalidad) { return $_modalidad->id_modalidad; })->all()))
                                        <option value="{{$modalidad->id_modalidad}}"
                                                data-id="{{$modalidad->id_modalidad}}"
                                                selected>{{$modalidad->nombre}}</option>
                                    @else
                                        <option value="{{$modalidad->id_modalidad}}"
                                                data-id="{{$modalidad->id_modalidad}}">{{$modalidad->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="descripcion" class="control-label col-xs-4">Descripción:</label>
                        <div class="col-xs-8">
                            <textarea class="form-control" id="descripcion" name="descripcion"
                                      placeholder="Descripción de la tipologia"
                                      data-autosize-input='{ "space": 40 }'></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-footer">
            <button class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i>Volver
            </button>
            <button class="btn btn-primary pull-right" id="modificar" title="Modificar"
                    data-id="{{$linea->id_linea_estrategica}}"><i class="fa fa-plus" aria-hidden="true"></i>Modificar
            </button>
        </div>
    </div>
</div>


<script type="text/javascript">

    function iniciarTextArea() {
        $('#alta textarea').on("click", function () {
            var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
            $(this).css({'height': totalHeight});
        });

        $('#alta textarea').on({
            input: function () {
                var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) - parseInt($(this).css('padding-bottom'));
                $(this).css({'height': totalHeight});
            }
        });
    }

    function iniciarSelect2() {
        $('.modalidad').select2({
            "placeholder": "Seleccionar",
            "width": '100%'
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

    $(document).ready(function () {
        iniciarTextArea();
        iniciarSelect2();
    });
</script>