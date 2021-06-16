<?php
/* Copyright (c) 1998-2013 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/Cron/classes/class.ilCronHookPlugin.php';

/**
 * Class ilCronElectronicCourseReservePlugin
 */
class ilCronElectronicCourseReservePlugin extends ilCronHookPlugin
{
    /**
     * @var string
     */
    const CTYPE = 'Services';

    /**
     * @var string
     */
    const CNAME = 'Cron';

    /**
     * @var string
     */
    const SLOT_ID = 'crnhk';

    /**
     * @var string
     */
    const PNAME = 'CronElectronicCourseReserve';

    /**
     * @var ilElectronicCourseReservePlugin
     */
    private static $instance = null;

    /** @var array */
    protected static $active_plugins_check_cache = array();

    /** @var array */
    protected static $active_plugins_cache = array();

    /**
     * @return ilElectronicCourseReserveMediaImportJob[]
     */
    public function getCronJobInstances() : array
    {
        require_once 'class.ilElectronicCourseReserveMediaImportJob.php';
        return array(new ilElectronicCourseReserveMediaImportJob());
    }

    /**
     * @param int $a_job_id
     * @return ilElectronicCourseReserveMediaImportJob
     */
    public function getCronJobInstance(string $a_job_id) : ilCronJob
    {
        require_once 'class.ilElectronicCourseReserveMediaImportJob.php';
        return new ilElectronicCourseReserveMediaImportJob();
    }

    /**
     * Get Plugin Name. Must be same as in class name il<Name>Plugin
     * and must correspond to plugins subdirectory name.
     * Must be overwritten in plugin class of plugin
     * (and should be made final)
     * @return    string    Plugin Name
     */
    public function getPluginName()
    {
        return self::PNAME;
    }

    /**
     * @return self|ilPlugin
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            require_once 'Services/Component/classes/class.ilPluginAdmin.php';
            return self::$instance = ilPluginAdmin::getPluginObject(
                self::CTYPE,
                self::CNAME,
                self::SLOT_ID,
                self::PNAME
            );
        }

        return self::$instance;
    }

    /**
     * @param string $component
     * @param string $slot
     * @param string $plugin_class
     *
     * @return bool
     */
    public function isPluginInstalled($component, $slot, $plugin_class)
    {
        if (isset(self::$active_plugins_check_cache[$component][$slot][$plugin_class])) {
            return self::$active_plugins_check_cache[$component][$slot][$plugin_class];
        }

        foreach (
            $GLOBALS['ilPluginAdmin']->getActivePluginsForSlot(
                IL_COMP_SERVICE,
                $component,
                $slot
            ) as $plugin_name
        ) {
            $plugin = ilPluginAdmin::getPluginObject(IL_COMP_SERVICE, $component, $slot, $plugin_name);
            if (class_exists($plugin_class) && $plugin instanceof $plugin_class) {
                return (self::$active_plugins_check_cache[$component][$slot][$plugin_class] = true);
            }
        }

        return (self::$active_plugins_check_cache[$component][$slot][$plugin_class] = false);
    }

    /**
     * @param string $component
     * @param string $slot
     * @param string $plugin_class
     *
     * @return ilPlugin
     * @throws ilException
     */
    public function getPlugin($component, $slot, $plugin_class)
    {
        if (isset(self::$active_plugins_cache[$component][$slot][$plugin_class])) {
            return self::$active_plugins_cache[$component][$slot][$plugin_class];
        }

        foreach (
            $GLOBALS['ilPluginAdmin']->getActivePluginsForSlot(
                IL_COMP_SERVICE,
                $component,
                $slot
            ) as $plugin_name
        ) {
            $plugin = ilPluginAdmin::getPluginObject(IL_COMP_SERVICE, $component, $slot, $plugin_name);
            if (class_exists($plugin_class) && $plugin instanceof $plugin_class) {
                return (self::$active_plugins_cache[$component][$slot][$plugin_class] = $plugin);
            }
        }

        throw new ilException($plugin_class . ' plugin not installed!');
    }
}
