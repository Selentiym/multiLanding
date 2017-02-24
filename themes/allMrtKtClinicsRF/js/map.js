function AddMapPoint(address) {
	ymaps.ready(function () {
		var map = new ymaps.Map('map', {}, {
				searchControlProvider: 'yandex#search'
			});
		var geocoder = new YMaps.Geocoder(address);
		YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
			if (this.length() > 0) {
				
				map.addOverlay(this.get(0));
				//map.panTo(this.get(0).getGeoPoint())
			} else {
				alert('none found');
			}
		});
		 
		YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (error) {
			alert("Произошла ошибка при определении кординат: " + error.message)
		});
	});
}

function addCoords(coords, hint) {
	ymaps.ready(function () {
		if (typeof myMap != "object") {
		myMap = new ymaps.Map('map', {
				center: coords,
				zoom: 14
			}, {
				searchControlProvider: 'yandex#search'
			})
		}
		place = new ymaps.Placemark( coords, {
			hintContent: hint
		});
		myMap.geoObjects.add(place);
		//myMap.setBounds(myMap.GeoObjects.getBounds());
		//myMap.geoObjects.add(place);
		//var bounds = myMap.GeoCollectionBounds();
		//myMap.setBounds(bounds);
	});
}