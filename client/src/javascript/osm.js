import Map from 'ol/Map.js';
import OSM from 'ol/source/OSM.js';
import TileLayer from 'ol/layer/Tile.js';
import View from 'ol/View.js';
import {fromLonLat} from 'ol/proj.js';
import Vector from 'ol/layer/Vector.js';
import SourceVector from 'ol/source/Vector.js';
import Style from 'ol/style/Style.js';
import Icon from 'ol/style/Icon.js';
import Feature from 'ol/Feature.js';
import Point from 'ol/geom/Point.js';
import {defaults as defaultInterations} from 'ol/interaction';

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
            interactions: defaultInterations({
                mouseWheelZoom: false
            })
        });

        let markers = new Vector({
            source: new SourceVector(),
            style: new Style({
                image: new Icon({
                    anchor: [0.5, 1],
                    src: mapHolder.dataset.pinurl
                })
            })
        });
        map.addLayer(markers);

        let marker = new Feature(new Point(mercatorPos));
        markers.getSource().addFeature(marker);


    });

});

