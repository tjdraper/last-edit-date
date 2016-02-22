<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Last Edit Date plugin
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

use BuzzingPixel\LastEditDate\Controller\SingleTag;

class Last_edit_date
{
	public function __construct()
	{
		// Get the single tag controller
		$singleTag = new SingleTag();

		// Set the return data
		$this->return_data = $singleTag->parse(ee()->TMPL->tagparams);
	}
}
