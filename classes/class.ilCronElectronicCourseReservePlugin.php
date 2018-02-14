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

	/**
	 * @return ilElectronicCourseReserveMediaImportJob[]
	 */
	public function getCronJobInstances()
	{
		require_once 'class.ilElectronicCourseReserveMediaImportJob.php';
		return array(new ilElectronicCourseReserveMediaImportJob());
	}

	/**
	 * @param int $a_job_id
	 * @return ilElectronicCourseReserveMediaImportJob
	 */
	public function getCronJobInstance($a_job_id)
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
	 * @return self
	 */
	public static function getInstance()
	{
		if(null === self::$instance)
		{
			require_once 'Services/Component/classes/class.ilPluginAdmin.php';
			return self::$instance = ilPluginAdmin::getPluginObject(self::CTYPE, self::CNAME, self::SLOT_ID, self::PNAME);
		}

		return self::$instance;
	}
} 