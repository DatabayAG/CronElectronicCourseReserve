<?php
/* Copyright (c) 1998-2013 ILIAS open source, Extended GPL, see docs/LICENSE */

use ILIAS\Cron\Schedule\CronJobScheduleType;

require_once 'Services/Cron/classes/class.ilCronJob.php';
require_once 'class.ilCronElectronicCourseReservePlugin.php';

/**
 * Class ilElectronicCourseReserveImportJob
 */
class ilElectronicCourseReserveMediaImportJob extends ilCronJob
{
    public function getId(): string
    {
        return 'electronic_crs_reserve_media_imp';
    }

    /**
     * @inheritdoc
     */
    public function hasAutoActivation(): bool
    {
        return false;
    }

    public function hasFlexibleSchedule(): bool
    {
        return true;
    }

    public function getDefaultScheduleType(): CronJobScheduleType
    {
        return CronJobScheduleType::SCHEDULE_TYPE_DAILY;
    }

    public function getDefaultScheduleValue(): ?int
    {
        return 1;
    }

    public function hasCustomSettings(): bool
    {
        return true;
    }

    /**
     *
     * @throws ilException
     * @throws Exception
     */
    public function run(): ilCronJobResult
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
     * @param ilDBInterface $db
     * @param ilSetting $setting
     * @param bool $a_currently_active
     * @inheritDoc
     */
    public function activationWasToggled(ilDBInterface $db, ilSetting $setting, bool $a_currently_active): void //@todo Parameter wurden geändert, was jetzt
    {
        if ($a_currently_active) {
            $settings = new ilSetting();
            $settings->set('esa_cron_lock_status', 0);
        }
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_title');
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_title');
    }

    /**
     *
     * @throws ilException | ilCtrlException
     */
    public function addCustomSettingsToForm(ilPropertyFormGUI $a_form): void
    {
        global $DIC;

        parent::addCustomSettingsToForm($a_form);

        if (ilCronElectronicCourseReservePlugin::getInstance()->isPluginInstalled(
            'UIComponent', 'uihk', 'ilElectronicCourseReservePlugin'
        )) {
            $configUrl = new ilNonEditableValueGUI(
                ilCronElectronicCourseReservePlugin::getInstance()->txt('ecr_configuration_page'), '', true
            );

            /**
             * @var $pl ilElectronicCourseReservePlugin
             */
            $pl = ilCronElectronicCourseReservePlugin::getInstance()->getPlugin(
                'UIComponent', 'uihk', 'ilElectronicCourseReservePlugin'
            );

            $objIds = array_keys(ilObject::_getObjectsByType('cmps'));
            $objId = current($objIds);

            $refIds = ilObject::_getAllReferences($objId);
            $refId = current($refIds);

            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'ref_id', $refId);
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'ctype', $pl::CTYPE);
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'cname', $pl::CNAME);
            $DIC->ctrl()->setParameterByClass('ilElectronicCourseReserveConfigGUI', 'slot_id', $pl::SLOT_ID);
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