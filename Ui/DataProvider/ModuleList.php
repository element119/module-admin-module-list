<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminModuleList\Ui\DataProvider;

use Element119\AdminModuleList\Model\ModuleRegistry;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;

class ModuleList implements HyvaGridArrayProviderInterface
{
    public function __construct(
        private readonly ModuleRegistry $moduleRegistry,
    ) { }

    public function getHyvaGridData(): array
    {
        $moduleList = $this->moduleRegistry->getComposerModuleList();

        return array_merge($moduleList, $this->moduleRegistry->getLocalModuleList(array_keys($moduleList)));
    }
}
