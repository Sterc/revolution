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
 * Renders a grid of recently edited resources by the active user
 *
 * @package modx
 * @subpackage dashboard
 */
class modDashboardWidgetRecentlyEditedResources extends modDashboardWidgetInterface
{
    /**
     * @return string
     * @throws Exception
     */
    public function render()
    {
        /** @var modProcessorResponse $res */
        $res = $this->modx->runProcessor('security/user/getrecentlyeditedresources', [
            'limit' => 10,
            'user' => $this->modx->user->get('id'),
        ]);
        $data = [];
        if (!$res->isError()) {
            $data = $res->getResponse();
            if (is_string($data)) {
                $data = json_decode($data, true);
            }
        }
        $this->modx->getService('smarty', 'smarty.modSmarty');
        $this->modx->smarty->assign('data', $data);

        return $this->modx->smarty->fetch('dashboard/recentlyeditedresources.tpl');
    }
}

return 'modDashboardWidgetRecentlyEditedResources';
