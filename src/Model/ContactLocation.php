<?php

namespace BiffBangPow\Element\Model;

use BiffBangPow\Element\ContactMapElement;
use BiffBangPow\Extension\SortableExtension;
use SilverStripe\ORM\DataObject;

class ContactLocation extends DataObject
{
    private static $table_name = 'BBP_ContactLocation';
    private static $db = [
        'Title' => 'Varchar',
        'Address' => 'Text',
        'Telephone' => 'Varchar',
        'Email' => 'Varchar',
        'Lat' => 'Varchar',
        'Lng' => 'Varchar'
    ];
    private static $belongs_many_many = [
        'Element' => ContactMapElement::class
    ];
    private static $extensions = [
        SortableExtension::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }
}
