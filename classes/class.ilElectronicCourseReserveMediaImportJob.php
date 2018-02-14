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
	 * Get id
	 * @return string
	 */
	public function getId()
	{
		return 'electronic_crs_reserve_media_imp';
	}

	/**
	 * Is to be activated on "installation"
	 * @return boolean
	 */
	public function hasAutoActivation()
	{
		return false;
	}

	/**
	 * Can the schedule be configured?
	 * @return boolean
	 */
	public function hasFlexibleSchedule()
	{
		return true;
	}

	/**
	 * Get schedule type
	 * @return int
	 */
	public function getDefaultScheduleType()
	{
		return self::SCHEDULE_TYPE_DAILY;
	}

	/**
	 * Get schedule value
	 * @return int|array
	 */
	function getDefaultScheduleValue()
	{
		return 1;
	}

	/**
	 * Run job
	 * @return ilCronJobResult
	 */
	public function run()
	{
		require_once 'Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/ElectronicCourseReserve/classes/class.ilElectronicCourseReserveDigitizedMediaImporter.php';
		$job = new ilElectronicCourseReserveDigitizedMediaImporter();
		$job->run();

		$result = new ilCronJobResult();
		$result->setMessage('Finished cron job task.');
		$result->setStatus(ilCronJobResult::STATUS_OK);
		return $result;
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
} 