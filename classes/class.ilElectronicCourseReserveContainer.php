<?php

class ilElectronicCourseReserveContainer
{
	/**
	 * @var string 
	 */
	protected $label = '';

	/**
	 * @var string 
	 */
	protected $timestamp = '';

	/**
	 * @var string 
	 */
	protected $timestamp_format = '';

	/**
	 * @var ilElectronicCourseReserveFile | ilElectronicCourseReserveUrl
	 */
	protected $item = null;

	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}

	/**
	 * @return string
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * @param string $timestamp
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	/**
	 * @return string
	 */
	public function getTimestampFormat()
	{
		return $this->timestamp_format;
	}

	/**
	 * @param string $timestamp_format
	 */
	public function setTimestampFormat($timestamp_format)
	{
		$this->timestamp_format = $timestamp_format;
	}

	/**
	 * @return ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl
	 */
	public function getItem()
	{
		return $this->item;
	}

	/**
	 * @param ilElectronicCourseReserveFile|ilElectronicCourseReserveUrl $item
	 */
	public function setItem($item)
	{
		$this->item = $item;
	}
}