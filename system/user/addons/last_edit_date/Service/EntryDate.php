<?php

/**
 * Last Edit Date GetEntryDate service
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\LastEditDate\Service;

class EntryDate
{
	private $params;

	/**
	 * GetEntryDate constructor
	 *
	 * @param object $params
	 */
	public function __construct(
		\BuzzingPixel\LastEditDate\Service\Params $params
	)
	{
		$this->params = $params;
	}

	/**
	 * Get the timestamp
	 */
	public function getTimestamp()
	{
		// Set params object to local variable
		$params = $this->params;

		// Set array of items that should trigger including categories in model
		$categoryParams = array(
			'category_id',
			'not_category_id',
			'category_url_title',
			'not_category_url_title',
			'category_group_id',
			'not_category_group_id'
		);

		// Fetch the ChannelEntry model
		$model = ee('Model')->get('ChannelEntry')
			->order('edit_date', 'DESC');

		// Include Channel model if applicable
		if ($params->channel || $params->not_channel) {
			$model->with('Channel');
		}

		// Include Categories model if applicable
		foreach ($categoryParams as $catParam) {
			if ($params->{$catParam}) {
				$model->with('Categories');
				break;
			}
		}

		// Filter by entry_id
		if ($params->entry_id) {
			$model->filter('entry_id', 'IN', $params->entry_id);
		}
		if ($params->not_entry_id) {
			$model->filter('entry_id', 'NOT IN', $params->not_entry_id);
		}

		// Filter by url_title
		if ($params->url_title) {
			$model->filter('url_title', 'IN', $params->url_title);
		}
		if ($params->not_url_title) {
			$model->filter('url_title', 'NOT IN', $params->not_url_title);
		}

		// Filter by channel_id
		if ($params->channel_id) {
			$model->filter('channel_id', 'IN', $params->channel_id);
		}
		if ($params->not_channel_id) {
			$model->filter('channel_id', 'NOT IN', $params->not_channel_id);
		}

		// Filter by channel
		if ($params->channel) {
			$model->filter('Channel.channel_name', 'IN', $params->channel);
		}
		if ($params->not_channel) {
			$model->filter(
				'Channel.channel_name',
				'NOT IN',
				$params->not_channel
			);
		}

		// Filter by category_id
		if ($params->category_id) {
			$model->filter('Categories.cat_id', 'IN', $params->category_id);
		}
		if ($params->not_category_id) {
			$model->filter(
				'Categories.cat_id',
				'NOT IN',
				$params->not_category_id
			);
		}

		// Filter by category_url_title
		if ($params->category_url_title) {
			$model->filter(
				'Categories.cat_url_title',
				'IN',
				$params->category_url_title
			);
		}
		if ($params->not_category_url_title) {
			$model->filter(
				'Categories.cat_url_title',
				'NOT IN',
				$params->not_category_url_title
			);
		}

		// Filter by category_group_id
		if ($params->category_group_id) {
			$model->filter(
				'Categories.group_id',
				'IN',
				$params->category_group_id
			);
		}
		if ($params->not_category_group_id) {
			$model->filter(
				'Categories.group_id',
				'NOT IN',
				$params->not_category_group_id
			);
		}

		// Filter by status
		if ($params->status) {
			$model->filter('status', 'IN', $params->status);
		}
		if ($params->not_status) {
			$model->filter('status', 'NOT IN', $params->not_status);
		}

		// Do not show future entries unless applicable
		if (! $params->show_future_entries) {
			$model->filter('entry_date', '<=', time());
		}

		// Do not show expired entries unless applicable
		if (! $params->show_expired_entries) {
			$model->filterGroup()
				->filter('expiration_date', '>=', time())
				->orFilter('expiration_date', 0)
				->endFilterGroup();
		}

		// Get the applicable entry
		$entry = $model->first();

		// Return the timestamp if there is an entry
		if ($entry) {
			return $entry->edit_date->getTimestamp();
		}

		return false;
	}
}
