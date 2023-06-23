<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminModuleList\Scope;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ModuleConfig
{
    private const XML_PATH_VENDOR_DIR_NAME = 'system/modules/vendor_dir_name';
    private const XML_PATH_LOCAL_MODULE_DIR_NAME = 'system/modules/local_dir_name';

    public function __construct(private readonly ScopeConfigInterface $scopeConfig) { }

    public function getVendorDirName(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_VENDOR_DIR_NAME);
    }

    public function getLocalModuleDirName(): string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_LOCAL_MODULE_DIR_NAME);
    }
}
