<?php
/*
 * This file is part of MODX Revolution.
 *
 * Copyright (c) MODX, LLC. All Rights Reserved.
 *
 * For complete copyright and license information, see the COPYRIGHT and LICENSE
 * files found in the top-level directory of this distribution.
 */

use xPDO\Om\xPDOObject;

/**
 * Represents a modPropertySet relation to a specific modElement.
 *
 * @property int $element The ID of the Element referenced
 * @property string $element_class The class key of the Element referenced
 * @property int $property_set The ID of the property set being used
 *
 * @package modx
 * @extends xPDOObject
 */
class modElementPropertySet extends xPDOObject {
    /**
     * Returns related modElement instances based on the element_class column.
     *
     * {@inheritdoc}
     */
    public function & getOne($alias, $criteria= null, $cacheFlag= true) {
        if ($alias == 'Element') {
            $criteria = $this->xpdo->newQuery($this->get('element_class'), $criteria);
        }
        $object = parent :: getOne($alias, $criteria, $cacheFlag);
        return $object;
    }
}
