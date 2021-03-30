<?php
/* Copyright (c) 1998-2013 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/Cron/classes/class.ilCronJob.php';
require_once 'class.ilCronElectronicCourseReservePlugin.php';

/**
 * Class ilElectronicCourseReserveImportJob
 */
class ilElectronicCourseReserveMediaImportJob extends ilCronJob
{
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 'electronic_crs_reserve_media_imp';
    }

    /**
     * @inheritdoc
     */
    public function hasAutoActivation()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function hasFlexibleSchedule()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultScheduleType()
    {
        return self::SCHEDULE_TYPE_DAILY;
    }

    /**
     * @inheritdoc
     */
    public function getDefaultScheduleValue()
    {
        return 1;
    }

    /**
     * @inheritdoc
     */
    public function hasCustomSettings()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $result = new ilCronJobResult();

        if (ilCronElectronicCourseReservePlugin::getInstance()->isPluginInstalled(
                'UIComponent', 'uihk', 'ilElectronicCourseReservePlugin'
            ) && ilCronElectronicCourseReservePlugin::getInstance()->getPlugin(
                'UIComponent', 'uihk', 'ilElectronicCourseReservePlugin'
            )->isActive()) {
            require_once 'Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ElectronicCourseReserve/classes/class.ilElectronicCourseReserveDigitizedMediaImporter.php';
            $job = new ilElectronicCourseReserveDigitizedMediaImporter();
            $job->run($this->getId());

            $result->setMessage('Finished cron job task.');
            $result->setStatus(ilCronJobResult::STATUS_OK);
        } else {
            $result->setMessage('Please install and activate the ILIAS plugin "ElectronicCourseReserve".');
            $result->setStatus(ilCronJobResult::STATUS_INVALID_CONFIGURATION);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function activationWasToggled($a_currently_active)
    {
        if ($a_currently_active) {
            $settings = new ilSetting();
            $settings->set('esa_cron_lock_status', 0);
        }
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_title');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_title');
    }

    /**
     * @inheritdoc
     */
    public function addCustomSettingsToForm(ilPropertyFormGUI $a_form)
    {
        global $DIC;

        parent::addCustomSettingsToForm($a_form);

        if (ilCronElectronicCourseReservePlugin::getInstance()->isPluginInstalled(
            'UIComponent', 'uihk', 'ilElectronicCourseReservePlugin'
        )) {
            $configUrl = new ilNonEditableValueGUI(
                ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_configuration_page'), '', true
            );

            $pl = ilCronElectronicCourseReservePlugin::getInstance()->getPlugin(
                'UIComponent', 'uihk', 'ilElectronicCourseReservePlugin'
            );

            $objIds = array_keys(ilObject::_getObjectsByType('cmps'));
            $objId = current($objIds);

            $refIds = ilObject::_getAllReferences($objId);
            $refId = current($refIds);

            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'ref_id', $refId);
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'ctype', $pl->getComponentType());
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'cname', $pl->getComponentName());
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'slot_id', $pl->getSlotId());
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'plugin_id', $pl->getId());
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'pname', $pl->getPluginName());
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'admin_mode', 'settings');

            $configUrl->setValue('<a target="_blank" href="' . $DIC->ctrl()->getLinkTargetByClass([
                    'ilAdministrationGUI',
                    'ilobjcomponentsettingsgui',
                    'ilElectronicCourseReserveConfigGUI'
                ]) . '">' . ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_configuration_page') . '</a>');
            $a_form->addItem($configUrl);
        }
    }
} 