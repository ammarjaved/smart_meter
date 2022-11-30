var lvdb_l1 = L.layerGroup();
var SFP_L2 = L.layerGroup();
var MFP_L3 = L.layerGroup();
var demand_point = L.layerGroup();
var current_dropdown_Lid='%';
var current_phase_val='%';
var latlngsarr = Array();
var l1;
var l2;
var l3;
var filter_polylines_arr=Array();
var point_polylines_arr=Array();
var line_l1_l2_l3_markers = L.layerGroup();
var current_dropdown_latlng;
var identifyme='';

var color1='red'
var color2='yellow'
var color3='blue'
var linescolor=['white','orange','grey']
var phase_val="";

   
    var street   = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'),
    dark  = L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/dark_all/{z}/{x}/{y}.png'),
    googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
    });
	

    not_installed = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
        layers: 'cite:not_installed',
        format: 'image/png',
        maxZoom: 21,
        transparent: true
    }, {buffer: 10});
    total_order = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
        layers: 'cite:total_order',
        format: 'image/png',
        maxZoom: 21,
        transparent: true
    }, {buffer: 10});
	
	total_tras = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
        layers: 'cite:total_tras',
        format: 'image/png',
        maxZoom: 21,
        transparent: true
    }, {buffer: 10});
	total_installed = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
        layers: 'cite:total_installed',
        format: 'image/png',
        maxZoom: 21,
        transparent: true
    }, {buffer: 10});

    site_info = L.tileLayer.wms("http://121.121.232.54:7090/geoserver/cite/wms", {
        layers: 'cite:site_info',
        format: 'image/png',
        maxZoom: 21,
        transparent: true
    }, {buffer: 10});


    



        
    var map = L.map('map_div', {
        center: [3.016603, 101.858382],
        // center: [31.5204, 74.3587],
        zoom: 10,
        layers: [googleSat,site_info],
        attributionControl:false
    });
	

function preNext(status){
    $("#wg").html('');
    $.ajax({
        url: 'services/pre_next.php?id='+selectedId+'&st='+status,
        dataType: 'JSON',
        //data: data,
        method: 'GET',
        async: false,
        success: function callback(data) {

            //  alert(data
            var str='<div id="window1" class="window">' +
                '<div class="green">' +
                '<p class="windowTitle">Pano Images</p>' +
                '</div>' +
                '<div class="mainWindow">' +
                // '<canvas id="canvas" width="400" height="480">' +
                // '</canvas>' +
                '<div id="panorama" width="400px" height="480px"></div>'+
                '<div class="row"><button style="margin-left: 30%;" onclick=preNext("pre") class="btn btn-success">Previous</button><button  onclick=preNext("next")  style="float: right;margin-right: 35%;" class="btn btn-success">Next</button></div>'
            '</div>' +
            '</div>'

            $("#wg").html(str);

            createWindow(1);
          //  console.log(data)
            // var canvas = document.getElementById('canvas');
            // var context = canvas.getContext('2d');
            // context.clearRect(0,0 ,canvas.width,canvas.height)
            //     img.src = data.features[0].properties.image_path;
            //     init_pano('canvas')
            // setTimeout(function () {
            //     init_pano('canvas')
            // },1000)=
            selectedId=data[0].gid
            pannellum.viewer('panorama', {
                "type": "equirectangular",
                "panorama": data[0].photo,
                "compass": true,
                "autoLoad": true
            });

            if(identifyme!=''){
                map.removeLayer(identifyme)
            }
            identifyme = L.geoJSON(JSON.parse(data[0].geom)).addTo(map);


        }
    });

}

