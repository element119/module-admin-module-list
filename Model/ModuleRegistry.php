<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminModuleList\Model;

use Element119\AdminModuleList\Scope\ModuleConfig;
use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\FullModuleList;
use Magento\Framework\Module\Manager;

class ModuleRegistry implements HyvaGridArrayProviderInterface
{
    public function __construct(
        private readonly ModuleConfig $moduleConfig,
        private readonly Dir $moduleDirectory,
        private readonly FullModuleList $moduleList,
        private readonly Manager $moduleManager,
    ) { }

    public function getHyvaGridData(): array
    {
        $moduleList = [];
        $vendorDir = $this->moduleConfig->getVendorDirName();
        $localDir = $this->moduleConfig->getLocalModuleDirName();

        foreach ($this->getAllModules() as $module => $data) {
            $moduleDir = $this->moduleDirectory->getDir($module);
            $installMethod = 'Unknown';

            if (str_contains($moduleDir, $vendorDir)) {
                $installMethod = 'Composer';
            } elseif (str_contains($moduleDir, $localDir)) {
                $installMethod = 'Local';
            }

            $moduleList[$module] = [
                'name' => $module,
                'status' => __($this->moduleManager->isEnabled($module) ? 'Enabled' : 'Disabled'),
                'installation_method' => __($installMethod),
            ];
        }

        return $moduleList;
    }

    public function getAllModules(): array
    {
        return $this->moduleList->getAll();
    }
}
