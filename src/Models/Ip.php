<?php

/**
 * This file is part of Laravel CloudFlare API by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\CloudFlareAPI\Models;

use GrahamCampbell\CoreAPI\Models\AbstractModel;

/**
 * This is the ip model class.
 *
 * @package    Laravel-CloudFlare-API
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-CloudFlare-API/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-CloudFlare-API
 */
class Ip extends AbstractModel
{
    /**
     * The ip address.
     *
     * @var string
     */
    protected $ip;

    /**
     * Create a new model instance.
     *
     * @param  \GuzzleHttp\Command\Guzzle\GuzzleClient  $client
     * @param  string  $ip
     * @param  array   $cache
     * @return void
     */
    public function __construct(GuzzleClient $client, $ip, array $cache = array())
    {
        parent::__construct($client, $cache);

        $this->ip = (string) $ip;
    }

    /**
     * Get the ip address.
     *
     * @return string
     */
    public function getIp()
    {
        return (string) $this->ip;
    }

    /**
     * Get the threat score.
     *
     * @return string
     */
    public function getScore()
    {
        $ipLkup = $this->get('ipLkup', array('ip' => $this->ip));

        $score = $ipLkup['response'][$this->ip];

        if ($score) {
            return (string) $score;
        } else {
            return 'unknown';
        }
    }

    /**
     * Whitelist this ip.
     *
     * @return self
     */
    public function whitelist()
    {
        $this->post('wl', array('key' => $this->ip), false);

        return $this;
    }

    /**
     * Ban this ip.
     *
     * @return self
     */
    public function ban()
    {
        $this->post('ban', array('key' => $this->ip), false);

        return $this;
    }

    /**
     * Unlist this ip.
     *
     * @return self
     */
    public function unlist()
    {
        $this->post('nul', array('key' => $this->ip), false);

        return $this;
    }
}