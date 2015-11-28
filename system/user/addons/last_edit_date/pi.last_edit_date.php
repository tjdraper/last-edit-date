<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Last Edit Date plugin
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2015, Buzzing Pixel
 */

use \BuzzingPixel\LastEditDate\Helper;
use \BuzzingPixel\LastEditDate\Service;

class Last_edit_date
{
	public function __construct()
	{
		// Get Params
		$getParam = new Helper\GetParam(ee()->TMPL->tagparams);

		$entryId = $getParam->getArray('entry_id');
		$urlTitle = $getParam->getArray('url_title');
		$channelId = $getParam->getArray('channel_id');
		$channel = $getParam->getArray('channel');
		$categoryId = $getParam->getArray('category_id');
		$categoryUrlTitle = $getParam->getArray('category_url_title');
		$categoryGroupId = $getParam->getArray('category_group_id');
		$notStatus = $getParam->getArray('not_status');
		$status = $getParam->getArray('status', $notStatus ? array() : 'open');
		$format = $getParam->get('format');
		$showFutureEntries = $getParam->truthy('show_future_entries');
		$showExpiredEntries = $getParam->truthy('show_expired_entries');

		// Get entry
		$getEntry = new Service\GetEntry(compact(
			'entryId',
			'urlTitle',
			'channelId',
			'channel',
			'categoryId',
			'categoryUrlTitle',
			'categoryGroupId',
			'notStatus',
			'status',
			'showFutureEntries',
			'showExpiredEntries'
		));

		$timestamp = $getEntry->get();

		if (! $timestamp) {
			return false;
		}

		// Format the formatted date
		$this->return_data = ee()->localize->format_date($format, $timestamp);
	}
}