// function activeSelectedLayerPano() {
// //alert(val)
//    // map.off('click');
//     map.on('click', function(e) {
//         //map.off('click');
//         $("#wg").html('');
//         // Build the URL for a GetFeatureInfo
//         var url = getFeatureInfoUrl(
//             map,
//             pano_layer,
//             e.latlng,
//             {
//                 'info_format': 'application/json',
//                 'propertyName': 'NAME,AREA_CODE,DESCRIPTIO'
//             }
//         );
//         $.ajax({
//             url: 'services/proxy.php?url='+encodeURIComponent(url),
//             dataType: 'JSON',
//             //data: data,
//             method: 'GET',
//             async: false,
//             success: function callback(data) {
//
//                 //  alert(data
//                 var str='<div id="window1" class="window">' +
//                     '<div class="green">' +
//                     '<p class="windowTitle">Pano Images</p>' +
//                     '</div>' +
//                     '<div class="mainWindow">' +
//                     // '<canvas id="canvas" width="400" height="480">' +
//                     // '</canvas>' +
//                     '<div id="panorama" width="400px" height="480px"></div>'+
//                     '<div class="row"><button style="margin-left: 30%;" onclick=preNext("pre") class="btn btn-success">Previous</button><button  onclick=preNext("next")  style="float: right;margin-right: 35%;" class="btn btn-success">Next</button></div>'
//
//                 '</div>' +
//                 '</div>'
//
//                 $("#wg").html(str);
//
//
//                 console.log(data)
//                 if(data.features.length!=0){
//                     createWindow(1);
//                     selectedId=data.features[0].id.split('.')[1];
//                     // var canvas = document.getElementById('canvas');
//                     // var context = canvas.getContext('2d');
//                     // context.clearRect(0,0 ,canvas.width,canvas.height)
//                     //     img.src = data.features[0].properties.image_path;
//                     //     init_pano('canvas')
//                     // setTimeout(function () {
//                     //     init_pano('canvas')
//                     // },1000)
//                     pannellum.viewer('panorama', {
//                         "type": "equirectangular",
//                         "panorama": data.features[0].properties.photo,
//                         "compass": true,
//                         "autoLoad": true
//                     });
//                     if(identifyme!=''){
//                         map.removeLayer(identifyme)
//                     }
//                     identifyme = L.geoJSON(data.features[0].geometry).addTo(map);
//
//                 }
//
//             }
//         });
//
//
//
//
//     });
// }

function getFeatureInfoUrl(map, layer, latlng, params) {

    var point = map.latLngToContainerPoint(latlng, map.getZoom()),
        size = map.getSize(),

        params = {
            request: 'GetFeatureInfo',
            service: 'WMS',
            srs: 'EPSG:4326',
            styles: layer.wmsParams.styles,
            transparent: layer.wmsParams.transparent,
            version: layer._wmsVersion,
            format:layer.wmsParams.format,
            bbox: map.getBounds().toBBoxString(),
            height: size.y,
            width: size.x,
            layers: layer.wmsParams.layers,
            query_layers: layer.wmsParams.layers,
            info_format: 'application/json'
        };

    params[params.version === '1.3.0' ? 'i' : 'x'] = parseInt(point.x);
    params[params.version === '1.3.0' ? 'j' : 'y'] = parseInt(point.y);

    // return this._url + L.Util.getParamString(params, this._url, true);

    var url = layer._url + L.Util.getParamString(params, layer._url, true);
    if(typeof layer.wmsParams.proxy !== "undefined") {


        // check if proxyParamName is defined (instead, use default value)
        if(typeof layer.wmsParams.proxyParamName !== "undefined")
            layer.wmsParams.proxyParamName = 'url';

        // build proxy (es: "proxy.php?url=" )
        _proxy = layer.wmsParams.proxy + '?' + layer.wmsParams.proxyParamName + '=';

        url = _proxy + encodeURIComponent(url);

    }

    return url.toString();

}

