var zgmap = window.zgmap = {

	map: null,
	geocoder: null,
	marker: null,

	latElm: null,
	lngElm: null,

	initialize: function(config) {

		this.config = config;
		this.latElm = document.getElementById(config.lat);
		this.lngElm = document.getElementById(config.lng);
		this.map = new google.maps.Map(document.getElementById(config.map), {
			zoom: 11,
			center: new google.maps.LatLng(58.890037, -3.050858),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
		this.geocoder = new google.maps.Geocoder();

		//if edit mode
		if(this.latElm.value != '' && this.lngElm.value != ''){ //check for the previous value
			this.initMarker(new google.maps.LatLng(this.latElm.value, this.lngElm.value));
		} else {
			google.maps.event.addListener(this.map, 'click', function(event) {
				if(!zgmap.marker){
					zgmap.initMarker(event.latLng);
				}
			});
		}

		$('#' + config.geocode).bind('click', this.geocode);

		this.initInputChange();
	},

	initMarker: function(pos){
		if(zgmap.marker){
			zgmap.marker.setMap(null);
			zgmap.marker = null;
		}

		var marker = new google.maps.Marker({
			draggable: true,
			position: pos,
			map: this.map
		});

		google.maps.event.addListener(marker, 'dragend', function(event) {
			zgmap.latElm.value = event.latLng.lat();
			zgmap.lngElm.value = event.latLng.lng();
		});

		this.latElm.value = pos.lat();
		this.lngElm.value = pos.lng();
		this.marker = marker;

		this.map.panTo(pos);
	},

	initInputChange: function(){
		$(this.latElm).add(this.lngElm).change(function(){
			if(zgmap.marker){
				var npos = new google.maps.LatLng(zgmap.latElm.value, zgmap.lngElm.value);
				zgmap.marker.setPosition(npos);
			}
		});
	},

	geocode: function(){
		var addr = '',
			config = zgmap.config,
			address = $('#' + config.address).val(),
			city = $('#' + config.city).val(),
			state = $('#' + config.state).val(),
			country = $('#' + config.country).val(),
			postalcode = $('#' + config.postalcode).val();

		if(address != ''){
			addr += address + ', ';
		}

		if(city != ''){
			addr += city + ', ';
		}
		if(state != ''){
			addr += state + ', ';
		}
		if(country != ''){
			addr += country + ', ';
		}

		if(postalcode != ''){
			addr += postalcode + ', ';
		}

		addr = addr.substring(0, addr.length - 2);

		if(address == '' && postalcode == ''){
			alert('Please enter address field or postal code');
			return false;
		}

		zgmap.geocoder.geocode({'address': addr}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				zgmap.initMarker(results[0].geometry.location);
			} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
};