<div class="col-sm-6 col-sm-offset-3">
    <div class="box box-success ">
        <div class="box-header">Pauta</div>
        <div class="box-body" id="modificar-form">
            <form>
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
                            >
                                @for($i = intval(date('Y')) + 1; $i > 2015 ; $i--)
                                    @if(in_array($i, $pauta->anios->pluck('anio')->toArray()))
                                        <option
                                                data-id="{{$i}}"
                                                value="{{$i}}"
                                                selected="selected"
                                        >
                                            {{$i}}
                                        </option>
                                    @else
                                        <option
                                                data-id="{{$i}}"
                                                value="{{$i}}"
                                        >
                                            {{$i}}
                                        </option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="categoria" class="control-label col-xs-4">Categoria:</label>
                        <div class="col-xs-8">
                            <select
                                    class="select-2 form-control categoria" id="categoria" name="id_categoria"
                                    aria-hidden="true"
                            >
                                @foreach ($categorias as $categoria)
                                    @if ($categoria->id_categoria === $pauta->id_categoria)
                                        <option
                                                value="{{$categoria->id_categoria}}"
                                                data-id="{{$categoria->id_categoria}}"
                                                selected="selected"
                                        >{{$categoria->numero." - ".$categoria->nombre}}</option>
                                    @else
                                        <option
                                                value="{{$categoria->id_categoria}}"
                                                data-id="{{$categoria->id_categoria}}"
                                        >{{$categoria->numero." - ".$categoria->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="ficha_obligatoria" class="control-label col-xs-4">Ficha obligatoria:</label>
                        <div class="col-xs-8">
                            <select
                                    class="form-control ficha_obligatoria"
                                    id="ficha_obligatoria"
                                    name="ficha_obligatoria"
                            >
                                <option></option>
                                @if ($pauta->ficha_obligatoria)
                                    <option
                                            value="true"
                                            data-id="true"
                                            selected="selected"
                                    >Ficha Obligatoria
                                    </option>
                                    <option value="false" data-id="false">Ficha Optativa</option>
                                @else
                                    <option
                                            value="false"
                                            data-id="false"
                                            selected="selected"
                                    >Ficha Optativa
                                    </option>
                                    <option value="true" data-id="true">Ficha Obligatoria
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="numero" class="control-label col-xs-4">Numero:</label>
                        <div class="col-xs-8">
                            @if(Auth::user()->id_provincia === 25)
                                <input
                                        type="text"
                                        class="form-control"
                                        id="numero"
                                        name="numero"
                                        value="{{$pauta->numero}}"
                                        required
                                >
                            @else
                                <input
                                        type="text"
                                        class="form-control"
                                        id="numero"
                                        name="numero"
                                        value="{{$pauta->numero}}"
                                        required
                                        disabled
                                >
                            @endif
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="nombre" class="control-label col-xs-4">Nombre:</label>
                        <div class="col-xs-8">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="nombre"
                                    name="nombre"
                                    value="{{$pauta->nombre}}"
                                    required
                            >
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="descripcion" class="control-label col-xs-4">Descripción:</label>
                        <div class="col-xs-8">
                            <textarea
                                    class="form-control" id="descripcion" name="descripcion"
                                    placeholder="Descripción de la pauta" data-autosize-input='{ "space": 40 }'
                            >{{$pauta->descripcion}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button
                            class="btn btn-warning"
                            id="volver"
                            title="Volver"
                            type="reset"
                    >
                        <i class="fa fa-undo" aria-hidden="true"></i>Volver
                    </button>
                    <button
                            class="btn btn-primary pull-right"
                            id="modificar"
                            title="Modificar"
                            data-id="{{$pauta->id_pauta}}"
                            type="submit"
                    >
                        <i class="fa fa-plus" aria-hidden="true"></i>Modificar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    function inicializarTextarea() {
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

    function inicializarSelect2() {
        $('.anio').select2({
            "placeholder": {
                id  : '0',
                text: " Seleccionar año/s"
            },
            "width"      : '100%'
        });

        $('.categoria').select2({
            "placeholder": " Seleccionar categoria",
            "width"      : '100%'
        });

        $('.ficha_obligatoria').select2({
            "placeholder": "Seleccionar obligatoriedad",
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

        actualizarCategoriasElegibles();
    }

    function actualizarCategoriasElegibles() {
        $('#categoria').children().remove();

        let html = '<option></option>';

        const pauta = {!! $pauta->toJson() !!};
        let categorias = {!! $categorias->toJson() !!};
        const provinciaId = {{Auth::user()->id_provincia}};
        const anios = $('#anio').val();

        if (provinciaId !== 25) {
            categorias = categorias.filter(categoria => categoria.provincial);
        }

        const categoriasIds = categorias.filter(categoria =>
            (categoria.anios.some(categoriaAnio => anios?.includes(categoriaAnio.anio.toString())))
        ).map(categoria => categoria.id_categoria);

        $('#categoria').append(html);

        categorias.forEach(categoria => {
            const startHtml = `<option data-id="${categoria.id_categoria}" value="${categoria.id_categoria}"`;
            const endHtml = `>${categoria.anios.map(anio => anio.anio).join(', ')} - ${categoria.numero}: ${categoria.nombre}</option>`;

            if (categoria.id_categoria === pauta.id_categoria) {
                html += startHtml + 'selected="selected"' + endHtml;
                return;
            }

            if (categoriasIds.includes(categoria.id_categoria)) {
                html += startHtml + endHtml;
            }
        });

        $('#categoria').append(html);
    }

    function actualizarNumeroDePauta() {
        let id = $('#categoria option:selected').data('id');
        const provinciaId = {{Auth::user()->id_provincia}};
        const categorias = {!! $categorias->toJson() !!};
        const categoria = categorias.find(categoria => categoria.id_categoria === id);
        let pautas = categoria.pautas;

        if (categoria.provincial) {
            pautas = pautas.filter(pauta => pauta.id_provincia === provinciaId);
        }

        const pauta = pautas.sort((a, b) => a.numero >= b.numero ? 1 : -1).pop();

        if (!pauta) {
            const provincia = provinciaId !== 25 ? `${provinciaId}.` : '';
            $('#numero').val(`${categoria.numero}.${provincia}1`);
            return;
        }

        const prefijo = pauta.numero.slice(0, -2) ?? categoria.numero;
        const numero = parseInt(pauta.numero.slice(-1) ?? 0) + 1;
        $('#numero').val(`${prefijo}.${numero}`);
    }

    function getSelected() {
        var anios = $('#anio').val();
        var provincia = {{Auth::user()->id_provincia}};
        var categoria = $('#categoria').val();
        var numero = $('#numero').val();

        return [{
            name : 'anios',
            value: anios
        }, {
            name : 'id_provincia',
            value: provincia
        }, {
            name : 'id_categoria',
            value: categoria
        }, {
            name : 'numero',
            value: numero
        }];
    }

    function validarForm() {
        $('#modificar-form form').validate({
            rules        : {
                anio             : "required",
                id_categoria     : {
                    required: true,
                    number  : true
                },
                ficha_obligatoria: "required",
                nombre           : "required",
                numero           : "required"
            },
            messages     : {
                anio             : "Campo obligatorio",
                id_categoria     : "Campo obligatorio",
                ficha_obligatoria: "Campo obligatorio",
                nombre           : "Campo obligatorio",
                numero           : "Campo obligatorio"
            },
            highlight    : function (element) {
                $(element).closest('.form-control').removeClass('success').addClass('error');
            },
            success      : function (element) {
                $(element).text('').addClass('valid')
                    .closest('.control-group').removeClass('error').addClass('success');
            },
            submitHandler: function (form) {
                const pauta = $('#modificar').data('id');
                const input = $.merge($('form').serializeArray(), getSelected());

                $.ajax({
                    url    : 'pautas/' + pauta,
                    method : 'put',
                    data   : input,
                    success: function (data) {
                        console.log("Success.");
                        alert("Se modifica la pauta");
                        location.reload();
                    },
                    error  : function (data) {
                        console.log("Error.");
                        console.log(data);
                        alert("Error en la modificación de la pauta");
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        inicializarTextarea();
        inicializarSelect2();

        $('#anio').on('change', function () {
            actualizarCategoriasElegibles();
        });

        $('#categoria').change(function () {
            actualizarNumeroDePauta();
        });

        validarForm();
    });

</script>