var tempLayer='';
function getProperties(layer1){
    var layer=''

    if(layer1=='total_order'){
        layer=total_order;
    }
    if(layer1=='not_installed'){
        layer=not_installed;
    }
    if(layer1=='site_info'){
        layer=site_info;
    }
    if(layer1=='total_tras'){
        layer=total_tras;
    }
    if(layer1=='total_installed'){
        layer=total_installed;
    }
    // if(layer1=='light_panel'){
    //     layer=light_panel;
    // }
    map.off('click');
    map.on('click', function(e) {
       // map.off('click');

        // Build the URL for a GetFeatureInfo
        var url = getFeatureInfoUrl(
            map,
            layer,
            e.latlng,
            {
                'info_format': 'application/json',
                'propertyName': 'NAME,AREA_CODE,DESCRIPTIO'
            }
        );
        $.ajax({
            url: 'services/proxy.php?url='+encodeURIComponent(url),
            dataType: 'JSON',
            //data: data,
            method: 'GET',
            async: false,
            success: function callback(data) {
                clearAll();

                if(layer1=='site_info'){
                    var popupContent="<table class='table table-bordered'>" +
                    "<tr>" +
                        "<td>installation_id</td>" +
                        "<td>"+data.features[0].properties.installation_id+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Status</td>" +
                        "<td>"+data.features[0].properties.status+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Old Meter no</td>" +
                        "<td>"+data.features[0].properties.old_meter_no+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>New Meter no</td>" +
                        "<td>"+data.features[0].new_meter_no+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Phase</td>" +
                        "<td>"+data.features[0].properties.phase+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Remarks</td>" +
                        "<td>"+data.features[0].properties.remarks+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Pic Before</td>" +
                        "<td><a class='example-image-link' href='"+data.features[0].properties.pic_before+"' data-lightbox='example-set' data-title='Before Pic'><img src='"+data.features[0].properties.pic_before+"' height='50'/></a></td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Pic After</td>" +
                        "<td><a class='example-image-link' href='"+data.features[0].properties.pic_after+"' data-lightbox='example-set' data-title='After pic'><img src='"+data.features[0].properties.pic_after+"' height='50'/></a></td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Created at</td>" +
                        "<td>"+data.features[0].properties.created_at+"</td>" +
                        "</tr>" +
                        

                        "</table>"
                    newMarker1 = new L.marker([data.features[0].geometry.coordinates[1],data.features[0].geometry.coordinates[0]]).addTo(map).bindPopup(popupContent).openPopup();

                }

                if(layer1=='total_order'){

                    var popupContent="<table class='table table-bordered'>" +
                    "<tr>" +
                        "<td>Device No</td>" +
                        "<td>"+data.features[0].properties.device_no+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Customer Name</td>" +
                        "<td>"+data.features[0].properties.customer_name+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Address</td>" +
                        "<td>"+data.features[0].properties.address+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Meter Type</td>" +
                        "<td>"+data.features[0].properties.meter_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Premise Type</td>" +
                        "<td>"+data.features[0].properties.premise_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Voltage</td>" +
                        "<td>"+data.features[0].properties.voltage_level+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Rate Category</td>" +
                        "<td>"+data.features[0].properties.rate_category+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Service Order</td>" +
                        "<td>"+data.features[0].properties.service_order+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>MR Unit</td>" +
                        "<td>"+data.features[0].properties.mr_unit+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Installation ID</td>" +
                        "<td>"+data.features[0].properties.installation+"</td>" +
                        "</tr>" +
                        "<td>Installation Status</td>" +
                        "<td>"+data.features[0].properties.installed_status+"</td>" +
                        "</tr>" +
                        "</table>"
                    newMarker1 = new L.marker([data.features[0].geometry.coordinates[1],data.features[0].geometry.coordinates[0]]).addTo(map).bindPopup(popupContent).openPopup();
                }
                if(layer1=='not_installed'){

                    var popupContent="<table class='table table-bordered'>" +
                    "<tr>" +
                        "<td>Device No</td>" +
                        "<td>"+data.features[0].properties.device_no+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Customer Name</td>" +
                        "<td>"+data.features[0].properties.customer_name+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Address</td>" +
                        "<td>"+data.features[0].properties.address+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Meter Type</td>" +
                        "<td>"+data.features[0].properties.meter_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Premise Type</td>" +
                        "<td>"+data.features[0].properties.premise_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Voltage</td>" +
                        "<td>"+data.features[0].properties.voltage_level+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Rate Category</td>" +
                        "<td>"+data.features[0].properties.rate_category+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Service Order</td>" +
                        "<td>"+data.features[0].properties.service_order+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>MR Unit</td>" +
                        "<td>"+data.features[0].properties.mr_unit+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Installation ID</td>" +
                        "<td>"+data.features[0].properties.installation+"</td>" +
                        "</tr>" +
                        "<td>Installation Status</td>" +
                        "<td>"+data.features[0].properties.installed_status+"</td>" +
                        "</tr>" +
                        "</table>"
                    newMarker1 = new L.marker([data.features[0].geometry.coordinates[1],data.features[0].geometry.coordinates[0]]).addTo(map).bindPopup(popupContent).openPopup();
                }

                if(layer1=='total_installed'){

                    var popupContent="<table class='table table-bordered'>" +
                    "<tr>" +
                        "<td>Device No</td>" +
                        "<td>"+data.features[0].properties.device_no+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Customer Name</td>" +
                        "<td>"+data.features[0].properties.customer_name+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Address</td>" +
                        "<td>"+data.features[0].properties.address+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Meter Type</td>" +
                        "<td>"+data.features[0].properties.meter_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Premise Type</td>" +
                        "<td>"+data.features[0].properties.premise_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Voltage</td>" +
                        "<td>"+data.features[0].properties.voltage_level+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Rate Category</td>" +
                        "<td>"+data.features[0].properties.rate_category+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Service Order</td>" +
                        "<td>"+data.features[0].properties.service_order+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>MR Unit</td>" +
                        "<td>"+data.features[0].properties.mr_unit+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Installation ID</td>" +
                        "<td>"+data.features[0].properties.installation+"</td>" +
                        "</tr>" +
                        "<td>Installation Status</td>" +
                        "<td>"+data.features[0].properties.installed_status+"</td>" +
                        "</tr>" +
                        "</table>"
                    newMarker1 = new L.marker([data.features[0].geometry.coordinates[1],data.features[0].geometry.coordinates[0]]).addTo(map).bindPopup(popupContent).openPopup();
                }

                if(layer1=='total_tras'){

                    var popupContent="<table class='table table-bordered'>" +
                    "<tr>" +
                        "<td>Device No</td>" +
                        "<td>"+data.features[0].properties.device_no+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Customer Name</td>" +
                        "<td>"+data.features[0].properties.customer_name+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Address</td>" +
                        "<td>"+data.features[0].properties.address+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Meter Type</td>" +
                        "<td>"+data.features[0].properties.meter_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Premise Type</td>" +
                        "<td>"+data.features[0].properties.premise_type+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Voltage</td>" +
                        "<td>"+data.features[0].properties.voltage_level+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Rate Category</td>" +
                        "<td>"+data.features[0].properties.rate_category+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Service Order</td>" +
                        "<td>"+data.features[0].properties.service_order+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>MR Unit</td>" +
                        "<td>"+data.features[0].properties.mr_unit+"</td>" +
                        "</tr>" +
                        "<tr>" +
                        "<td>Installation ID</td>" +
                        "<td>"+data.features[0].properties.installation+"</td>" +
                        "</tr>" +
                        "<td>Installation Status</td>" +
                        "<td>"+data.features[0].properties.installed_status+"</td>" +
                        "</tr>" +
                        "</table>"
                    newMarker1 = new L.marker([data.features[0].geometry.coordinates[1],data.features[0].geometry.coordinates[0]]).addTo(map).bindPopup(popupContent).openPopup();
                }
            }
        });
      //  $('#nonsurvedmodal').modal('show');
       // activeSelectedLayerPano();
    });
    
}

        

