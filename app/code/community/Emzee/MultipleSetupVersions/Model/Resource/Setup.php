<?php

class Emzee_MultipleSetupVersions_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{
    /**
     * Apply data updates to the system after upgrading.
     *
     * @param string $fromVersion
     * @return Mage_Core_Model_Resource_Setup
     */
    public function applyDataUpdates()
    {
        $dataVer= $this->_getResource()->getDataVersion($this->_resourceName);
        $configVer = (string)$this->_resourceConfig->setup->version;
        if ($dataVer !== false) {
             $status = version_compare($configVer, $dataVer);
             if ($status == self::VERSION_COMPARE_GREATER) {
                 $this->_upgradeData($dataVer, $configVer);
             }
        } elseif ($configVer) {
            $this->_installData($configVer);
        }
        return $this;
    }
    
    /**
     * Apply module resource install, upgrade and data scripts
     *
     * @return Mage_Core_Model_Resource_Setup
     */
    public function applyUpdates()
    {
        $dbVer = $this->_getResource()->getDbVersion($this->_resourceName);
        $configVer = (string)$this->_resourceConfig->setup->version;
        
        /**
         * Hook queries in adapter, so that in MySQL compatibility mode extensions and custom modules will avoid
         * errors due to changes in database structure
         */
        if (((string)$this->_moduleConfig->codePool != 'core') && Mage::helper('core')->useDbCompatibleMode()) {
            $this->_hookQueries();
        }

        // Module is installed
        if ($dbVer !== false) {
             $status = version_compare($configVer, $dbVer);
             switch ($status) {
                case self::VERSION_COMPARE_LOWER:
                    $this->_rollbackResourceDb($configVer, $dbVer);
                    break;
                case self::VERSION_COMPARE_GREATER:
                    $this->_upgradeResourceDb($dbVer, $configVer);
                    break;
                default:
                    return true;
                    break;
             }
        } elseif ($configVer) {
            $this->_installResourceDb($configVer);
        }

        $this->_unhookQueries();

        return $this;
    }
}
