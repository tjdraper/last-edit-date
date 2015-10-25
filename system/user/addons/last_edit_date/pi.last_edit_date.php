<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Last Edit Date plugin
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2015, Buzzing Pixel
 */

class Last_edit_date
{
	public function __construct()
	{
		// Get Params
		$entryId = ee()->TMPL->fetch_param('entry_id');
		$channelId = ee()->TMPL->fetch_param('channel_id');
		$categoryId = ee()->TMPL->fetch_param('category_id');
		$status = explode('|', ee()->TMPL->fetch_param('status', 'open'));
		$format = ee()->TMPL->fetch_param('format');

		// Start the query
		ee()->db->select('CT.edit_date, CT.title')
			->from('channel_titles AS CT')
			->where_in('CT.status', $status)
			->order_by('CT.edit_date DESC')
			->limit(1);

		// If there’s an entry id, specify that
		if ($entryId) {
			$entryId = explode('|', $entryId);

			ee()->db->where_in('CT.entry_id', $entryId);
		}

		// If there's a channel id, specify that
		if ($channelId) {
			$channelId = explode('|', $channelId);

			ee()->db->where_in('CT.channel_id', $channelId);
		}

		if ($categoryId) {
			$categoryId = explode('|', $categoryId);

			ee()->db->join('category_posts CP', 'CT.entry_id = CP.entry_id')
				->where_in('CP.cat_id', $categoryId);
		}

		// Get the query
		$query = ee()->db->get()->row();

		if (! $query) {
			return false;
		}

		// Format the formatted date
		$this->return_data = ee()->localize->format_date(
			$format,
			$query->edit_date
		);
	}
}