var baseLayers = {
    "Street": street,
    "Satellite": googleSat,
    "Dark": dark,
};

var overlays = {
    "Site Info":site_info,
    "Not installed":not_installed,
    "Total Orders":total_order,
	"Total Tras":total_tras,
	"Total installed":total_installed  
   
};

L.control.layers(baseLayers, overlays).addTo(map);






function fillCounts(){
    var week , month, year
    month = $("#month_select").val()
    year = $("#year_select").val()
    week = $("#week_select").val()
    
    $.ajax({
        url: "services/get_counts_values.php?week="+week+"&month="+month+"&year="+year ,
        type: "GET",
        dataType: "json",
        //data: JSON.stringify(geom,layer.geometry),
        // contentType: "application/json; charset=utf-8",
        success: function callback(data) {
            // var r=JSON.parse(response)
              
                 $("#tryb").text(data.total[0].count);
           
                 $("#sred").text(data.not_surveyed[0].count);
           
                 $("#syellow").text(data.installed[0].count);
            
                 $("#sblue").text(data.tras[0].count);

                 $("#stoday").text(data.remaining[0].count);

                 $("#sweek").text(data.week[0].count);


           
            
            } 
           
    });
}

function setWeek_er(){
    var week , month, year
    month = $("#month_select").val()
    year = $("#year_select").val()
    week = $("#week_select").val()
    if(week === ""){
        $("#er_week").html("This Feild is required *")
    }else{$("#er_week").html("")}
    if(month === ""){
        $("#er_month").html("This Feild is required *")
    }else{$("#er_month").html("")}
    if(year === ""){
        $("#er_year").html("This Feild is required *")
    }
    if(week === "" || month === "" || year === ""){
        return false
    }else{$("#er_year").html("")}
    
    
    

    fillCounts()
}



