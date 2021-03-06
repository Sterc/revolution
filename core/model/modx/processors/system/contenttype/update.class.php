<?php
/*
 * This file is part of MODX Revolution.
 *
 * Copyright (c) MODX, LLC. All Rights Reserved.
 *
 * For complete copyright and license information, see the COPYRIGHT and LICENSE
 * files found in the top-level directory of this distribution.
 */

/**
 * Update a content type from the grid. Sent through JSON-encoded 'data'
 * parameter.
 *
 * @param integer $id The ID of the content type
 * @param string $name The new name
 * @param string $description (optional) A short description
 * @param string $mime_type The MIME type for the content type
 * @param string $file_extensions A list of file extensions associated with this
 * type
 * @param string $headers Any headers to be sent with resources with this type
 * @param boolean $binary If true, will be sent as binary data
 *
 * @package modx
 * @subpackage processors.system.contenttype
 */
class modContentTypeUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'modContentType';
    public $languageTopics = ['content_type'];
    public $permission = 'content_types';
    public $objectType = 'content_type';

    public $refreshURIs = false;

    public function beforeSave()
    {
        $this->setCheckbox('binary');

        $headers = $this->modx->fromJSON($this->getProperty('headers', '[]'));
        $this->object->set('headers', $headers);

        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('content_type_err_ns_name'));
        }

        $this->refreshURIs = $this->object->isDirty('file_extensions') && $this->modx->getCount('modResource', array('content_type' => $this->object->get('id')));

        return parent::beforeSave();
    }
    /**
     * {@inheritDoc}
     *
     * @return mixed
     */
    public function afterSave() {
        if ($this->refreshURIs) {
            $this->modx->call('modResource', 'refreshURIs', array(&$this->modx));
        }
        return parent::afterSave();
    }
}
return modContentTypeUpdateProcessor::class;
