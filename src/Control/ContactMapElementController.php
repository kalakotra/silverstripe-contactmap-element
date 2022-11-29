<?php

namespace BiffBangPow\Element\Control;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\View\Requirements;

class ContactMapElementController extends ElementController
{
    protected function init()
    {
        parent::init();
        Requirements::javascript('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/osm.js', ['type' => false]);
        Requirements::css('biffbangpow/silverstripe-contactmap-element:client/dist/css/osm.js');
    }
}