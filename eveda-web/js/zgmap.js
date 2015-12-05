(function($){

	var zgmap = window.zgmap = {
		map: null,
		markers: [],
		cdata: [],

		initialize: function(id) {

			this.map = new google.maps.Map(document.getElementById(id || 'map-canvas'), {
				zoom: 2,
				center: new google.maps.LatLng(zgmapInfo.center['lat'], zgmapInfo.center['lng']),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				styles: [ { } ]
			});

			this.mc = new MarkerClusterer(this.map, [], {
				gridSize: 35, // Marker Clusterer Radius
				maxZoom: 12,
				styles: [{
					url: zgmapInfo.url + '/img/ui/cluster.png',
					width: 35,
					height: 35,
					anchor: [10, 0],
					textSize: 12,
				}]
			});

			// Set Initial Zoom Level and Location Manually
			if(zgmapInfo.search){
				google.maps.event.addListenerOnce(this.map, 'bounds_changed', function(){

					var center = new google.maps.LatLng(zgmapInfo.center['lat'], zgmapInfo.center['lng']),
						circle = new google.maps.Circle({
							strokeColor: '#FF6600',
							strokeOpacity: 0.6,
							strokeWeight: 2,
							fillColor: '#FF6600',
							fillOpacity: 0.1,
							map: zgmap.map,
						});


					circle.setRadius(zgmapInfo.radius * 1000);
					circle.setCenter(center);

					zgmap.map.setCenter(center);
					zgmap.map.fitBounds(circle.getBounds());

				});
			}

			this.geocoder = new google.maps.Geocoder();

			function ZGLayer(map) {
				this._map = map;
				this.setMap(map);
			};

			ZGLayer.prototype = new google.maps.OverlayView();
			$.extend(ZGLayer.prototype, {
				onAdd: function() {
					var markerOuter = $('<div class="zglayer popover top"></div')
						.on('click', '.close', $.proxy(this.hide, this));

					this._elm = markerOuter;
					this._elm.on('click', '.ana-link', function(){
						//_gaq.push(['_trackEvent', 'PADI-News', 'External Link', this.href]);
						ga('send', 'event', 'outbound', 'click', this.href);
					});

					this.getPanes().floatPane.appendChild(markerOuter[0]);
				},

				applyOn: function(opt){
					this._opt = opt;
					this._elm.empty().attr('class', 'zglayer popover top').append(
						'<div class="arrow"></div>' +
						'<h3 class="popover-title">' + opt.dealer_name + '<button class="close">&times;</button></h3>' +
						'<div class="popover-content">' +
							(opt.address ? '<p class="p-address">' + opt.address + '</p>' : '') +
							(opt.public_email ? '<p class="p-email"><a href="mailto:' + opt.public_email + '?subject=' + encodeURIComponent(zgmapInfo.cpname) + '">' + opt.public_email + '</a></p>' : '') +
							(opt.phone_number ? '<p class="p-phone">' + opt.phone_number + '</p>' : '') +
						'</div>'
					);

					this.draw();
				},

				draw: function() {
					if(!this._opt){
						return;
					}

					var projection = this.getProjection(),
						pos = projection.fromLatLngToDivPixel(new google.maps.LatLng(this._opt.lat, this._opt.lng));

					this.show();
					this._elm.css({top: pos.y - this._elm.outerHeight(true) - 50, left: pos.x - this._elm.outerWidth(true) / 2 });
				},

				hide: function() {
					if (this._elm) {
						this._elm.hide().removeClass('in');
					}

					this._opt = null;
				},

				show: function() {
					if (this._elm) {
						this._elm.show().addClass('in');
					}
				}
			});

			this.loadMarkers();
			//this.initSearch();
			//this.initFitler();
			this.zglayer = new ZGLayer(this.map);
		},

		loadMarkers: function(href){
			if(zgmapInfo.data && zgmapInfo.data.length){
				var json = zgmapInfo.data,
					bounds = null,
					selected = [],
					count  = 1;

				if(json.length > 1){
					bounds = new google.maps.LatLngBounds();
				}

				$.each(json, function(idx){
					var data = this;

					data.address = data.building_name;

					if(data.address_line1){
						data.address = data.address + ', ' + data.address_line1;
					}
	
					if(data.address_line2){
						data.address = data.address + ', ' + data.address_line2;
					}

					if(data.town_city){
						data.address = data.address + ', ' + data.town_city;
					}

					if(data.region && data.region != 'N/A'){
						data.address = data.address + ', ' + data.region;
					}

					if(data.postcode){
						data.address = data.address + ', ' + data.postcode;
					}

					if(data.country){
						data.address = data.address + ', ' + data.country;
					}

					var pos = new google.maps.LatLng(data.lat, data.lng);

					var marker = new google.maps.Marker({
						position: pos,
						map: count++ > zgmapInfo.limit ? null : zgmap.map,
						title: data.title,
						icon: zgmapInfo.url + '/img/ui/' + (data.marker ? data.marker  : 'marker.png')
					});

					marker.data = data;

					google.maps.event.addListener(marker, 'click', function(event) {
						if(data.mtype > 0 && $.fancybox){
							zgmap.zglayer.hide();

							$.fancybox({
								href: data.link,
								type: data.mtype == 1 ? 'inline' : 'iframe'
							});

						} else {
							zgmap.zglayer.applyOn(data);
						}

						zgmap.map.panTo(pos);
					});

					if(bounds) {
						bounds.extend(pos);
					}

					zgmap.markers.push(marker);
					(!zgmapInfo.limit || count > zgmapInfo.limit + 1) && selected.push(marker);
				});

				// Set Initial Zoom Level and Location Based on Markers

				//if(bounds){
					//zgmap.map.fitBounds(bounds);
				//} else {
					//zgmap.map.panTo(new google.maps.LatLng(json[0].lat, json[0].lng));
				//}

				// Then Add Markers

				this.mc.addMarkers(selected);
			}
		},

		showMore: function(){

			zgmap.mc.removeMarkers(zgmap.markers);
			for(var i = 0, il = zgmap.markers.length; i < il; i++){
				zgmap.markers[i].setMap(zgmap.map);
			}

			zgmap.mc.addMarkers(zgmap.markers);
		},

		initFitler: function(pos){

			$('.cat-list').on('click', 'a', function(e){
				e.preventDefault();

				if($(this).parent().hasClass('selected')){
					return;
				}

				zgmap.mc.removeMarkers(zgmap.markers);

				if($(this).hasClass('catall')){
					for(var i = 0, il = zgmap.markers.length; i < il; i++){
						zgmap.markers[i].setMap(zgmap.map);
					}

					zgmap.mc.addMarkers(zgmap.markers);

				} else {
					var catid = $(this).attr('href'),
						markers = zgmap.markers,
						selected = [],
						marker = null;

					catid = catid && catid.replace(/.*(?=#[^\s]*$)/, '').substr(1);

					for(var i = 0, il = zgmap.markers.length; i < il; i++){
						if(catid == markers[i].data.catid){
							zgmap.markers[i].setMap(zgmap.map);
							selected.push(zgmap.markers[i]);
						} else {
							zgmap.markers[i].setMap(null);
						}
					}

					zgmap.mc.addMarkers(selected);
				}

				$(this).parent().addClass('selected').siblings().removeClass('selected');
			});
		},

		initSearch: function(){
			$('#form-geocode').on('submit', function(e){

				var addr = $(this['map-kw']).val();

				if(addr == ''){
					alert('Please enter address field or postal code');
					return false;
				}

				zgmap.geocoder.geocode( { 'address': addr }, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {

						zgmap.createMarker(results[0].geometry.location);
					} else {
						alert("Geocode was not successful for the following reason: " + status);
					}
				});

				return false;
			});
		},

		clearMarker: function(){
			for(var i = 0, il = this.markers.length; i < il; i++){
				this.markers[i].setMap(null);
			}

			this.markers.length = 0;
		},

		createMarker: function(pos){

			new google.maps.Marker({
				position: pos,
				map: this.map,
				icon: zgmapInfo.url + '/img/ui/marker.png'
			});

			this.map.panTo(pos);
			this.map.setZoom(13);
		}
	};

})(jQuery);


jQuery(function($){
	$('#gmap-wrap').mousedown(function () {
		$(this).children().css('pointer-events', 'auto');
	}).mouseleave(function() {
		$(this).children().css('pointer-events', 'none'); 
	}).one('mouseover', function(){
		$(this).addClass('dirty');
	});

	setTimeout(function(){
		if(!$('#gmap-wrap').hasClass('dirty')){
			$('#gmap-wrap').children().css('pointer-events', 'none');
		}
	}, 10);
});