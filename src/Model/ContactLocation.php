<?php

namespace BiffBangPow\Element\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use BiffBangPow\Element\ContactMapElement;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

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
        'ShowPopup' => 'Boolean',
        'PopupContent' => 'HTMLText',
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
        'ShowPopup' => 'Popup anzeigen',
        'PopupContent' => 'Popup Inhalt',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Sort');
        $fields->removeByName('Element');
        $fields->removeByName('MapZoom');
        
        $fields->renameField('Title', $this->fieldLabel('Title'));
        $fields->renameField('Address', $this->fieldLabel('Address'));
        $fields->renameField('ShowPopup', $this->fieldLabel('ShowPopup'));

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Lat', 'Latitude')->setReadonly(true),
            TextField::create('Lng', 'Longitude')->setReadonly(true),
        ], 'ShowPopup');

        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('ShowPopup', $this->fieldLabel('ShowPopup')),
            $popupContent = HTMLEditorField::create('PopupContent', $this->fieldLabel('PopupContent'))
        ]);

        $popupContent->displayIf('ShowPopup')->isChecked();

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
