<?php

namespace BiffBangPow\Element\Model;

use SilverStripe\ORM\DataObject;
//use BiffBangPow\Extension\SortableExtension;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use BiffBangPow\Element\ContactMapElement;

/**
 *
 */
class ContactLocation extends DataObject
{
    private static $table_name = 'BBP_ContactLocation';

    private static $default_sort = 'Title';
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

    private static $field_labels = [
        'Title' => 'Titel',
        'Address' => 'Adresse',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');
        $fields->removeByName('Element');
        $fields->removeByName('MapZoom');
        /*$fields->addFieldsToTab('Root.Main', [
            DropdownField::create('MapZoom',
                _t(__CLASS__ . '.mapzoom', 'Map Zoom Level'),
                $this->getMapZooms())
                ->setDescription(
                    _t(__CLASS__ . '.mapzoomdescription', 'The higher the number, the more zoomed-in the map is shown')
                )
        ]);*/
        $fields->renameField('Title', $this->fieldLabel('Title'));
        $fields->renameField('Address', $this->fieldLabel('Address'));

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Lat', 'Latitude')->setReadonly(true),
            TextField::create('Lng', 'Longitude')->setReadonly(true),
        ]);
        return $fields;
    }

    public function onBeforeWrite() {
        parent::onBeforeWrite();
        if ($this->Address) {
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
