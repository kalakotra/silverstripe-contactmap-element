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
        Requirements::javascript('biffbangpow/silverstripe-contactmap-element:client/dist/javascript/osm.js', ['type' => false]);
        Requirements::css('biffbangpow/silverstripe-contactmap-element:client/dist/css/osm.css', '', ['defer' => true]);
        
        $themeCSS = ThemeResourceLoader::inst()->findThemedCSS('client/dist/css/elements/textandvideo');
        if ($themeCSS) {
            Requirements::css($themeCSS, '', ['defer' => true]);
        }
    }
}
