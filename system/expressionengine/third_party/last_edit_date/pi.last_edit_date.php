<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Last Edit Date Plugin
 *
 * @package JSON EEncoder
 * @author  TJ Draper
 * @link    https://buzzingpixel.com
 */

$plugin_info = array (
	'pi_name' => 'Last Edit Date',
	'pi_version' => '1.0.0',
	'pi_author' => 'TJ Draper',
	'pi_author_url' => 'https://buzzingpixel.com',
	'pi_description' => 'Get the last edit date of an entry or channel'
);

class Last_edit_date {

	public function __construct()
	{
		// Get Params
		$entryId = ee()->TMPL->fetch_param('entry_id');
		$channelId = ee()->TMPL->fetch_param('channel_id');
		$status = explode('|', ee()->TMPL->fetch_param('status', 'open'));
		$format = ee()->TMPL->fetch_param('format');

		// Start the query
		ee()->db
			->select('UNIX_TIMESTAMP(edit_date) AS edit_date')
			->from('channel_titles')
			->where_in('status', $status)
			->order_by('edit_date DESC')
			->limit(1);

		// If there’s an entry id, specify that
		if ($entryId) {
			$entryId = explode('|', $entryId);

			ee()->db
				->where_in('entry_id', $entryId);
		}

		// If there's a channel id, specify that
		if ($channelId) {
			$channelId = explode('|', $channelId);

			ee()->db
				->where_in('channel_id', $channelId);
		}

		// Get the query
		$query = ee()->db->get();
		$queryResult = $query->row();

		// Format that date
		$date = ee()->localize->format_date($format, $queryResult->edit_date);

		// Return the date
		$this->return_data = $date;
	}
}