function getAllDemandpoints(){
    
    $.ajax({
        url: "services/get_all_dp.php",
        type: "GET",
        dataType: "json",
        //data: JSON.stringify(geom,layer.geometry),
        contentType: "application/json; charset=utf-8",
        success: function callback(data) {
          // console.log(data)
           var str='';
           for(var i=0;i<data.length;i++){
            
            str=str+'<tr id='+data[i].p_id+' onclick="getdpxy('+"'"+data[i].device_id+"'"+','+data[i].x+','+data[i].y+')">'+'<td>'+data[i].p_id+'</td>'+'<td>'+data[i].house_no+'</td>'+'<td>'+data[i].str_name+'</td>'+'<td>'+data[i].device_id+'</td>'+'<td>'+data[i].remarks+'</td>'+'</tr>';
           }
           $("#dpt").html(str);
           $('#example').DataTable();
           

         

        }     
    });
}

var newMarker1='';
function getAllDemandpoints1(di){

    $.ajax({
        url: "services/get_all_dp1.php?di="+di,
        type: "GET",
        dataType: "json",
        //data: JSON.stringify(geom,layer.geometry),
        contentType: "application/json; charset=utf-8",
        success: function callback(data) {
            console.log(data)
              var y=parseFloat(data.xy[0].y)
            var x=parseFloat(data.xy[0].x)
            map.setView([y, x], 20);
            if (newMarker1 != '') {
                map.removeLayer(newMarker1)
            }
            var popupContent="<table><tr><td>Total LED</td><td>" + (parseInt(data.count[0].count)+ parseInt(data.count[1].count))+ "</td></tr><tr><td>Total LED</td><td>" + data.count[0].count + "</td></tr><tr><td>Total SODIUM</td><td>" + data.count[1].count + "</td></tr></table><button style='margin-top: 10px;' class='btn btn-danger' onclick=getdpxy('"+di+"')>select Lights</button>"
            newMarker1 = new L.marker([y, x]).addTo(map).bindPopup(popupContent).openPopup();



        }
    });
}


var newMarker='';
var dataLayer='';

function getdpxy(id){

        // map.setView([y, x], 18);
        // if (newMarker != '') {
        //     map.removeLayer(newMarker)
        // }
        // newMarker = new L.marker([y, x]).addTo(map);

        $.ajax({
            url: "services/strret_lights.php?di=" + id,
            type: "GET",
            dataType: "json",
            //data: JSON.stringify(geom,layer.geometry),
            contentType: "application/json; charset=utf-8",
            success: function callback(data) {
                var myIcon = L.icon({
                    iconUrl: 'images/test.gif',
                    iconSize: [22, 27],
                    iconAnchor: [16, 37],
                    popupAnchor: [0, -28]
                });

                if (dataLayer != '') {
                    map.removeLayer(dataLayer)
                }
                dataLayer = L.geoJson(data, {
                    pointToLayer: function (feature, latlng) {
                        //return L.circleMarker(latlng, geojsonMarkerOptions);
                        console.log(feature)
                        return L.marker(latlng, {icon: myIcon});
                    }
                    ,
                    onEachFeature: function (feature, layer) {

                        layer.bindPopup('<table><tr><td>id</td><td>' + feature.properties.p_id + '</td></tr><tr><td>pole type</td><td>' + feature.properties.pole_type + '</td></tr><tr><td>type</td><td>' + feature.properties.type + '</td></tr> <tr><td>pole number</td><td>' + feature.properties.pole_number + '</td></tr> <tr><td>Watt</td><td>' + feature.properties.watt + '</td></tr> <tr><td>phasing</td><td>' + feature.properties.phasing + '</td></tr><tr><td>brand</td><td>' + feature.properties.brand + '</td></tr></table>');
                    }
                });
                dataLayer.addTo(map);

            }
        });
       // alert(id+x+y);
   
}

function clearAll(){
    if (newMarker != '') {
        map.removeLayer(newMarker)
    }
    if (newMarker1 != '') {
        map.removeLayer(newMarker1)
    }

    if (dataLayer != '') {
        map.removeLayer(dataLayer)
    }
    if(tempLayer!=''){
        map.removeLayer(tempLayer)
    }
    //map.setView([3.016603, 101.858382],12);
}

