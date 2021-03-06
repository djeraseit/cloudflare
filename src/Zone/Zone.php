<?php

namespace JamesRyanBell\Cloudflare;
use JamesRyanBell\Cloudflare\Api;

/**
 * CloudFlare API wrapper
 *
 * Zone
 * A Zone is a domain name along with its subdomains and other identities
 *
 * @author James Bell <james@james-bell.co.uk>
 * @version 1
 */

class Zone extends Api
{
	protected $permission_level = array('read' => '#zone:read', 'edit' => '#zone:edit');

	/**
	 * Create a zone (permission needed: #zone:edit)
	 * @param string   $domain       The domain name
	 * @param boolean  $jump_start   Automatically attempt to fetch existing DNS records
	 * @param null     $organization Organization that this zone will belong to
	 */
	public function create($name, $jump_start = true, $organization = null)
	{
		$data = array(
			'name'         => $name,
			'jump_start'   => $jump_start,
			'organization' => $organization
		);
		return $this->post('zones', $data);
	}

	/**
	 * List zones permission needed: #zone:read
	 * List, search, sort, and filter your zones
	 * @param string  $name      A domain name
	 * @param string  $status    Status of the zone (active, pending, initializing, moved, deleted)
	 * @param integer $page      Page number of paginated results
	 * @param integer $per_page  Number of zones per page
	 * @param string  $order     Field to order zones by (name, status, email)
	 * @param string  $direction Direction to order zones (asc, desc)
	 * @param string  $match     Whether to match all search requirements or at least one (any) (any, all)
	 */
	public function zones($name = '', $status = 'active', $page = 1, $per_page = 20, $order = 'status', $direction = 'desc', $match = 'all')
	{
		$data = array(
			'name'      => $name,
			'status'    => $status,
			'page'      => $page,
			'per_page'  => $per_page,
			'order'     => $order,
			'direction' => $direction,
			'match'     => $match
		);
		return $this->get('zones', $data);
	}

	/**
	 * Zone details (permission needed: #zone:read)
	 * @param string $zone_identifier API item identifier tag
	 */
	public function zone($zone_identifier)
	{
		return $this->get('zones/' . $zone_identifier);
	}

	/**
	 * Pause all CloudFlare features (permission needed: #zone:edit)
	 * This will pause all features and settings for the zone. DNS will still resolve
	 * @param string $zone_identifier API item identifier tag
	 */
	public function pause($zone_identifier)
	{
		return $this->put('zones/' . $zone_identifier . '/pause');
	}

	/**
	 * Re-enable all CloudFlare features (permission needed: #zone:edit)
	 * This will restore all features and settings for the zone
	 * @param string $zone_identifier API item identifier tag
	 */
	public function unpause($zone_identifier)
	{
		return $this->put('zones/' . $zone_identifier . '/unpause');
	}

	/**
	 * Delete a zone (permission needed: #zone:edit)
	 * @param string $zone_identifier API item identifier tag
	 */
	public function delete_zone($zone_identifier)
	{
		return $this->delete('zones/' . $zone_identifier);
	}

}
