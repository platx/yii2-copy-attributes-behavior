<?php

namespace platx\copyattributes;

use yii\base\Behavior;
use yii\base\Exception;
use yii\db\ActiveRecord;


/**
 * Copies data to different attributes
 * @package common\behaviors
 */
class CopyAttributesBehavior extends Behavior
{
    /**
     * Attributes list
     * Format:
     *  [
     *      'destinationAttribute' => 'sourceAttribute'
     *          or
     *      'destinationAttribute' => [
     *          'attribute' => 'sourceAttribute', -- required
     *          'clearTags' => true \ false,      -- NOT required
     *          'maxLength' => integer            -- NOT required
     *      ]
     *  ]
     * @var
     */
    public $attributes;

    /**
     * Clear from html tags?
     * @var bool
     */
    public $clearTags = false;

    /**
     * Cut to a specified number of characters?
     * @var bool|integer
     */
    public $maxLength = false;

    /**
     * Events
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'copyAttributes',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'copyAttributes',
        ];
    }

    /**
     * Processing
     * @throws Exception
     */
    function copyAttributes()
    {
        $owner = $this->owner;

        foreach ($this->attributes as $destination => $source) {
            if (is_array($source)) {

                if (empty($source['attribute'])) {
                    throw new Exception('Where to get the data? Set key "attribute"!');
                }

                $sourceAttribute = $source['attribute'];
                $clearTags = (bool)isset($source['clearTags']) ? $source['clearTags'] : $this->clearTags;
                $maxLength = isset($source['maxLength']) ? $source['maxLength'] : $this->maxLength;

                if (empty($owner->{$destination}) && !empty($owner->{$sourceAttribute})) {
                    $value = $owner->{$sourceAttribute};

                    $value = $clearTags ? strip_tags($value) : $value;
                    $value = is_integer($maxLength) ? mb_substr($value, 0, $maxLength,'UTF-8') : $value;

                    $owner->{$destination} = $value;
                }
            } else {
                if (empty($owner->{$destination}) && !empty($owner->{$source})) {

                    $value = $owner->{$source};

                    $value = $this->clearTags ? strip_tags($value) : $value;
                    $value = is_integer($this->maxLength) ? mb_substr($value, 0, $this->maxLength,'UTF-8') : $value;

                    $owner->{$destination} = $value;
                }
            }
        }
    }
}
