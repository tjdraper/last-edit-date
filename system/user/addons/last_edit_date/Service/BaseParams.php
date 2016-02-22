<?php

/**
 * Last Edit Date BaseParams service
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\LastEditDate\Service;

class BaseParams
{
	/**
	 * Baseparams constructor
	 *
	 * @param array $params
	 */
	public function __construct($params = array())
	{
		// Loop through the params and set them
		foreach ($this as $key => $val) {
			$param = isset($params[$key]) ? $params[$key] : false;

			// If the param is not set, check if there is a fallback
			if (
				// Check if param is not set
				! $param &&
				// Check if there is a default value
				$this->{"_{$key}_default"} &&
				// Make sure an alternate is not set
				! isset($params[$this->{"_{$key}_default_when_not"}])
			) {
				// Set the default param
				$param = $this->{"_{$key}_default"};
			}

			// Set string value
			if ($val === 'string') {
				$this->{$key} = $param ?: '';

			// Set int value
			} elseif ($val === 'int') {
				$this->{$key} =  (int) $param ?: 0;

			// Set array value
			} elseif ($val === 'intArray' || $val === 'array') {
				$param = $param ? explode('|', $param) : array();

				if ($val === 'intArray') {
					foreach ($param as $pKey => $pVal) {
						$param[$pKey] = (int) $pVal;
					}
				}

				$this->{$key} = $param;

			// Set truthy value
			} elseif ($val === 'truthy') {
				$truth = array(
					'y',
					'yes',
					'true',
					true
				);

				$this->{$key} = in_array($param, $truth);

			// Set falsy value
			} elseif ($val === 'falsy') {
				$false = array(
					'n',
					'no',
					'false',
					false
				);

				$this->{$key} = ! in_array($param, $false);

			// Otherwise this type isn't account for and should be unset
			} else {
				unset($this->{$key});
			}
		}
	}

	/**
	 * Get param magic method
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (isset($this->{$name})) {
			return $this->{$name};
		}

		return null;
	}

	/**
	 * Set param magic method
	 *
	 * @param string $name
	 * @param mixed $val
	 * @return null
	 */
	public function __set($name, $val)
	{
		return null;
	}

	/**
	 * Get an md5 hash of all params
	 *
	 * @return string
	 */
	public function getHash()
	{
		return md5(serialize($this));
	}
}
