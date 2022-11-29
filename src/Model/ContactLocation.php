<?php

namespace BiffBangPow\Element\Model;

use BiffBangPow\Element\ContactMapElement;
use BiffBangPow\Extension\SortableExtension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;

/**
 *
 */
class ContactLocation extends DataObject
{
    private static $table_name = 'BBP_ContactLocation';
    private static $db = [
        'Title' => 'Varchar',
        'Address' => 'Text',
        'Telephone' => 'Varchar',
        'Email' => 'Varchar',
        'Lat' => 'Varchar',
        'Lng' => 'Varchar',
        'MapZoom' => 'Int'
    ];
    private static $belongs_many_many = [
        'Element' => ContactMapElement::class
    ];
    private static $extensions = [
        SortableExtension::class
    ];
    private static $defaults = [
        'MapZoom' => 14
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Main', [
           DropdownField::create('MapZoom', 'Map Zoom Level', $this->getMapZooms())
            ->setDescription('The higher the number, the more zoomed-in the map is shown')
        ]);
        return $fields;
    }

    private function getMapZooms() {
        $zooms = range(0, 20);
        return array_slice($zooms, 8, 30,true);
    }
}
