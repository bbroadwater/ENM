$(document).ready(function(){
  var val = 2010;

  $('#world-map').vectorMap({
    map: 'world_mill_en',
    markers: mapData_markers.coords,
    backgroundColor: "#FFFFFF",
    series: {
      markers : [{
        scale: {
            '0': '#12C364',
            '1': '#75C6E8',
            '2': '#e54848',
            '3': '#a3a3a3',
			'4': '#E8D86E'
        },
        values: mapData_markers.colors[val],
        attribute: 'fill'       
      }],
      regions: [{
        scale: {
            '0': '#12C364',
            '1': '#75C6E8',
            '2': '#e54848',
            '3': '#a3a3a3',
			'4': '#E8D86E'
        },
        values: mapData_category[val],
        attribute: "fill"
      }]
    },
    onRegionLabelShow: function (event, label, code) {
        if (mapData[val][code]>=0.0) {
            label.html("<div class='bubble'><div class='ttText'><div class='ttName'>" + label.html() + "</div><div class='ttState'>" + (code,mapData[val][code]) + "MM <div class='ttResize'>Spending Wave 45-49 Developed Countries <br> Workforce 15-64 Developing Countries</div></div></div></div>")
        } else {
            label.html("");   
        }
    },
    onMarkerLabelShow: function (event, label, code) {
        label.html("<div class='bubble'><div class='ttText'><div class='ttName'>" + mapData_markers.names[code] + "</div><div class='ttState'>" + mapData_markers.ages[val][code] + "% <div class='ttResize'>Age Range 45-49</div></div></div></div>")
    },   
    regionStyle: {
        initial: {
            fill: '#ccc'
        },
        hover: {
            "fill-opacity": 1
        }
    },
    markerStyle: {
        initial: {
          "stroke":"white",
          "stroke-width":1,
          "r": 5
        },
        hover: {
          "stroke":"white",
          "stroke-width":1,
          "r": 5
        }
    }
    });
    var mapObject = $('#world-map').vectorMap('get', 'mapObject');

    $("#slider").slider({
      value: val,
      min: 2010,
      max: 2100,
      step: 5,
      slide: function( event, ui ) {
        val = ui.value;
        mapObject.series.regions[0].setValues(mapData[ui.value]);
        mapObject.series.regions[0].setValues(mapData_category[ui.value]);
        mapObject.series.markers[0].setValues(mapData_markers.ages[ui.value]);
        mapObject.series.markers[0].setValues(mapData_markers.colors[ui.value]);        
        $("#bigYear").html(val);
      }    
    });
});
//latest