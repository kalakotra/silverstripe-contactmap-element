<?php

namespace BiffBangPow\Element;

use BiffBangPow\Element\Control\ContactMapElementController;
use BiffBangPow\Element\Model\ContactLocation;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\HasManyList;
use UncleCheese\DisplayLogic\Forms\Wrapper;

/**
 * @property DBHTMLText Content
 * @property DBBoolean ShowAllLocations
 * @method HasManyList Locations()
 */
class ContactMapElement extends BaseElement
{
    private static $table_name = 'BBP_ContentMapElement';
    private static $inline_editable = false;
    private static $controller_class = ContactMapElementController::class;
    private static $db = [
        'FullWidth' => 'Boolean',
        'ShowAllLocations' => 'Boolean'
    ];
    private static $many_many = [
        'Locations' => ContactLocation::class
    ];
    private static $defaults = [
        'ShowAllLocations' => true
    ];

    private static $field_labels = [
        'FullWidth' => 'Volle Breite',
        'ShowAllLocations' => 'Alle Standorte anzeigen',
        'Locations' => 'Standorte'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName(['Locations']);
        $fields->addFieldsToTab('Root.Main', [
            CheckboxField::create('FullWidth', self::$field_labels['FullWidth']),
            CheckboxField::create('ShowAllLocations', self::$field_labels['ShowAllLocations']),
            Wrapper::create(
                CheckboxSetField::create('Locations', self::$field_labels['Locations'], ContactLocation::get()->map())
            )->displayIf('ShowAllLocations')->isNotChecked()->end()
        ]);
        return $fields;
    }


    
    public function getDisplayLocations()
    {
        if ($this->ShowAllLocations) {
            return ContactLocation::get();
        }
        else {
            return $this->Locations();
        }
    }
}
