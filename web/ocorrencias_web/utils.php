<?php header("Content-type: application/javascript"); ?>

var greenicon = L.icon({
    iconUrl: 'libs/leaflet/images/marker-icon-green.png',
    iconSize: [25, 40],
    iconAnchor: [12, 40],
    shadowSize: [40, 40]
});

var fileName;

jQuery(document).ready(function() {
	
    //TABS
    $('#form-tabs a').click(function (e){
        e.preventDefault();
        $(this).tab('show');
        if (this.innerHTML == 'Localização' && $('#map').hasClass('leaflet-container') == false){
            addMap();
        }
    });
    
    //OBSERVATION RADIOS
    $('#observation input[name="obs"]').click(function(){
        var radios = $('input[name="obs"]');
        for (var i = 0; i < radios.length; i++){
            if (radios[i].checked == true){
                if (radios[i].value == 'exacta'){
                    $('#aproximate-form').css('display', 'none');
                    $('#exact-form').css('display', 'inline');
                    
                    clearCombos(['sys_class', 'sys_class_val', 'phenology_aproximate', 'age_aproximate', 'sex_aproximate', 'behavior_aproximate']);
                    clearSpinners(['individuals_aproximate', 'individuals_type_aproximate']);
                } else {
                    $('#aproximate-form').css('display', 'inline');
                    $('#exact-form').css('display', 'none');
                    $('#sys_class_val').select2('enable', false);
                    $('#sys_class_val').select2('val', '');
                    $('#sys_class').select2('val', '');
                    clearCombos(['especie', 'phenology', 'age', 'sex', 'behavior']);
                    clearSpinners(['individuals', 'individuals_type']);
                }
            }
        }
    });
    
    //IDENTIFICATION FORM
    $("#especie").select2({
        placeholder: 'Espécie',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: 'services/get_species.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    especie: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#especie').on('select2-selecting', function(evt){
        $('#especie').select2('container')
            .css('border', 'none');
    });
    
    $("#sys_class").select2({
        placeholder: 'Tipo de classe',
        allowClear: true,
        ajax: {
            url: 'services/get_species_fields.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    sys_class: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    
    $("#sys_class")
        .on('select2-selecting', function(evt){
            $('#sys_class_val')
                .select2('enable', true)
                .select2('val', '');
            $('#sys_class').select2('container')
                .css('border', 'none');
        })
        .on('select2-clearing', function(evt){
            $('#sys_class_val')
                .select2('enable', false)
                .select2('val', '');
        });
    
    
    $("#sys_class_val").select2({
        placeholder: 'Classe',
        allowClear: true,
        ajax: {
            url: 'services/get_class_values.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    sys_class_val: $('#sys_class').select2('data').text,
                    val: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#sys_class_val').on('select2-selecting', function(evt){
	    $('#sys_class_val').select2('container')
	        .css('border', 'none');
    });
    
    $("#phenology, #phenology_aproximate").select2({
        placeholder: 'Fenologia',
        allowClear: true,
        ajax: {
            url: 'services/get_phenology.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    phenology: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#phenology').on('select2-selecting', function(evt){
        $('#phenology').select2('container')
            .css('border', 'none');
    });
    
    $('#phenology_aproximate').on('select2-selecting', function(evt){
        $('#phenology_aproximate').select2('container')
            .css('border', 'none');
    });
    
    
    
    //age old
//     $("#age, #age_aproximate").select2({
//         placeholder: 'Idade',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_ages.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     age: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
//     
//     $('#age').on('select2-selecting', function(evt){
//         $('#age').select2('container')
//             .css('border', 'none');
//     });
//     
//     $('#age_aproximate').on('select2-selecting', function(evt){
//         $('#age_aproximate').select2('container')
//             .css('border', 'none');
//     });
    
        //age new
    var data = [{ id: 0, text: 'indeterminada' }, { id: 1, text: 'sub-adulto' }, { id: 2, text: 'adulto' }, { id: 3, text: 'jovem' }]; 
    $("#age, #age_aproximate").select2({
		placeholder: 'Idade',
		data: data
	});
	$('#age, #age_aproximate').val('0').trigger('change')
	
	$('#age, #age_aproximate').on('select2-selecting', function(evt){
        $('#age, #age_aproximate').select2('container')
            .css('border', 'none');
    });
    
    
    $('#sex, #sex_aproximate').select2({
        placeholder: 'Sexo',
        allowClear: true,
        ajax: {
            url: 'services/get_sex.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    sex: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#sex').on('select2-selecting', function(evt){
        $('#sex').select2('container')
            .css('border', 'none');
    });
    
    $('#sex_aproximate').on('select2-selecting', function(evt){
        $('#sex_aproximate').select2('container')
            .css('border', 'none');
    });
    
    $("#behavior, #behavior_aproximate").select2({
        placeholder: 'Comportamento',
        allowClear: true,
        ajax: {
            url: 'services/get_behavior.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    behavior: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#behavior').on('select2-selecting', function(evt){
        $('#behavior').select2('container')
            .css('border', 'none');
    });
    
    $('#behavior_aproximate').on('select2-selecting', function(evt){
        $('#behavior_aproximate').select2('container')
            .css('border', 'none');
    });
    
    $("input[name='individuals'], input[name='individuals_aproximate']").TouchSpin({
        max: 1000,
        min: 1,
        buttondown_class: 'btn btn-default btn-sm', 
        buttonup_class: 'btn btn-default btn-sm'
    });
    
    $('#km').TouchSpin({
		max: 1000,
        min: 0,
        step: 0.1,
        decimals: 1,	
        buttondown_class: 'btn btn-default btn-sm', 
        buttonup_class: 'btn btn-default btn-sm'
	});
    
    //CHARACTERIZATION FORM
    //old project
//     $("#project").select2({
//         placeholder: 'Projecto',
//         allowClear: true,
//         ajax: {
//             url: 'services/get_project.php',
//             dataType: 'json',
//             data: function(term, page){
//                 return {
//                     project: term
//                 };
//             },
//             results: function(data){
//                 if (typeof data.length == 'undefined'){
//                     return {results: []};
//                 } else {
//                     return {results: data};
//                 }
//             }
//         }
//     });
    
        //new project
    var data = [{ id: 0, text: 'MOVE' }, { id: 1, text: 'LIFE LINES' }, { id: 2, text: 'REFER' }]; 
    $("#project").select2({
		placeholder: 'Projecto',
		data: data
	});
        //var varname = <?php echo $_SESSION['project_id']; ?>;
	alert(<?php echo $_COOKIE['project_id']; ?>);
	$('#project').val(<?php echo $_COOKIE['project_id']; ?>).trigger('change')    
    
    $('#project').on('select2-selecting', function(evt){
        $('#project').select2('container')
            .css('border', 'none');
    });
    
    $("#method").select2({
        placeholder: 'Método',
        allowClear: true,
        ajax: {
            url: 'services/get_method.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    method: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#method').on('select2-selecting', function(evt){
        $('#method').select2('container')
            .css('border', 'none');
    });
    
    
    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'esmagado' }, { id: 1, text: 'inteiro' }, { id: 2, text: 'parcialmente inteiro' }, { id: 3, text: 'resto' }]; 
    $('#cons').select2({
		placeholder: 'Estado',
		data: data
	});
	$('#cons').val('0').trigger('change')
	
	$('#cons').on('select2-selecting', function(evt){
        $('#cons').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo

    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'recente' }, { id: 1, text: 'antigo' }, { id: 2, text: 'muito antigo' }]; 
    $('#anti').select2({
		placeholder: 'Antiguidade',
		data: data
	});
	$('#anti').val('0').trigger('change')
	
	$('#anti').on('select2-selecting', function(evt){
        $('#anti').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo


    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'N4' }, { id: 1, text: 'N18' }, { id: 2, text: 'N114' }, { id: 3, text: 'N370' }, { id: 4, text: 'M529' }, { id: 5, text: 'M1029' }]; 
    $('#estrada').select2({
		placeholder: 'Estrada',
		data: data
	});
	
	$('#estrada').on('select2-selecting', function(evt){
        $('#estrada').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo	

	
    //Novo campo na tab MOVE
    var data = [{ id: 0, text: 'F1' }, { id: 1, text: 'F2' }, { id: 2, text: 'B1' }, { id: 3, text: 'B2' }, { id: 4, text: 'Fora1' }, { id: 5, text: 'Fora2' }, { id: 6, text: 'Centro' }, { id: 7, text: 'F1-B1' }, { id: 8, text: 'F2-B2' }, { id: 9, text: 'B1-Fora1' }, { id: 10, text: 'B2-Fora2' }, { id: 11, text: 'Centro SC' }, { id: 12, text: 'Indeterminado' }]; 
    $('#zona_atr').select2({
		//placeholder: 'Zona',
		data: data
	});
    $('#zona_atr').val('0').trigger('change')
	
	$('#zona_atr').on('select2-selecting', function(evt){
        $('#zona_atr').select2('container')
            .css('border', 'none');
    });
	
	
	//FIM do novo campo	
    
    $("#type").select2({
        placeholder: 'Tipo',
        allowClear: true,
        ajax: {
            url: 'services/get_type.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    type: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    
    $('#type').on('select2-selecting', function(evt){
        $('#type').select2('container')
            .css('border', 'none');
    });
    
    $('#data').datetimepicker({
        pickTime: false,
        useCurrent: false,
        showToday: true
    });
    
    $("#data").on("dp.change",function (e) {
        $('#data').removeClass('has-error');
    });
    
    $('#data').data('DateTimePicker').setDate(new Date());
    
    $('#time').datetimepicker({
        pickDate: false
    });
    
    $("#time").on("dp.change",function (e) {
        $('#time').removeClass('has-error');
    });
    
    $('#time').data('DateTimePicker').setDate(new Date());
    
    //LOCALIZATION FORM
    //MAP
    function addMap(){
        //BaseLayers
        var osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var gstreets = new L.Google('ROADMAP');
        var gsat = new L.Google();
        
        //Overlay Layers
        var grid10 = new L.TileLayer.WMS("http://mapserver.uevora.pt/cgi-bin/ocorrencias/qgis_mapserv.fcgi", {
//            map: '/var/www/ub_ocorrencias/ocorrencias.qgs',
            layers: 'grelha UTM 10km',
            format: 'image/png',
            transparent: 'TRUE'
        });
        
        var grid2 = new L.TileLayer.WMS("http://mapserver.uevora.pt/cgi-bin/ocorrencias/qgis_mapserv.fcgi", {
//            map: '/var/www/ub_ocorrencias/ocorrencias.qgs',
            layers: 'grelha UTM 2km',
            format: 'image/png',
            transparent: 'TRUE'
        });
        
        window.map = L.map('map', {
            scrollWheelZoom: false
        });
        map.blueMarker = new Array();
        map.greenMarker = new Array();
        map.appLayers = [osm, gstreets, gsat, grid10, grid2];
        map.setView([39.704314, -8.127506], 6);
        
        map.addLayer(osm);
        
        //Layer Control
        var baseLayers = {
            'OSM': osm,
            'Google Streets': gstreets,
            'Google Satellite': gsat
        };
        
        var overlayLayers = {
            "Grelha 10 km": grid10,
            'Grelha 2 km': grid2
        };
        
        L.control.layers(baseLayers, overlayLayers).addTo(map);
        
        //Geolocate
        map.on('accuratepositionprogress', onAccuratePositionProgress);
		map.on('accuratepositionfound', onAccuratePositionFound);
		map.on('accuratepositionerror', onAccuratePositionError);
        map.on('click', onMapClick);
        
        //Geolocate
        L.easyButton(
            'fa-crosshairs',
            function (){geoLocate();},
            'Geolocalizar'
        ); 
        
        //initial geolocate
        geoLocate();
        
        return map;
    }
    
    function onMapClick(e) {
        var coords = reprojWgsToUtm([e.latlng.lng, e.latlng.lat]);
        $('#xcoord')
            .val(coords[0])
            .parent().removeClass('has-error');
        $('#ycoord')
            .val(coords[1])
            .parent().removeClass('has-error');
        
        if (map.greenMarker.length > 0){
            eraseMarkers(map.greenMarker);
        }
        var marker = L.marker(e.latlng, {icon: greenicon});
        map.greenMarker.push(marker);
        map.addLayer(marker);
    }
    
    function onMapClickAjax(e) {  
        $('#dialog-info').css('display', 'flex');
        $('#dialog-error').css('display', 'none');
        $('#dialog-progress').css('display', 'flex');
        $('#dialog-btn').css('display', 'none');
        $('#dialog').modal('toggle');
        
        $('#xcoord').val('');
        $('#ycoord').val('');
        $('#folha').val('');
        var coords = reprojWgsToUtm([e.latlng.lng, e.latlng.lat]);
        
        if (map.greenMarker.length > 0){
            eraseMarkers(map.greenMarker);
        }
        var marker = L.marker(e.latlng, {icon: greenicon});
        map.greenMarker.push(marker);
        map.addLayer(marker);
        
        $.ajax({
            type: 'POST',
            url : 'services/get_grid_coords.php',
            data: { x: coords[0], y: coords[1] , grid: map.selectedGrid},
            dataType: 'json',
            success: function(response){
                if (response.success == true){
                    $('#xcoord')
                        .val(response.data[0].x)
                        .parent().removeClass('has-error');
                    $('#ycoord')
                        .val(response.data[0].y)
                        .parent().removeClass('has-error');
                    $('#folha')
                        .val(response.data[0].folha)
                        .parent().removeClass('has-error');
                    var coords = reprojWgsToUtm([response.data[0].x, response.data[0].y], 'inverse');
                    eraseMarkers(map.greenMarker);
                    var marker = L.marker(coords.reverse(), {icon: greenicon});
			        map.greenMarker.push(marker);
			        map.addLayer(marker);
                    map.setView(coords);
                    if (map.getZoom() < 12){
                        map.setZoom(12);
                    }
                    $('#dialog').modal('toggle');
                    $('#dialog-info')
                        .css('display', 'flex')
                        .html('A obter dados. Por favor aguarde...');
		            $('#dialog-success').css('display', 'none');
		            $('#dialog-progress').css('display', 'block');
		            $('#dialog-error').css('display', 'none');
                } else {
                    $('#dialog-info').css('display', 'none');
                    $('#dialog-success').css('display', 'none');
			        $('#dialog-error')
                        .css('display', 'flex')
                        .html('Ocorreu um erro ao obter os dados! ' + response.msg);
			        $('#dialog-progress').css('display', 'none');
			        $('#dialog-btn').css('display', 'block');
                }
            }
        });
    }
    
    function eraseMarkers(markers){
        for (var i = 0; i < markers.length; i++){
            map.removeLayer(markers[i]);
        }
    }
    
    function geoLocate(){
        map.findAccuratePosition({
            maxWait: 10000,
            desiredAccuracy: 20
        });
    }
    
    function onAccuratePositionError (e) {
        var msg = 'Ocorreu um erro durante a geolocalização: ' + e.message.split(': ')[1];
         if ($('#gps').find('.alert-info').size() != 0){
            $('#gps').find('.alert')
	            .removeClass('alert-info')
                .removeClass('alert-success')
	            .addClass('alert-danger')
                .html(msg);
         } else {
            $('#gps').find('.alert')
                .removeClass('alert-warning')
                .removeClass('alert-info')
                .addClass('alert-danger')
                .html(msg);
         }
    }

    function onAccuratePositionProgress (e) {
        $('#gps').find('.alert')
            .removeClass('alert-warning')
            .removeClass('alert-success')
            .removeClass('alert-danger')
            .addClass('alert-info')
            .html('Geolocalização em progresso. Por favor aguarde.');
    }

    function onAccuratePositionFound (e) {
        if (map.blueMarker.length > 0){
            eraseMarkers(map.blueMarker);
        }
        
        var coords = reprojWgsToUtm([e.latlng.lng, e.latlng.lat]);
        $('#gps').find('.alert')
            .removeClass('alert-info')
            .removeClass('alert-danger')
            .addClass('alert-success')
            .html('Geolocalização bem sucedida. Coordenadas UTM Zona 29N - <b>X: </b>' + Math.round(coords[0] * 100000) / 100000 + ' m; <b>Y: </b>' + Math.round(coords[1] * 100000) / 100000 + ' m; <b>Precisão: </b>' + Math.round((e.accuracy / 2) * 100) /100  + ' m');
        map.setView(e.latlng, 16);
        L.marker(e.latlng).addTo(map);
        var radius = Math.round((e.accuracy / 2) * 100) / 100;
        L.circle(e.latlng, radius).addTo(map);
	document.getElementById('xcoord').value=Math.round(coords[0] * 100000) / 100000
	document.getElementById('ycoord').value=Math.round(coords[1] * 100000) / 100000	
    }
    
    function reprojWgsToUtm(coords, direction){
        var wgs = '+proj=longlat +datum=WGS84 +no_defs ';
        var utm = '+proj=utm +zone=29 +datum=WGS84 +units=m +no_defs';
        
        if (direction == 'inverse'){
            return proj4(utm, wgs, coords);
        } else {
            return proj4(wgs, utm, coords);
        }
    }
    
    //MAP-FORM
    //OBSERVATION RADIOS
    $('#local input[name="local-method"]').click(function(){
        if (map.greenMarker.length > 0){
            eraseMarkers(map.greenMarker);
        }
        var method = $('input[name="local-method"]:checked').val();
        if (method == 'click' || method == 'grid'){
            map.on('click', onMapClick);
            $('#xcoord')
                .attr('disabled', true)
                .val('');
            $('#ycoord')
                .attr('disabled', true)
                .val('');
            $('#update-map').css('display', 'none');
        } else { //method == 'manual'
            map.off('click', onMapClick);
            $('#xcoord')
                .attr('disabled', false)
                .val('');
            $('#ycoord')
                .attr('disabled', false)
                .val('');
            $('#update-map').css('display', 'block');
        }
        
        if (method == 'grid'){
            $('#map-aproximate').css('display', 'block');
            $('#biotopo-section').css('display', 'block');
	    $('#biotopo-sectionclc5').css('display', 'block');
            map.off('click', onMapClick);
        } else {
             $('#map-aproximate').css('display', 'none');
             $('#biotopo-section').css('display', 'none');
             $('#biotopo-sectionclc5').css('display', 'none');
             $('#grid').select2('val', '');
        }
    });
    
	$("#xcoord").keypress(function (e) {
		return restrictNumbers(e, '#xcoord');
	});
    
    $("#xcoord").focusout(function (e) {
        if ($("#xcoord").val() != ''){
            $("#xcoord")
                .parent().removeClass('has-error');
        }
    });
    
    $("#ycoord").keypress(function (e) {
        return restrictNumbers(e, '#ycoord');
    });
    
    $("#ycoord").focusout(function (e) {
        if ($("#ycoord").val() != ''){
            $("#ycoord")
                .parent().removeClass('has-error');
        }
    });
    
    function restrictNumbers(e, id){
        if (e.which == 46){
            if ($(id).val().indexOf('.') != -1){
                return false;
            } else {
                return true;
            }
        } else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        } else {
            return true;
        }
    }
    
    $('#update-map').click(
        function(){
            if ($('#ycoord').val() != '' && $('#xcoord').val() != ''){
	            var coords = reprojWgsToUtm([$('#xcoord').val(), $('#ycoord').val()], 'inverse');
	            var marker = L.marker([coords[1], coords[0]], {icon: greenicon});
		        map.greenMarker.push(marker);
		        map.addLayer(marker);
	            map.setView(coords.reverse(), 12);
            }
        }
    );
    
    
    $("#grid").select2({
        placeholder: 'Grelha UTM',
        allowClear: true,
        minimumResultsForSearch: -1, //hide search box
        data: [
            {id: 1, text: 'Grelha 10 km'},
            {id: 2, text: 'Grelha 2 km'}
        ]
    });
    
    $("#grid")
        .on('select2-selecting', function(evt){
            if (evt.val == 1){ //grelha de 10 km
				map.addLayer(map.appLayers[3]);   
				map.removeLayer(map.appLayers[4]);
                map.selectedGrid = 10;
            } else {
                map.addLayer(map.appLayers[4]);
                map.removeLayer(map.appLayers[3]);
                if (map.getZoom() < 12){
                    map.setZoom(12);
                }
                map.selectedGrid = 2;
            }
            map.off('click', onMapClickAjax);
            map.on('click', onMapClickAjax);
            if (map.greenMarker.length > 0){
	            eraseMarkers(map.greenMarker);
	        }
            $('#xcoord')
                .val('')
                .parent().removeClass('has-error');
            $('#ycoord')
                .val('')
                .parent().removeClass('has-error');
            $('#folha')
                .val('')
                .parent().removeClass('has-error');
            
            $('#grid').select2('container')
                .css('border', 'none');
        })
        .on('select2-clearing', function(evt){
            map.removeLayer(map.appLayers[3]);
            map.removeLayer(map.appLayers[4]);
            map.selectedGrid = null;
            map.off('click', onMapClickAjax);
            $('#xcoord').val('');
            $('#ycoord').val('');
            $('#folha').val('');
        });
        
    $("#biotopo").select2({
        placeholder: 'Biótopo CLC3',
        allowClear: true,
        ajax: {
            url: 'services/get_clc.php',
            dataType: 'json',
            data: function(term, page){
                return {
                    legend: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                    return {results: data};
                }
            }
        }
    });
    

        $("#biotopoclc5").select2({
        placeholder: 'Biótopo CLC5',
        allowClear: true,
        ajax: {
            url: 'services/get_clc5.php',
            dataType: 'json',
            data: function(term, page){
                return {
                   legendclc5: term
                };
            },
            results: function(data){
                if (typeof data.length == 'undefined'){
                    return {results: []};
                } else {
                   return {results: data};
                }
            }
        }
    });

    //BUTTONS
    $('#validate').click(
       function(){
            validateForm();
       }
    );
    
    function getComponentIds(){
        var finalIds = {};
        var observation = $('input[name="obs"]:checked').val();
        var sharedComboIds = ['phenology', 'age', 'sex', 'behavior'];
        var sharedCombosIdsMove = ['cons','zona_atr','anti','estrada'];
        var sharedIndivualsIds = ['individuals', 'individuals_type'];
        var commonComboIds = ['project', 'method', 'type'];
        var dateTimeIds = ['data', 'time'];
        var localizationIds = ['xcoord', 'ycoord'];
        var moveTxtIds = ['textolivre'];
        
        if (observation == 'exacta'){
            var comboIds = ['especie'].concat(sharedComboIds);
        } else {
            var comboIds = ['sys_class', 'sys_class_val'];
            comboIds = comboIds.concat(adjustIdNames(sharedComboIds));
            sharedIndivualsIds = adjustIdNames(sharedIndivualsIds);
        }
        
        var method = $('input[name="local-method"]:checked').val();
        if (method == 'grid'){
            var localComboIds = ['grid', 'biotopo', 'biotopoclc5'];
            localizationIds = localizationIds.concat('folha');
            finalIds['localComboIds'] = localComboIds;
        }
        
        finalIds['observation'] = observation;
        finalIds['comboIds'] = comboIds;
        finalIds['sharedCombosIdsMove'] = sharedCombosIdsMove;
        finalIds['sharedIndivualsIds'] = sharedIndivualsIds;
        finalIds['commonComboIds'] = commonComboIds;
        finalIds['dateTimeIds'] = dateTimeIds;
        finalIds['localizationIds'] = localizationIds;
        finalIds['moveTxtIds'] = moveTxtIds;
        finalIds['method'] = method;
        
        return finalIds;
    }
    
    function validateForm(){
        var componentIds = getComponentIds();
        var html = 'O seu formulário não apresenta erros de preenchimento. Por favor carregue em submeter para enviar os dados.';
        var errorHtml = 'O seu formulário apresenta erros de preenchimento nas seguintes secções: <br>';
        var success = true;
        
        //Identification form
        var idCount = validateCombos(componentIds['comboIds']);
        if (idCount > 0){
            success = false;
            html = errorHtml;
            html += '- Identificação <br>'
        }
        
        //Characterization form
        var charCombo = validateCombos(componentIds['commonComboIds']);
        var dateTime = validateDateTime(componentIds['dateTimeIds']);
        
        if (charCombo + dateTime > 0){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Caracterização <br>'
        }
        
        //Localization form
        var textFields = validateTextFields(componentIds['localizationIds'])
        if (componentIds['method'] == 'grid'){
            var localCombos = validateCombos([componentIds['localComboIds'][0]]);
        }

        if (textFields > 0  || (typeof localCombos != 'undefined' && localCombos > 0)){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Localização <br>'
        }
        
		
		var idCountMove = validateCombos(componentIds['sharedCombosIdsMove']);
        if (idCountMove > 0){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Move <br>'
        }
        
        var moveTxtFields = validateTextFields(componentIds['moveTxtIds']);
		if (moveTxtFields > 0 && idCountMove == 0){
            if (success == true){
                success = false;
                html = errorHtml;
            }
            html += '- Move <br>'
        }
		
        $('#msg-alert').css('display', 'block');
        if (success == false) {
            html += '<br>Por favor corrija os seus dados e valide novamente o formulário!';
            $('#msg-alert')
                .children()
                    .html(html)
                    .removeClass('alert-success')
                    .addClass('alert-danger');
        } else {
            $('#msg-alert')
                .children()
                    .html(html)
                    .removeClass('alert-danger')
                    .addClass('alert-success');
            $('#submit').removeAttr('disabled');
        }
    }
    
    function validateCombos(ids){
        var results = {};
        var counter = 0;
        for (var i = 0; i < ids.length; i++){
            if ( $('#' + ids[i]).select2('data') == null ){
                counter += 1;
                $('#' + ids[i]).select2('container')
                    .css('border', '1px solid rgba(185, 74, 72, .9)')
                    .css('border-radius', '4px');
            }
        }
        
        return counter;
    }
    
    function validateDateTime(ids){
        var counter = 0;
        for (var i = 0; i < ids.length; i++){
            if ( $('#' + ids[i]).data('DateTimePicker').getDate() == null || typeof $('#' + ids[i]).data('DateTimePicker').getDate()._i == 'undefined' ){
                counter += 1;
                $('#' + ids[i]).addClass('has-error');
            }
        }
        
        return counter;
    }
    
    function validateTextFields(ids){
        var counter = 0;
        for (var i = 0; i < ids.length; i++){
            if ($('#' + ids[i]).val() == ''){
                $('#' + ids[i]).parent().addClass('has-error');
                counter += 1;
            } else {
				$('#' + ids[i]).parent().removeClass('has-error');
			}
        }
        
        return counter;
    }
    
    $('#submit').click(
        function(){
            var componentIds = getComponentIds();
            
            //Identification form
            var comboValues = getComboValues(componentIds['comboIds']);
            var individualsValues = getIndividualsValues(componentIds['sharedIndivualsIds']);
            var idData = mergeObjects(comboValues, individualsValues); //identification form values
            idData['obs'] = componentIds['observation'];
            
            //Characterizatin form
            var commonComboValues = getComboValues(componentIds['commonComboIds']);
            var dateTime = formatDateTime($('#data').data("DateTimePicker").getDate(), $('#time').data("DateTimePicker").getDate());
            var charData = mergeObjects(commonComboValues, dateTime);
            charData['notas'] = $('#notas').val();
            charData['adn'] = $('#adn').val();
	    
	    //move form
	    var sharedCombosValuesMove = getComboValues(componentIds['sharedCombosIdsMove']);
	    var charrData = mergeObjects(sharedCombosValuesMove, dateTime);
	    
            //Localization form
            var localData = getPlainFieldValues(componentIds['localizationIds']);
            if (componentIds['method'] == 'grid'){
                var gridValues = getComboValues(componentIds['localComboIds']);
                localData = mergeObjects(localData, gridValues);
            }
            localData['local_type'] = componentIds['method'];
           
            var finalData = mergeObjects(idData, charData);
            finalData = mergeObjects(finalData, localData);
	    finalData = mergeObjects(finalData, charrData);
            finalData = mergeObjects(finalData, {'foto': fileName});
            
            $('#dialog').modal('toggle');
            $('#dialog-info')
                .css('display', 'flex')
                .html('A submeter dados. Por favor aguarde...');
            $('#dialog-success').css('display', 'none');
            $('#dialog-progress').css('display', 'block');
            $('#dialog-error').css('display', 'none');
            $.ajax({
	            type: 'POST',
	            url : 'services/new_observation.php',
	            data: finalData,
	            dataType: 'json',
	            success: function(response){
	                if (response.success == true){
	                    $('#dialog-info').css('display', 'none');
                        $('#dialog-success').css('display', 'flex');
                        $('#dialog-progress').css('display', 'none');
                        $('#dialog-btn').css('display', 'block');
                        //clearForm();
                        window.setInterval(location.reload(), 3000);
	                } else {
	                    $('#dialog-info').css('display', 'none');
                        $('#dialog-success').css('display', 'none');
                        $('#dialog-progress').css('display', 'none');
	                    $('#dialog-error')
	                        .css('display', 'flex')
	                        .html('Ocorreu um erro ao obter os dados! ' + response.msg);
	                    $('#dialog-btn').css('display', 'block');
	                }
	            }
	        });
        }
    );
    
    function getPlainFieldValues(ids){
        var results = {};
        for (var i = 0; i < ids.length; i++){
            results[ids[i]] = $('#' + ids[i]).val();
        }
        return results;
    }
    
    function formatDateTime(data, hora){
        var results = {};
        results['dia'] = data._i.d;
        if (typeof data._i.d == 'undefined'){
			results['dia'] = data._i.getDate();
			results['mes'] = data._i.getMonth();
			results['ano'] = data._i.getFullYear();
		} else {
			results['mes'] = data._i.M; //meses começam em 0 e acabam em 11
			results['ano'] = data._i.y;
		}
        
        results['hora'] = hora._d.getHours();
        results['minutos'] = hora._d.getMinutes();
        return results;
    }
    
    function adjustIdNames(ids){
        for (var i = 0; i < ids.length; i++){
            ids[i] = ids[i] + '_aproximate';
        }
        return ids;
    }
    
    function getComboValues(ids){
        var results = {};
        for (var i = 0; i < ids.length; i++){
            if (ids[i] == 'especie'){
                var tempData = $('#' + ids[i]).select2('data').text;
                tempData = tempData.split(' | ');
                results['especie'] = tempData[0];
                results['nome_vulgar'] = '';
                if (tempData.length > 1){
                    results['nome_vulgar'] = tempData[1];
                }
            } else {
                var data = $('#' + ids[i]).select2('data');
                if (data == null){
                    results[ids[i]] = '';
                } else {
                    results[ids[i]] = data.text;
                }
            }
        }
        return results;
    }
    
    function getIndividualsValues(ids){
        var results = {}
        results['individuals'] = $('#' + ids[0]).val();
        results['individuals_type'] = $('input[name="' + ids[1] + '"]:checked').parent().text();
        return results;
    }
    
    function mergeObjects(obj1, obj2){
        for (var name in obj2){
            obj1[name] = obj2[name];
        }
        return obj1;
    }
    
    function clearCombos(ids){
        for (var i = 0; i < ids.length; i++){
            $('#' + ids[i]).select2('val', '');
        }
    }
    
    function clearSpinners(ids){
        $('#' + ids[0]).val('1');
        $('input[name="' + ids[1] + '"]')[0].checked = true;
    }
    
    function clearDateTime(ids){
        for (var i = 0; i < ids.length; i++){
            $('#' + ids[i]).data("DateTimePicker").setDate('');
        }
    }
    
    function clearFields(ids){
        for (var i = 0; i < ids.length; i++){
            $('#' + ids[i]).val('');
        }
    }
    
    function clearForm(){
        var ids = getComponentIds();
        
        //Identification form
        clearCombos(ids.comboIds);
        clearSpinners(ids.sharedIndivualsIds);
        
        //Characterization form
        clearCombos(ids.commonComboIds);
        clearDateTime(['data', 'time']);
        $('#notas').val('');
        $('#adn').val('');
	
        //Localization form
        clearFields(ids.localizationIds);
        if (typeof ids.localComboIds != 'undefined'){
            clearCombos(ids.localComboIds);    
        }
        
        $('#form-tabs a[href="#identification"]').tab('show');
        $('#observation input[name="obs"][value="exacta"]')[0].checked = true;
        $('#aproximate-form').css('display', 'none');
        $('#exact-form').css('display', 'inline');
        
        eraseMarkers(map.greenMarker);
        map.off('click', onMapClick);
        map.off('click', onMapClickAjax);
        map.on('click', onMapClick);
        
        $('#local input[name="local-method"][value="click"]')[0].checked = true;
        $('#xcoord').attr('disabled', true);
        $('#ycoord').attr('disabled', true);
        $('#update-map').css('display', 'none');
        $('#map-aproximate').css('display', 'none');
        $('#biotopo-section').css('display', 'none');
        $('#biotopo-sectionclc5').css('display', 'none');
        
        $('#submit').attr('disabled', true);
        $('#msg-alert').css('display', 'none');
    }

	
	$('#fileupload').fileupload({
		singleFileUploads: true,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                //$('<p/>').text(file.name).appendTo(document.body);
                fileName = file.name;
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
