import Map from 'ol/Map.js';
import OSM from 'ol/source/OSM.js';
import TileLayer from 'ol/layer/Tile.js';
import View from 'ol/View.js';
import {fromLonLat} from 'ol/proj.js';

document.addEventListener("DOMContentLoaded", () => {

    const mapHolders = document.querySelectorAll('.bbp-contactmap-element div.contactelement-map');
    
    mapHolders.forEach((mapHolder) => {        
        let mercatorPos = fromLonLat([mapHolder.dataset.lng, mapHolder.dataset.lat]);
        
        let map = new Map({
            target: mapHolder.id,
            layers: [
                new TileLayer({
                    source: new OSM(),
                }),
            ],
            view: new View({
                center: mercatorPos,
                zoom: mapHolder.dataset.mapzoom,
            }),
        });       
    });

});

