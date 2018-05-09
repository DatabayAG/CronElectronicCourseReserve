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
	 * @var string 
	 */
	protected $type = '';

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

	/**
	 * @return array
	 */
	public function getValidTypes(): array
	{
		return $this->valid_types;
	}

	/**
	 * @param array $valid_types
	 */
	public function setValidTypes(array $valid_types)
	{
		$this->valid_types = $valid_types;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}
}