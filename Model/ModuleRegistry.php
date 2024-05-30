<?php
/**
 * Copyright © element119. All rights reserved.
 * See LICENCE.txt for licence details.
 */
declare(strict_types=1);

namespace Element119\AdminModuleList\Model;

use Exception;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Composer\MagentoComposerApplicationFactory;
use Magento\Framework\Module\FullModuleList;
use Magento\Framework\Module\Manager;
use Psr\Log\LoggerInterface;

class ModuleRegistry
{
    public function __construct(
        private readonly FullModuleList $moduleList,
        private readonly Manager $moduleManager,
        private readonly MagentoComposerApplicationFactory $composerApplicationFactory,
        private readonly ComponentRegistrarInterface $componentRegistrar,
        private readonly LoggerInterface $logger,
    ) { }

    public function getComposerModuleList(): array
    {
        $moduleList = [];
        $modulePaths = $this->componentRegistrar->getPaths(ComponentRegistrar::MODULE);
        $composerPackageData = $this->getComposerPackageData();

        foreach ($composerPackageData as $info) {
            $potentialModuleNames = array_filter(
                $modulePaths,
                fn($installPath) => str_contains($installPath, $info['name'])
            );

            if (count($potentialModuleNames) > 1) {
                foreach ($potentialModuleNames as $potentialModuleName => $installPath) {
                    $moduleList[$potentialModuleName] = $this->getComposerModuleData($potentialModuleName, $info);
                }
            } elseif ($moduleName = array_key_first($potentialModuleNames)) {
                $moduleList[$moduleName] = $this->getComposerModuleData($moduleName, $info);
            }
        }

        return $moduleList;
    }

    public function getComposerPackageData(): array
    {
        $packageData = [];
        $composerApplication = $this->composerApplicationFactory->create();

        try {
            $composer = $composerApplication->createComposer();
        } catch (Exception $e) {
            $this->logger->error(sprintf(
                'Could not create Composer application instance when attempting to read package information: %s',
                $e->getMessage()
            ));

            return $packageData;
        }

        $composerLocker = $composer->getLocker();

        if ($composerLocker->isLocked()) {
            $lockData = $composerLocker->getLockData();

            if (array_key_exists('packages', $lockData)) {
                $packageData = $lockData['packages'];
            }

            if (array_key_exists('packages-dev', $lockData)) {
                $packageData = array_merge($packageData, $lockData['packages-dev']);
            }
        }

        return $packageData;
    }

    public function getLocalModuleList(array $excludes = []): array
    {
        $moduleList = [];

        if ($localModules = array_diff(array_keys($this->getAllModules()), $excludes)) {
            foreach ($localModules as $moduleName) {
                $moduleList[$moduleName] = $this->getLocalModuleData($moduleName);
            }
        }

        return $moduleList;
    }

    public function getAllModules(): array
    {
        return $this->moduleList->getAll();
    }

    private function getComposerModuleData(string $moduleName, array $moduleInfo): array
    {
        return [
            'name' => $moduleName,
            'status' => $this->getModuleStatus($moduleName),
            'installation_method' => (string)__('Composer'),
            'version' => $moduleInfo['version'] ?? (string)__('Unknown'),
            'composer_package' => $moduleInfo['name'],
        ];
    }

    private function getLocalModuleData(string $moduleName): array
    {
        return [
            'name' => $moduleName,
            'status' => $this->getModuleStatus($moduleName),
            'installation_method' => (string)__('Local'),
        ];
    }

    private function getModuleStatus(string $moduleName): string
    {
        return (string)__($this->moduleManager->isEnabled($moduleName) ? 'Enabled' : 'Disabled');
    }
}
