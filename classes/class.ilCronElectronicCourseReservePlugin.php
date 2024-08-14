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
    public const CTYPE = 'Services';

    /**
     * @var string
     */
    public const CNAME = 'Cron';

    /**
     * @var string
     */
    public const SLOT_ID = 'crnhk';
    /**
     * @var string
     */
    public const PLUGIN_ID = 'cronecr';

    /**
     * @var string
     */
    private const PNAME = 'CronElectronicCourseReserve';

    private static ?self $instance = null;

    /** @var array */
    protected static array $active_plugins_check_cache = array();

    /** @var array */
    protected static array $active_plugins_cache = array();
    private ilComponentFactory $componentFactory;

    public function __construct(ilDBInterface $db, ilComponentRepositoryWrite $component_repository, string $id)
    {
        parent::__construct($db, $component_repository, $id);

        global $DIC;
        /**
         * @var ilComponentFactory $componentFactory
         */
        $this->componentFactory = $DIC["component.factory"];
    }

    /**
     * @return ilElectronicCourseReserveMediaImportJob[]
     */
    public function getCronJobInstances(): array
    {
        require_once 'class.ilElectronicCourseReserveMediaImportJob.php';
        return array(new ilElectronicCourseReserveMediaImportJob());
    }

    /**
     * @param int $jobId
     * @return ilElectronicCourseReserveMediaImportJob
     */
    public function getCronJobInstance($jobId): ilCronJob
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
    public function getPluginName(): string
    {
        return self::PNAME;
    }

    public static function getInstance(): self
    {
        global $DIC;

        if (self::$instance instanceof self) {
            return self::$instance;
        }

        /** @var ilComponentRepository $component_repository */
        $component_repository = $DIC['component.repository'];
        /** @var ilComponentFactory $component_factory */
        $component_factory = $DIC['component.factory'];

        $plugin_info = $component_repository->getComponentByTypeAndName(
            self::CTYPE,
            self::CNAME
        )->getPluginSlotById(self::SLOT_ID)->getPluginByName(self::PNAME);

        self::$instance = $component_factory->getPlugin($plugin_info->getId());

        return self::$instance;
    }

    public function isPluginInstalled(string $component, string $slot, string $plugin_class): bool
    {
        if (isset(self::$active_plugins_check_cache[$component][$slot][$plugin_class])) {
            return self::$active_plugins_check_cache[$component][$slot][$plugin_class];
        }

        foreach (
            $this->componentFactory->getActivePluginsInSlot($slot) as $plugin
        ) {
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
    public function getPlugin(string $component, string $slot, string $plugin_class): ilPlugin
    {
        if (isset(self::$active_plugins_cache[$component][$slot][$plugin_class])) {
            return self::$active_plugins_cache[$component][$slot][$plugin_class];
        }

        foreach (
            $this->componentFactory->getActivePluginsInSlot($slot) as $plugin
        ) {
            if (class_exists($plugin_class) && $plugin instanceof $plugin_class) {
                return (self::$active_plugins_cache[$component][$slot][$plugin_class] = $plugin);
            }
        }

        throw new ilException($plugin_class . ' plugin not installed!');
    }
}
