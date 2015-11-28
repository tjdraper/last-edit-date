<?php

namespace BuzzingPixel\LastEditDate\Helper;

/**
 * Get Param helper
 *
 * @author TJ Draper <tj@buzzingpixel.com>]
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

class GetParam
{
	protected $params = array();

	/**
	 * GetParam constructor.
	 *
	 * @param array $params
	 */
	public function __construct($params = array())
	{
		if ($params) {
			$this->params($params);
		}
	}

	/**
	 * Set parameters for instance
	 *
	 * @param array $params
	 * @return self This returns a reference to itself
	 */
	public function params($params)
	{
		$this->params = $params;
		return $this;
	}

	/**
	 * Get param
	 *
	 * @param string $param
	 * @param mixed $fallback optional
	 * @return string
	 */
	public function get($param, $fallback = null)
	{
		if (! isset($this->params[$param])) {
			return $fallback;
		}

		return $this->params[$param];
	}

	/**
	 * Get param as exploded array
	 *
	 * @param string $param
	 * @param array $fallback
	 * @return array
	 */
	public function getArray($param, $fallback = array())
	{
		$return = $this->get($param, $fallback);

		if ($return) {
			$return = explode('|', $return);
		}

		return $return;
	}

	public function truthy($param)
	{
		$param = $this->get($param, false);

		if (gettype($param) === 'boolean') {
			return $param;
		}

		$truth = array(
			'y',
			'yes',
			'true'
		);

		return in_array($param, $truth);
	}

	public function falsy($param)
	{
		$param = $this->get($param, false);

		if (gettype($param) === 'boolean') {
			return ! $param;
		}

		$false = array(
			'n',
			'no',
			'false'
		);

		return ! in_array($param, $false);
	}
}