<form id="form-alta">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li id="tab-pac" class="active"><a href="#general" data-toggle="tab">General</a></li>
            <li id="tab-alcance"><a href="#alcance" data-toggle="tab">Alcance</a></li>
            <li id="tab-ediciones"><a href="#ediciones-tab" data-toggle="tab">Ediciones</a></li>
            <li class="navbar-right">
                <div class="btn btn-success store">Guardar</div>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane in active" id="general">
                {{ csrf_field() }}
                <br/>
                <div class="row">
                    <div class="form-group col-md-12 col-xs-12">
                        <label for="anio" class="control-label col-md-2 col-xs-2">Año:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="anio" name="anio">
                                <option></option>
                                @for($i = intval(date('Y')) + 1; $i > 2012 ; $i--)
                                    @if($i == intval(date('Y')))
                                        <option data-id="{{$i}}" value={{$i}} selected>{{$i}}</option>
                                    @else
                                        <option data-id="{{$i}}" value={{$i}}>{{$i}}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-md-12 col-xs-12">
                        <label for="actor" class="control-label col-md-2 col-xs-2">Actor que Origina Acción:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="actor" name="id_actor">
                                <option></option>
                                @foreach ($actores as $actor)
                                    <option data-id="{{$actor->id_actor}}"
                                            value="{{$actor->id_actor}}"> {{$actor->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="nombre" class="col-md-2 col-xs-2">Nombre:</label>
                        <div class="typeahead__container col-md-8 col-xs-8">
                            <div class="typeahead__field">
                  <span class="typeahead__query">
                    <input class="curso_typeahead form-control" name="nombre" type="search"
                           placeholder="Buscar o agregar uno nuevo" autocomplete="off" style="font-size:1.4rem;">
                  </span>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="horas" class="control-label col-md-2 col-xs-2">Duración:</label>
                        <div class="col-md-8 col-xs-8">
                            <input type="number" class="form-control" name="duracion" id="horas"
                                   placeholder="Duración en horas">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="tipo_accion" class="control-label col-md-2 col-xs-2">Tipo de acción:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="tipo_accion" name="id_accion">
                                <option></option>
                                @foreach ($tipoAcciones as $tipo_accion)
                                    <option data-id="{{$tipo_accion->id_linea_estrategica}}"
                                            value="{{$tipo_accion->id_linea_estrategica}}"> {{$tipo_accion->numero ." " .$tipo_accion->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="modalidad" class="control-label col-md-2 col-xs-2">Modalidad:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="modalidad" name="id_modalidad">
                                <option></option>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="tematica" class="control-label col-md-2 col-xs-2">Temática/s:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="tematica" name="id_tematica" aria-hidden="true"
                                    multiple>
                                @foreach ($tematicas as $tematica)
                                    <option data-id="{{$tematica->id_area_tematica}}"
                                            value="{{$tematica->id_area_tematica}}"> {{$tematica->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="provincia" class="control-label col-md-2 col-xs-2">Jurisdicción / <br> Dependencia
                            Jerárquica:</label>
                        <div class="col-md-8 col-xs-8">
                            <br>
                            @if(Auth::user()->id_provincia == 25)
                                <select class="select-2 form-control" id="provincia" name="id_provincia">
                                    <option></option>
                                    @foreach ($provincias as $provincia)
                                        <option data-id="{{$provincia->id_provincia}}"
                                                value="{{$provincia->id_provincia}}"
                                                title="{{$provincia->titulo}}">{{$provincia->nombre}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select class="form-control" id="provincia" name="id_provincia" disabled>
                                    <option data-id="{{Auth::user()->id_provincia}}"
                                            value="{{Auth::user()->id_provincia}}">{{Auth::user()->title}}</option>
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="ficha_tecnica" class="control-label col-md-2 col-xs-2">Ficha Técnica</label>
                        <div class="col-md-8 col-xs-8">
                            <span> <b> Subir Ficha Técnica </b> </span>
                            <a href="#" data-id="0" class="btn btn-circle upload-ficha_tecnica-sin-pac"
                               title="Subir Ficha Técnica">
                                <i class="fa fa-upload fa-lg" style="color: #228B22;"> </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="alcance">
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="destinatario" class="control-label col-md-2 col-xs-2">Destinatarios:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="destinatario" name="id_destinatario"
                                    aria-hidden="true" multiple>
                                @foreach ($destinatarios as $destinatario)
                                    <option data-id="{{$destinatario->id_funcion}}"
                                            value="{{$destinatario->id_funcion}}"> {{$destinatario->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="responsable" class="control-label col-md-2 col-xs-2">Responsables de la
                            ejecución:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="responsable" name="id_responsable"
                                    aria-hidden="true" multiple>
                                @foreach ($responsables as $responsable)
                                    <option data-id="{{$responsable->id_responsable}}"
                                            value="{{$responsable->id_responsable}}"> {{$responsable->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="pauta" class="control-label col-md-2 col-xs-2">Pauta Para PAC:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="pauta" name="id_pauta" aria-hidden="true">
                                <option></option>
                                @foreach ($pautas as $pauta)
                                    @if($pauta->id_provincia == 25 || $pauta->id_provincia == Auth::user()->id_provincia)
                                        <option data-id="{{$pauta->id_pauta}}" value="{{$pauta->id_pauta}}"
                                                title="{{$pauta->descripcion}}"> {{$pauta->anios." - ".$pauta->numero.": ".$pauta->nombre}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="componentes" class="control-label col-md-2 col-xs-2">Componentes CAI:</label>
                        <div class="col-md-8 col-xs-8">
                            <select class="select-2 form-control" id="componentesCai" name="id_componente"
                                    aria-hidden="true" multiple>
                                @foreach ($componentes as $componente)
                                    <option data-id="{{$componente->id_componente}}"
                                            value="{{$componente->id_componente}}"> {{$componente->numero." - ".$componente->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="ediciones-tab">
                <br/>
                <div class="row" id="ediciones">
                    <div class="form-group col-xs-12 col-md-12">
                        <label for="ediciones" class="control-label col-md-2 col-xs-2">Ediciones</label>
                        <div class="col-md-3 col-xs-3">
                            <input type="number" class="form-control" name="ediciones" id="ediciones"
                                   placeholder="Cantidad de ediciones">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="btn btn-warning" id="volver" title="Volver"><i class="fa fa-undo" aria-hidden="true"></i> Volver
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">

    function setDisabledElement(ids, object) {
        if (ids.includes(parseInt(object.val()))) {
            object.prop('disabled', true);
            object.attr('disabled', true);
            object.attr('selected', false);
        } else {
            object.removeAttr('disabled');
        }
        object.parent().select2({
            "width": "100%",
            "placeholder": "   Seleccionar"
        });
    }

    $(document).ready(function () {
//Tutorial de alta de PAC
        formUploadSinPac = '<form id="upload-ficha_tecnica-sin-pac" name="upload-ficha_tecnica-sin-pac" style="display: none;">{{ csrf_field() }} <label><input type="file" name="csv" style="display: none;"></label>  <label><input type="hidden" name="id_ficha_tecnica" style="display: none;"></label> </form>';

        $('.select-2').select2({
            "width": "100%",
            "placeholder": "   Seleccionar"
        }).change(function () {
            $(this).valid();
            var container = $(this).select('select2-container');
            var position = container.offset().top;
            var availableHeight = $(window).height() - position - container.outerHeight();
            var bottomPadding = 50; // Set as needed
            $('ul.select2-results__options').css('max-height', (availableHeight - bottomPadding) + 'px');

            pautas = {!! $pautas->toJson() !!};

            let anio = $('#general #anio option:selected').data('id').toString();
            let pautasIds = pautas.filter(pauta => !(pauta.anios.split(',').includes(anio))).map(pauta => pauta.id_pauta);

            $("#pauta option").each(function () {
                setDisabledElement(pautasIds, $(this));
            });

            $('.select2-container--default .select2-selection--multiple').css('height', 'auto');
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });

        $('.select-2').ready(function () {
            pautas = {!! $pautas->toJson() !!};
            console.log(pautas);
            let anio = $('#general #anio option:selected').data('id').toString();
            let pautasIds = pautas.filter(pauta => !(pauta.anios.split(',').includes(anio))).map(pauta => pauta.id_pauta);

            $("#pauta option").each(function () {
                setDisabledElement(pautasIds, $(this));
            });

            $('.select2-container--default .select2-selection--multiple').css('height', 'auto');
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });

        $('.select-2').on('select2:select', function () {
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });

        $('.select-2').on('select2:unselect', function () {
            $('.select2-container--default .select2-selection--multiple .select2-selection__choice').css('color', '#444 !important');
        });

        $('#tipo_accion').on('select2:select', function () {

            $('#general #modalidad').children().remove();

            let html = '<option></option>';

            $('#general #modalidad').append(html);

            tiposAccion = {!! $tipoAcciones->toJson() !!};

            let idTipoAccion = $('#general #tipo_accion option:selected').data('id');

            let tipoAccion = tiposAccion.find(tipoAccion => tipoAccion.id_linea_estrategica == idTipoAccion);

            tipoAccion.modalidades.forEach(modalidad => {
                html += `<option data-id="${modalidad.id_modalidad}" value="${modalidad.id_modalidad} title="${modalidad.nombre}">
                    ${modalidad.nombre}
                    </option>`;
            })

            $('#general #modalidad').append(html);
        });

        $.typeahead({
            input: '.curso_typeahead',
            order: "desc",
            source: {
                info: {
                    ajax: {
                        type: "get",
                        url: "cursos/nombres",
                        path: "data.info"
                    }
                }
            },
            callback: {
                onInit: function (node) {
                    console.log('Typeahead Initiated on ' + node.selector);
                }
            }
        });

        function getTematicasSelected() {
            return $('#general #tematica option:selected').map(function () {
                return this.value;
            });
        }

        function getDestinatariosSelected() {
            return $('#alcance #destinatario option:selected').map(function () {
                return this.value;
            });
        }

        function getResponsablesSelected() {
            return $('#alcance #responsable option:selected').map(function () {
                return this.value;
            });
        }

        function getPautasSelected() {
            return $('#alcance #pauta option:selected').map(function () {
                return this.value;
            });
        }

        function getComponentesSelected() {
            return $('#alcance #componentesCai option:selected').map(function () {
                return this.value;
            });
        }

        function getSelected() {

            var id_actor = $('#general #actor option:selected').data('id');
            var id_accion = $('#general #tipo_accion option:selected').data('id');
            var id_modalidad = $('#general #modalidad option:selected').data('id');
            var id_provincia = $('#general #provincia option:selected').data('id');
            var id_ficha_tecnica = $('#upload-ficha_tecnica-sin-pac').val();
            var ids_tematicas = getTematicasSelected();
            var ids_destinatarios = getDestinatariosSelected();
            var ids_responsables = getResponsablesSelected();
            var id_pauta = $('#alcance #pauta option:selected').data('id');
            var ids_componentes = getComponentesSelected();
            var anio = $('#general #anio option:selected').data('id');

            var selected = [
                {
                    name: 'id_actor',
                    value: id_actor
                },
                {
                    name: 'id_accion',
                    value: id_accion
                },
                {
                    name: 'id_modalidad',
                    value: id_modalidad,
                },
                {
                    name: 'id_provincia',
                    value: id_provincia
                },
                {
                    name: 'ids_tematicas',
                    value: ids_tematicas.toArray()
                },
                {
                    name: 'ids_destinatarios',
                    value: ids_destinatarios.toArray()
                },
                {
                    name: 'ids_responsables',
                    value: ids_responsables.toArray()
                },
                {
                    name: 'id_pauta',
                    value: id_pauta
                },
                {
                    name: 'anio',
                    value: anio
                },
                {
                    name: 'ids_componentes',
                    value: ids_componentes.toArray()
                }];

            console.log(selected);

            if (id_ficha_tecnica) {
                selected.push({
                    name: 'id_ficha_tecnica',
                    value: id_ficha_tecnica
                });
            }

            console.log(selected);
            return selected;
        }

        function getInput() {
            var input = $.merge($('#form-alta').serializeArray(), getSelected());
            console.log(input);

            return input;
        }

        function validateDates() {
            let i = 1
            let inicial = $('#form-alta #ediciones-tab #fecha_inicio_' + i).val();
            let final = $('#form-alta #ediciones-tab #fecha_final_' + i).val();
            let currentYear = $('#form-alta #general #anio').val();
            flag = true;

            while (inicial != undefined && inicial != "" && final != undefined && final != "") {
                initialMoment = moment.utc(inicial, 'DD/MM/YYYY');
                finalMoment = moment.utc(final, 'DD/MM/YYYY')

                correctDates = initialMoment.isSameOrBefore(finalMoment);
                if (!correctDates) {
                    ($('#form-alta #ediciones-tab #' + i)).next("p").remove();
                    text = '<p style="color: #dd4b39; font-weight:bold; padding-left:2rem;"> La fecha inicial debe ser anterior a la fecha final </p>';
                    ($('#form-alta #ediciones-tab #' + i)).after(text);
                    flag = false;
                } else if (initialMoment.year() != currentYear || finalMoment.year() != currentYear) {
                    ($('#form-alta #ediciones-tab #' + i)).next("p").remove();
                    text = '<p style="color: #dd4b39; font-weight:bold; padding-left:2rem;"> La fecha debe coincidir con el año seleccionado</p>';
                    ($('#form-alta #ediciones-tab #' + i)).after(text);
                    flag = false;
                } else {
                    ($('#form-alta #ediciones-tab #' + i)).next("p").remove();
                }
                i++;
                inicial = $('#form-alta #ediciones-tab #fecha_inicio_' + i).val();
                final = $('#form-alta #ediciones-tab #fecha_final_' + i).val();
            }
            return flag;
        }

        jQuery.validator.addMethod("selecciono", function (value, element) {
            return $(element).find(':selected').length != 0 && $(element).find(':selected').val() != "";
        }, "Debe seleccionar alguna opcion");

        jQuery.validator.addMethod("completados", function (value, element) {
            return $('#form-alta #ediciones-tab input[type="text"]').toArray().every(
                function (element, value) {
                    return ($(element).val() != '');
                }) && value > 0;

        }, "Falta la fecha de alguna edicion");

        $('#alta-pac #form-alta').validate({
            rules: {
                anio: {
                    required: true
                },
                nombre: {
                    required: true
                },
                duracion: {
                    required: true,
                    number: true
                },
                id_actor: {
                    selecciono: true
                },
                id_accion: {
                    selecciono: true
                },
                // id_tematica: {
                //   selecciono: true
                // },
                id_provincia: {
                    selecciono: true
                },
                id_destinatario: {
                    selecciono: true
                },
                id_responsable: {
                    selecciono: true
                },
                // id_pauta: {
                //   selecciono: true
                // },
                // id_componente: {
                //   selecciono: true
                // },
                ediciones: {
                    required: true,
                    number: true,
                    completados: true
                },
                csv: {
                    required: false,
                    filesize: 16777216 //16MB (1MB = 1048576)
                }
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('select-2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            ignore: '.select2-input, .select2-focusser, .select2-search__field, input[type="hidden"]',
            messages: {
                nombre: "Campo obligatorio",
                duracion: "Campo obligatorio",
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                $(element).text('').addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
            },

            submitHandler: function (form) {
                $.ajax({
                    method: 'post',
                    url: 'pacs',
                    data: getInput(),
                    success: function (data) {
                        console.log(data);
                        alert("Se crea la pac.");
                        location.replace('pacs');
                    },
                    error: function (data) {
                        console.log(data);
                        alert("No se pudo crear la pac.");
                    }
                });
            }
        });

        $('#alta-pac').on('click', '.store', function () {
            $('#alta-pac .nav-tabs').children().first().children().click();
            if ($('#alta-pac #form-alta').valid() && validateDates()) {
                $('#alta-pac #form-alta').submit();
            } else {
                alert('Hay campos que no cumplen con la validacion.');
            }
        });

        var edicionesAnteriores = 0;

        $('#alta-pac').on('change', '#ediciones input', function () {
            var ediciones = $ediciones = parseInt($('#form-alta .row #ediciones').val());
            var edicionesActuales = ediciones - edicionesAnteriores;

            if (ediciones > edicionesAnteriores) // edicionesActuales > 0
            {
                for (i = 0; i < edicionesActuales; i++) {
                    var currentEdicion = +edicionesAnteriores + +i + +1;

                    $('#form-alta #ediciones-tab').append(
                        ' <br> <div class="row" id="' + currentEdicion + '" style="display: none;"> <div class="form-group col-xs-2 col-md-2"> <label for="edicion_' + currentEdicion + ' " class="control-label col-md-6 col-xs-5">Edición ' + currentEdicion + '</label> </div> <div class="form-group col-xs-8 col-md-4"> <label for="fecha_inicio_' + currentEdicion + '" class="control-label col-md-4 col-xs-4">Fecha Inicio:</label> <div class="input-group date col-md-5 col-xs-3 "> <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div> <input type="text" name="fecha_inicio_' + currentEdicion + '" id="fecha_inicio_' + currentEdicion + '" class="form-control pull-right datepicker"> </div> </div> <div class="form-group col-xs-8 col-md-4"> <label for="fecha_final_' + currentEdicion + '" class="control-label col-md-4 col-xs-4">Fecha Final:</label> <div class="input-group date col-md-5 col-xs-3 "> <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div> <input type="text" name="fecha_final_' + currentEdicion + '" id="fecha_final_' + currentEdicion + '" class="form-control pull-right datepicker"> </div> </div> </div> '
                    );
                    $('#form-alta #ediciones-tab #' + currentEdicion).show(200);
                }
                edicionesAnteriores = ediciones;

            } else if (ediciones >= 0) {
                for (i = 0; edicionesActuales < i; edicionesActuales++) {
                    $('#form-alta #ediciones-tab').children().last().remove(); // saca la <row>
                    $('#form-alta #ediciones-tab').children().last().remove(); // saca el <br>
                }
                edicionesAnteriores = ediciones;
            }

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'es',
                autoclose: true,
            });

        });

        $(".container-fluid").on("click", ".upload-ficha_tecnica-sin-pac", function (event) {
            $(formUploadSinPac).appendTo($(this).parent());
            $(this).parent().find("form input").click();
        });

        $(".container-fluid").on("change", "#upload-ficha_tecnica-sin-pac input", function (event) {
            form = $(this).parent().parent();
            data = new FormData(form[0]);
            id_pac = form.parent().find(".upload-ficha_tecnica-sin-pac").data("id");

            filesize = $('#upload-ficha_tecnica-sin-pac').children()[1].control.files[0].size;

            $.ajax({
                url: "{{url('pacs')}}" + "/" + id_pac,
                type: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log("success");
                    $('#upload-ficha_tecnica-sin-pac').val(data);
                    $('#upload-ficha_tecnica-sin-pac').valid();
                    $('.upload-ficha_tecnica-sin-pac').parent().children().closest('span').replaceWith('<span><b>  Subida  </b></span>');
                    $('.upload-ficha_tecnica-sin-pac').parent().children().closest('a').replaceWith('<i class="fa fa-check fa-lg" title="Subida" style="color:green;"></i>')
                },
                error: function (data) {
                    console.log(data);
                    alert("Error al subir el archivo.");
                    // location.reload();
                }
            });
        });

    });
</script>
