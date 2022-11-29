<?php

namespace BiffBangPow\Element\Control;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

class ContactMapElementController extends ElementController
{
    protected function init()
    {
        parent::init();
        $provider = SiteConfig::current_site_config()->MapsProvider;
        if ($provider === 'osm') {
            Requirements::javascript('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/osm.js', ['type' => false]);
            Requirements::css('biffbangpow/silverstripe-contactmap-element:client/dist/css/osm.css');
        } else if ($provider === 'google') {
            //Add Google scripts
        }
    }
}
