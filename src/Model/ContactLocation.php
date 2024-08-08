<?php

namespace BiffBangPow\Element\Model;

use BiffBangPow\Element\ContactMapElement;
//use BiffBangPow\Extension\SortableExtension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;

/**
 *
 */
class ContactLocation extends DataObject
{
    private static $table_name = 'BBP_ContactLocation';

    private static $default_sort = 'Sort';
    private static $db = [
        'Title' => 'Varchar',
        'Address' => 'Text',
        'Lat' => 'Varchar',
        'Lng' => 'Varchar',
        'MapZoom' => 'Int',
        'Sort' => 'Int'
    ];
    private static $belongs_many_many = [
        'Element' => ContactMapElement::class
    ];
    private static $extensions = [
        //SortableExtension::class
    ];
    private static $defaults = [
        'MapZoom' => 14
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');
        $fields->removeByName('Element');
        $fields->addFieldsToTab('Root.Main', [
            DropdownField::create('MapZoom',
                _t(__CLASS__ . '.mapzoom', 'Map Zoom Level'),
                $this->getMapZooms())
                ->setDescription(
                    _t(__CLASS__ . '.mapzoomdescription', 'The higher the number, the more zoomed-in the map is shown')
                )
        ]);
        return $fields;
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        if ($this->Address && !$this->Lat && !$this->Lng) {
            $search_url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($this->getAddressString());

            $httpOptions = [
                "http" => [
                    "method" => "GET",
                    "header" => "User-Agent: Nominatim-Test"
                ]
            ];

            $context = stream_context_create($httpOptions);
            $response = file_get_contents($search_url, false, $context);

            $data = json_decode($response, true);
            if (isset($data[0])) {
                $this->Lat = $data[0]['lat'];
                $this->Lng = $data[0]['lon'];
            }
        }
    }

    private function getMapZooms()
    {
        $zooms = range(0, 20);
        return array_slice($zooms, 8, 30, true);
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
