<?php

/**
 * Last Edit Date SingleTag controller
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\LastEditDate\Controller;

use BuzzingPixel\LastEditDate\Service\Params;
use BuzzingPixel\LastEditDate\Service\EntryDate;

class SingleTag
{
	/**
	 * Parse single tag
	 *
	 * @param array $tagParams
	 */
	public function parse($tagParams = array())
	{
		// Get params object
		$params = new Params($tagParams);

		// Get the EntryData class
		$entryDate = new EntryDate($params);

		// Get the timestamp
		$timeStamp = $entryDate->getTimestamp();

		// Return the formatted date
		return ee()->localize->format_date($params->format, $timeStamp);
	}
}
