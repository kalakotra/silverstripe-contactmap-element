<?php

namespace BiffBangPow\Element\Model;

use BiffBangPow\Element\ContactMapElement;
use BiffBangPow\Extension\SortableExtension;
use SilverStripe\Forms\CheckboxField;
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
        'MapZoom' => 'Int',
        'ShowDirections' => 'Boolean'
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
            DropdownField::create('MapZoom',
                _t(__CLASS__ . '.mapzoom', 'Map Zoom Level'),
                $this->getMapZooms())
                ->setDescription(
                    _t(__CLASS__ . '.mapzoomdescription', 'The higher the number, the more zoomed-in the map is shown')
                ),
            CheckboxField::create(
                'ShowDirections',
                _t(__CLASS__ . '.showdirections', 'Show a link to get directions on Google maps')
            )
        ]);
        return $fields;
    }

    private function getMapZooms()
    {
        $zooms = range(0, 20);
        return array_slice($zooms, 8, 30, true);
    }

    public function getDirectionsLink()
    {
        $base = 'https://www.google.com/maps/dir/';

        $params = [
            'api' => 1,
            'destination' => $this->getAddressString()
        ];

        return $base . '?' . http_build_query($params);
    }

    public function getAddressString()
    {
        $addressParts = explode("\n", $this->Address);
        $addressParts = array_filter($addressParts);

        foreach ($addressParts as &$addressPart) {
            $addressPart = trim($addressPart, " ,");
        }

        return implode(",", $addressParts);
    }
}
