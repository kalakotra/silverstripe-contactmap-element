<?php

namespace BiffBangPow\Element\Control;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\View\Requirements;
use SilverStripe\View\ThemeResourceLoader;

class ContactMapElementController extends ElementController
{
    protected function init()
    {
        parent::init();
        Requirements::javascript('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/leaflet.js', ['defer' => true]);
        Requirements::javascript('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/leaflet-starter.js', ['defer' => true]);
        Requirements::css('biffbangpow/silverstripe-contactmap-element:client/dist/css/leaflet.css', '');
        
    }
}