$(document).ready(function(){
    fillCounts();
    // getProperties('total_order');
    // getProperties('not_installed');
    // getProperties('total_tras');
    // getProperties('total_installed');
    // getProperties('site_info')
    typeaheadsearch();
    setWeekAndYear();
    

    $('#py_select').append(`<option value="total_order">Total Order</option>`);
    $('#py_select').append(`<option value="not_installed">Not Installed</option>`);
    $('#py_select').append(`<option value="total_tras">Total Tras</option>`);
    $('#py_select').append(`<option value="total_installed">Total Installed</option>`);
    $('#py_select').append(`<option value="site_info">Site Info</option>`);

    $("#excel").on("change", function (e) {
    var formData = new FormData();
    formData.append('excel', $('#excel')[0].files[0]);

    $.ajax({
        url : 'services/upload_excel_2.php',
        type : 'POST',
        data : formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,  // tell jQuery not to set contentType
        success : function(data) {
            console.log(data);
            alert(data);
        }
    });

    });


    //getProperties()
   // getAllDemandpoints();
    
});
//-----------add remove geojson----------  


function uploadExcel(){
    $('#excel').click();
}


//-----------on change fp dropdown----------  




function select_attributes(){

   let vab;
   vab =  $( "#py_select option:selected" ).val();
    getProperties(vab)
    // alert(vab)
}


//---------------MAIN MENU Dropdown-----------------

function dispalySelect(){
    var check = ($(".selcet_area").css("display")== "none") ? 'block' : 'none';
    $(".selcet_area").css("display",check)
    $(".upload_Excel").css("display","none")
}

function displayUploadExcel(){
    var check = ($(".upload_Excel").css("display")== "none") ? 'block' : 'none';
    $(".upload_Excel").css("display",check)
    $(".selcet_area").css("display","none")
}

//--------------Download sample file -----------
function SampleFile(){

        window.location.href = '/smart_meter/services/files/Sample.xlsx';
   
}





function search_deviceid(){
    var deviceid='';
    var chktblname = $("input[name='optradio']:checked").val();

    if(chktblname=='so'){
         deviceid = $("#search_input1").val(); 
    }
    if(chktblname=='meter_no'){
         deviceid = $("#search_input2").val(); 
    }
   
   
    // alert(chktblname)

        $.ajax({
            url: "services/returnxy.php?did="+ deviceid + "&lyr=" + chktblname,
            type: "GET",
            async: false,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function callback(response) {
               console.log(response);
               var latlng=[response[0].y, response[0].x]
                map.setView(latlng,19);
                L.marker(latlng).addTo(map);
            }
        });
}





function typeaheadsearch(){
    $('.typeahead').unbind('typeahead');
    var tblname;
    var radioValue = $("input[name='optradio']:checked").val();
    // alert(radioValue)
        if(radioValue=='so'){
            $('#search_input1').show();
            $('#search_input2').hide();
        }
        if(radioValue=='meter_no'){
            $('#search_input1').hide();
            $('#search_input2').show();
           
        }
       

        $('#search_input1').typeahead({
            name: 'hce1',
            remote:'services/search.php?key=%QUERY'+ "&tblname=so",
            limit: 5
        });

        $('#search_input2').typeahead({
            name: 'hce2',
            remote:'services/search.php?key=%QUERY'+ "&tblname=meter_no",
            limit: 5
        });

       
    }


function setWeekAndYear(){
 
     $("#week_select").val();
     $.ajax({
        url: "services/get_week_values.php",
        type: "GET",
        dataType: "json",
        //data: JSON.stringify(geom,layer.geometry),
        contentType: "application/json; charset=utf-8",
        success: function callback(data) {
            // var r=JSON.parse(response)
              for(i =0 ; i<data.year.length ; i++){
                $('#year_select').append(`<option value="${data.year[i].year}">${data.year[i].year}</option>`);
              }
              for(j =0 ; j<data.month.length ; j++){
                $('#month_select').append(`<option value="${data.month[j].month}">${data.month[j].month}</option>`);
              }
              for(k =0 ; k<data.week.length ; k++){
                $('#week_select').append(`<option value="${data.week[k].week_no}">${data.week[k].week_no}</option>`);
              }
           
                 
               


           
           
        }   
    });

}

