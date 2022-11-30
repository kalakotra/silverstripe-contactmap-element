const gmKey = "$KEY";
const mapHolders = document.querySelectorAll('.bbp-contactmap-element div.contactelement-map');
const mapURL = 'https://maps.googleapis.com/maps/api/staticmap';

document.addEventListener("DOMContentLoaded", () => {
    addMaps();
});


function addMaps() {
    mapHolders.forEach((mapHolder) => {

        let mapWidth = mapHolder.scrollWidth;
        let mapHeight = mapHolder.scrollHeight;

        let sourceURL = new URL(mapURL);
        sourceURL.searchParams.set('size', mapWidth + 'x' + mapHeight);
        sourceURL.searchParams.set('scale', 2);
        sourceURL.searchParams.set('key', gmKey);
        sourceURL.searchParams.set('zoom', mapHolder.dataset.mapzoom);
        sourceURL.searchParams.set('markers', mapHolder.dataset.lat + ',' + mapHolder.dataset.lng);

        let mapImg = document.createElement('img');
        mapImg.classList.add('img-fluid');
        mapImg.src = sourceURL.href;
        
        mapHolder.insertAdjacentElement('afterbegin', mapImg);
    });
}
