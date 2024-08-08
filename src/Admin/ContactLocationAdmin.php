<?php

namespace BiffBangPow\Admin;

use SilverStripe\Admin\ModelAdmin;
use BiffBangPow\Element\Model\ContactLocation;

class ContactLocationAdmin extends ModelAdmin {

    private static $menu_icon_class = 'font-icon-address-card';
    
    private static $managed_models = [
        ContactLocation::class
    ]; 
    
    private static $url_segment = 'contact-location'; 
    private static $menu_title = "Map Standorte";

    private static $menu_priority = -220;
}