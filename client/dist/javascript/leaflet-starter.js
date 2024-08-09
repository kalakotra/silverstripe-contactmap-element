var mapHolder = document.getElementsByClassName('contactelement-map');
const maps = {};
for (var x = 0; x < mapHolder.length; x++) {
    var myID = mapHolder[x].id;
    maps[myID] = L.map(myID).setView([51.505, -0.09], 13);
    //var map = L.map(myID).setView([51.505, -0.09], 13);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.dubbelspaeth.de/">Dubbel Späth</a>'
    }).addTo(maps[myID]);

    var childrenMarker = document.getElementById(myID).children;
    var bounds = L.latLngBounds()
    for (var i = 0; i < childrenMarker.length; i++) {
        if (childrenMarker[i].tagName.toLowerCase() == "marker") {
            let lat_lng = [childrenMarker[i].dataset.lat, childrenMarker[i].dataset.lng];
            var marker = L.marker(lat_lng).addTo(maps[myID]);
            marker.bindPopup(childrenMarker[i].dataset.popup);
            bounds.extend(lat_lng);
            console.log(lat_lng);
        }
    }
    maps[myID].fitBounds(bounds);
}