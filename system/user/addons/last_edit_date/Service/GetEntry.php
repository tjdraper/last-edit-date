<?php

namespace BuzzingPixel\LastEditDate\Service;

/**
 * Last Edit Date plugin
 *
 * @package last_edit_date
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/last-edit-date
 * @copyright Copyright (c) 2015, Buzzing Pixel
 */

class GetEntry
{
	private $params = array(
		'entryId' => array(),
		'urlTitle' => array(),
		'channelId' => array(),
		'channel' => array(),
		'categoryId' => array(),
		'categoryUrlTitle' => array(),
		'categoryGroupId' => array(),
		'notStatus' => array(),
		'status' => array(
			'open'
		),
		'showFutureEntries' => false,
		'showExpiredEntries' => false
	);

	/**
	 * GetEntry constructor
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
	 * Set params
	 *
	 * @param $params
	 * @return self
	 */
	public function params($params)
	{
		$this->params = array_merge($this->params, $params);
		return $this;
	}

	/**
	 * Get entry based on criteria
	 *
	 * @return false|int Unix timestamp or false if not entry
	 */
	public function get()
	{
		$params = $this->params;

		$categoryParams = array(
			'categoryId',
			'categoryUrlTitle',
			'categoryGroupId'
		);

		$model = ee('Model')->get('ChannelEntry')
			->order('edit_date', 'DESC');

		if ($params['entryId']) {
			$model->filter('entry_id', 'IN', $params['entryId']);
		}

		if ($params['urlTitle']) {
			$model->filter('url_title', 'IN', $params['urlTitle']);
		}

		if ($params['channelId']) {
			$model->filter('channel_id', 'IN', $params['channelId']);
		}

		if ($params['channel']) {
			$model->with('Channel')
				->filter('Channel.channel_name', 'IN', $params['channel']);
		}

		foreach ($categoryParams as $catParam) {
			if ($params[$catParam]) {
				$model->with('Categories');

				break;
			}
		}

		if ($params['categoryId']) {
			$model->filter('Categories.cat_id', 'IN', $params['categoryId']);
		}

		if ($params['categoryUrlTitle']) {
			$model->filter(
				'Categories.cat_url_title',
				'IN',
				$params['categoryUrlTitle']
			);
		}

		if ($params['categoryGroupId']) {
			$model->filter(
				'Categories.group_id',
				'IN',
				$params['categoryGroupId']
			);
		}

		if ($params['notStatus']) {
			$model->filter('status', 'NOT IN', $params['notStatus']);
		}

		if ($params['status']) {
			$model->filter('status', 'IN', $params['status']);
		}

		if (! $params['showFutureEntries']) {
			$model->filter('entry_date', '<=', time());
		}

		if (! $params['showExpiredEntries']) {
			$model->filterGroup()
				->filter('expiration_date', '>=', time())
				->orFilter('expiration_date', 0)
				->endFilterGroup();
		}

		$entry = $model->first();

		if ($entry) {
			return $entry->edit_date->getTimestamp();
		}

		return false;
	}
}
