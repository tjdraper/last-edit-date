<?php

/**
 * Last Edit Date Params service
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\LastEditDate\Service;

class Params extends BaseParams
{
	// Params
	protected $entry_id = 'intArray';
	protected $not_entry_id = 'intArray';
	protected $url_title = 'array';
	protected $not_url_title = 'array';
	protected $channel_id = 'intArray';
	protected $not_channel_id = 'intArray';
	protected $channel = 'array';
	protected $not_channel = 'array';
	protected $category_id = 'intArray';
	protected $not_category_id = 'intArray';
	protected $category_url_title = 'array';
	protected $not_category_url_title = 'array';
	protected $category_group_id = 'intArray';
	protected $not_category_group_id = 'intArray';
	protected $status = 'array';
	protected $not_status = 'array';
	protected $format = 'string';
	protected $show_future_entries = 'truthy';
	protected $show_expired_entries = 'truthy';

	// Set defaults
	protected $_status_default = 'open';
	protected $_status_default_when_not = 'not_status';
}
