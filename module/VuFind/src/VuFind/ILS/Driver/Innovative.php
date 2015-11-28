<?php
/**
 * III ILS Driver
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2007.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category VuFind2
 * @package  ILS_Drivers
 * @author   Adam Brin <abrin@brynmawr.com>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_an_ils_driver Wiki
 */
namespace VuFind\ILS\Driver;
use VuFind\Exception\ILS as ILSException;

/**
 * VuFind Connector for Innovative
 *
 * This class uses screen scraping techniques to gather record holdings written
 * by Adam Bryn of the Tri-College consortium.
 *
 * @category VuFind2
 * @package  ILS_Drivers
 * @author   Adam Brin <abrin@brynmawr.com>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     http://vufind.org/wiki/vufind2:building_an_ils_driver Wiki
 */
class Innovative extends AbstractBase implements
    \VuFindHttp\HttpServiceAwareInterface
{
    /**
     * HTTP service
     *
     * @var \VuFindHttp\HttpServiceInterface
     */
    protected $httpService = null;

    /**
     * Set the HTTP service to be used for HTTP requests.
     *
     * @param HttpServiceInterface $service HTTP service
     *
     * @return void
     */
    public function setHttpService(\VuFindHttp\HttpServiceInterface $service)
    {
        $this->httpService = $service;
    }

    /**
     * Initialize the driver.
     *
     * Validate configuration and perform all resource-intensive tasks needed to
     * make the driver active.
     *
     * @throws ILSException
     * @return void
     */
    public function init()
    {
        if (empty($this->config)) {
            throw new ILSException('Configuration needs to be set.');
        }
    }

    /**
     * Make an HTTP request
     *
     * @param string $url URL to request
     *
     * @return string
     */
    protected function sendRequest($url)
    {
        // Make the NCIP request:
        try {
            $result = $this->httpService->get($url);
        } catch (\Exception $e) {
            throw new ILSException($e->getMessage());
        }

        if (!$result->isSuccess()) {
            throw new ILSException('HTTP error');
        }

        return $result->getBody();
    }

    /**
     * prepID
     *
     * This function returns the correct record id format as defined
     * in the Innovative.ini file.
     *
     * @param string $id ID to format
     *
     * @return string
     */
    protected function prepID($id)
    {
        // Get the ID format from config (default to use_full_id if unset):
        if (!isset($this->config['RecordID']['use_full_id'])
            || $this->config['RecordID']['use_full_id']
        ) {
            // Strip ID leading period and trailing check digit.
            $id_ = substr(str_replace('.b', '', $id), 0, -1);
        } else {
            // Return digits only.
            $id_ = substr($id, 1);
        };
        return $id_;
    }

    /**
     * Get Status
     *
     * This is responsible for retrieving the status information of a certain
     * record.
     *
     * @param string $id The record id to retrieve the holdings for
     *
     * @throws ILSException
     * @return mixed     On success, an associative array with the following keys:
     * id, availability (boolean), status, location, reserve, callnumber.
     */
//    public function getStatus($id)
//    {
//        // Strip ID
//        $id_ = $this->prepID($id);

//        // Load Record Page
//        if (substr($this->config['Catalog']['url'], -1) == '/') {
//            $host = substr($this->config['Catalog']['url'], 0, -1);
//        } else {
//            $host = $this->config['Catalog']['url'];
//        }

        // Grab the full item list view
        //$result = $this->sendRequest($host . '/record=b' . $id_);
//        $result = $this->sendRequest(
//            $host . '/search/.b' . $id_ . '/.b' . $id_ .
//            '/1%2C1%2C1%2CB/holdings~' . $id_ . '&FF=&1%2C0%2C'
//        );

        // strip out html before the first occurance of 'bibItems', should be
        // '<table class="bibItems" '
//        $r = substr($result, stripos($result, 'bibItems'));
        // strip out the rest of the first table tag.
//        $r = substr($r, strpos($r, ">")+1);
        // strip out the next table closing tag and everything after it.
//        $r = substr($r, 0, stripos($r, "</table"));

        // $r should only include the holdings table at this point

        // split up into strings that contain each table row, excluding the
        // beginning tr tag.
//        $rows = preg_split("/<tr([^>]*)>/", $r);
//        $count = 0;
//        $keys = array_pad(array(), 10, "");

//        $loc_col_name      = $this->config['OPAC']['location_column'];
//        $call_col_name     = $this->config['OPAC']['call_no_column'];
//        $status_col_name   = $this->config['OPAC']['status_column'];
//        $reserves_col_name = $this->config['OPAC']['location_column'];
//        $reserves_key_name = $this->config['OPAC']['reserves_key_name'];
//        $stat_avail        = $this->config['OPAC']['status_avail'];
//        $stat_due          = $this->config['OPAC']['status_due'];

//        $ret = array();
//        foreach ($rows as $row) {
            // Split up the contents of the row based on the th or td tag, excluding
            // the tags themselves.
//            $cols = preg_split("/<t(h|d)([^>]*)>/", $row);

            // for each th or td section, do the following.
//            for ($i=0; $i < sizeof($cols); $i++) {
                // replace non blocking space encodings with a space.
//                $cols[$i] = str_replace("&nbsp;", " ", $cols[$i]);
                // remove html comment tags
//                $cols[$i] = ereg_replace("<!--([^(-->)]*)-->", "", $cols[$i]);
                // Remove closing th or td tag, trim whitespace and decode html
                // entities
//                $cols[$i] = html_entity_decode(
//                    trim(substr($cols[$i], 0, stripos($cols[$i], "</t")))
//                );

                // If this is the first row, it is the header row and has the column
                // names
//                if ($count == 1) {
//                    $keys[$i] = $cols[$i];
//                } else if ($count > 1) { // not the first row, has holding info
                    //look for location column
//                    if (stripos($keys[$i], $loc_col_name) > -1) {
//                        $ret[$count-2]['location'] = strip_tags($cols[$i]);
//                    }
                    // Does column hold reserves information?
//                    if (stripos($keys[$i], $reserves_col_name) > -1) {
//                        if (stripos($cols[$i], $reserves_key_name) > -1) {
//                            $ret[$count-2]['reserve'] = 'Y';
//                        } else {
//                            $ret[$count-2]['reserve'] = 'N';
//                        }
//                    }
                    // Does column hold call numbers?
//                    if (stripos($keys[$i], $call_col_name) > -1) {
//                        $ret[$count-2]['callnumber'] = strip_tags($cols[$i]);
//                    }
                    // Look for status information.
//                    if (stripos($keys[$i], $status_col_name) > -1) {
//                        if (stripos($cols[$i], $stat_avail) > -1) {
//                            $ret[$count-2]['status'] = "Available On Shelf";
//                           $ret[$count-2]['availability'] = 1;
//                        } else {
//                            $ret[$count-2]['status'] = "Available to request";
//                            $ret[$count-2]['availability'] = 0;
//                        }
//                        if (stripos($cols[$i], $stat_due) > -1) {
//                            $t = trim(
//                                substr(
//                                    $cols[$i],
//                                    stripos($cols[$i], $stat_due) + strlen($stat_due)
//                                )
//                            );
//                            $t = substr($t, 0, stripos($t, " "));
//                            $ret[$count-2]['duedate'] = $t;
//                        }
//                    }
                    //$ret[$count-2][$keys[$i]] = $cols[$i];
                    //$ret[$count-2]['id'] = $bibid;
//                   $ret[$count-2]['id'] = $id;
//                    $ret[$count-2]['number'] = ($count -1);
                    // Return a fake barcode so hold link is enabled
                    // TODO: Should be dependent on settings variable, if bib level
                    // holds.
//                    $ret[$count-2]['barcode'] = '1234567890123';
//                }
//            }
//            $count++;
//        }
//        return $ret;
//    }

    /**
     * Get Statuses
     *
     * This is responsible for retrieving the status information for a
     * collection of records.
     *
     * @param array $ids The array of record ids to retrieve the status for
     *
     * @throws ILSException
     * @return array     An array of getStatus() return values on success.
     */
    public function getStatuses($ids)
    {
        $items = array();
        $count = 0;
        foreach ($ids as $id) {
            $items[$count] = $this->getStatus($id);
            $count++;
        }
        return $items;
    }

    /**
     * Get Holding
     *
     * This is responsible for retrieving the holding information of a certain
     * record.
     *
     * @param string $id     The record id to retrieve the holdings for
     * @param array  $patron Patron data
     *
     * @throws \VuFind\Exception\Date
     * @throws ILSException
     * @return array         On success, an associative array with the following
     * keys: id, availability (boolean), status, location, reserve, callnumber,
     * duedate, number, barcode.
     */
    public function getHolding($id, array $patron = null)
    {
        return $this->getStatus($id);
    }

    /**
     * Get Purchase History
     *
     * This is responsible for retrieving the acquisitions history data for the
     * specific record (usually recently received issues of a serial).
     *
     * @param string $id The record id to retrieve the info for
     *
     * @throws ILSException
     * @return array     An array with the acquisitions data on success.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getPurchaseHistory($id)
    {
        // TODO
        return array();
    }

    /**
     * Get Hold Link
     *
     * The goal for this method is to return a URL to a "place hold" web page on
     * the ILS OPAC. This is used for ILSs that do not support an API or method
     * to place Holds.
     *
     * @param string $id      The id of the bib record
     * @param array  $details Item details from getHoldings return array
     *
     * @return string         URL to ILS's OPAC's place hold screen.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getHoldLink($id, $details)
    {
        // Strip ID
        $id_ = $this->prepID($id);

        //Build request link
        $link = $this->config['Catalog']['url'] . '/search?/.b' . $id_ . '/.b' .
            $id_ . '/1%2C1%2C1%2CB/request~b'. $id_;
        //$link = $this->config['Catalog']['url'] . '/record=b' . $id_;

        return $link;
    }

    /**
     * Get Patron Profile
     *
     * This is responsible for retrieving the profile for a specific patron.
     *
     * @param array $userinfo The patron array
     *
     * @throws ILSException
     * @return array          Array of the patron's profile data on success.
     */
    public function getMyProfile($userinfo)
    {
        return $userinfo;
    }

    /**
     * Patron Login
     *
     * This is responsible for authenticating a patron against the catalog.
     *
     * @param string $username The patron username
     * @param string $password The patron's password
     *
     * @throws ILSException
     * @return mixed          Associative array of patron info on successful login,
     * null on unsuccessful login.
     */
    public function patronLogin($username, $password)
    {
        // TODO: if username is a barcode, test to make sure it fits proper format
        if ($this->config['PATRONAPI']['enabled'] == 'true') {
            // use patronAPI to authenticate customer
            $url = $this->config['PATRONAPI']['url'];

            // build patronapi pin test request
            $result = $this->sendRequest(
                $url . urlencode($username) . '/' . urlencode($password) .
                '/pintest'
            );

            // search for successful response of "RETCOD=0"
            if (stripos($result, "RETCOD=0") == -1) {
                // pin did not match, can look up specific error to return
                // more usefull info.
                return null;
            }

            // Pin did match, get patron information
            $result = $this->sendRequest($url . urlencode($username) . '/dump');

            // The following is taken and modified from patronapi.php by John Blyberg
            // released under the GPL
            $api_contents = trim(strip_tags($result));
            $api_array_lines = explode("\n", $api_contents);
            $api_data = array('PBARCODE' => false);

            foreach ($api_array_lines as $api_line) {
                $api_line = str_replace("p=", "peq", $api_line);
                $api_line_arr = explode("=", $api_line);
                $regex_match = array("/\[(.*?)\]/","/\s/","/#/");
                $regex_replace = array('','','NUM');
                $key = trim(
                    preg_replace($regex_match, $regex_replace, $api_line_arr[0])
                );
                $api_data[$key] = trim($api_line_arr[1]);
            }

            if (!$api_data['PBARCODE']) {
                // no barcode found, can look up specific error to return more
                // useful info.  this check needs to be modified to handle using
                // III patron ids also.
                return null;
            }

            // return patron info
            $ret = array();
            $ret['id'] = $api_data['PBARCODE']; // or should I return patron id num?
            $names = explode(',', $api_data['PATRNNAME']);
            $ret['firstname'] = $names[1];
            $ret['lastname'] = $names[0];
            $ret['cat_username'] = urlencode($username);
            $ret['cat_password'] = urlencode($password);
            $ret['email'] = $api_data['EMAILADDR'];
            $ret['major'] = null;
            $ret['college'] = $api_data['HOMELIBR'];
            $ret['homelib'] = $api_data['HOMELIBR'];
            // replace $ separator in III addresses with newline
            $ret['address1'] = str_replace("$", ", ", $api_data['ADDRESS']);
            $ret['address2'] = str_replace("$", ", ", $api_data['ADDRESS2']);
            preg_match(
                "/([0-9]{5}|[0-9]{5}-[0-9]{4})[ ]*$/", $api_data['ADDRESS'],
                $zipmatch
            );
            $ret['zip'] = $zipmatch[1]; //retrieve from address
            $ret['phone'] = $api_data['TELEPHONE'];
            $ret['phone2'] = $api_data['TELEPHONE2'];
            // Should probably have a translation table for patron type
            $ret['group'] = $api_data['PTYPE'];
            $ret['expiration'] = $api_data['EXPDATE'];
            // Only if agency module is enabled.
            $ret['region'] = $api_data['AGENCY'];
            return $ret;
        } else {
            // TODO: use screen scrape
            return null;
        }
    }
    /**
    * CUSTOM CODE FOR SOAS LIBRARY FUNCTIONS
    * @author	Simon Barron <sb174@soas.ac.uk>
    * 
    /**
    * Get Status
    * 
    * Edited version of getStatus above to get additional information.
    *
    */
    public function getStatus($id)
    {
        // Strip ID
        $id_ = $this->prepID($id);
        $GLOBALS['a'] = $id_;

        // Load Record Page
        if (substr($this->config['Catalog']['url'], -1) == '/') {
            $host = substr($this->config['Catalog']['url'], 0, -1);
        } else {
            $host = $this->config['Catalog']['url'];
        }

        // Grab the full item list view
        //$result = $this->sendRequest($host . '/record=b' . $id_);
        $result = $this->sendRequest($host . '/search/.b' . $id_ . '/.b' . $id_ . '/1%2C1%2C1%2CB/holdings~' . $id_ . '&FF=&1%2C0%2C');

        // Grab the full item list view
        //$result = $this->sendRequest($host . '/record=b' . $id_);
        //$result = $this->sendRequest(
        //    $host . '/record=b' . $id_
        //);

        // strip out html before the first occurance of 'bibItems', should be
        // '<table class="bibItems" '
        $r = substr($result, stripos($result, 'bibItems'));
        // strip out the rest of the first table tag.
        $r = substr($r, strpos($r, ">")+1);
        // strip out the next table closing tag and everything after it.
        $r = substr($r, 0, stripos($r, "</table"));

        // $r should only include the holdings table at this point

        // split up into strings that contain each table row, excluding the
        // beginning tr tag.
        $rows = preg_split("/<tr([^>]*)>/", $r);
        $count = 0;
        $keys = array_pad(array(), 10, "");

        $loc_col_name      = $this->config['OPAC']['location_column'];
        $call_col_name     = $this->config['OPAC']['call_no_column'];
        $status_col_name   = $this->config['OPAC']['status_column'];
        $reserves_col_name = $this->config['OPAC']['location_column'];
        $reserves_key_name = $this->config['OPAC']['reserves_key_name'];
        $stat_avail        = $this->config['OPAC']['status_avail'];
        $stat_due          = $this->config['OPAC']['status_due'];
        // ADDED FOR SOAS 
        $loan_col_name     = $this->config['OPAC']['loan_period_column'];

        $ret = array();
        foreach ($rows as $row) {
            // Split up the contents of the row based on the th or td tag, excluding
            // the tags themselves.
            $cols = preg_split("/<t(h|d)([^>]*)>/", $row);

            // for each th or td section, do the following.
            for ($i=0; $i < sizeof($cols); $i++) {
                // replace non blocking space encodings with a space.
                $cols[$i] = str_replace("&nbsp;", " ", $cols[$i]);
                // remove html comment tags
                $cols[$i] = ereg_replace("<!--([^(-->)]*)-->", "", $cols[$i]);
                // Remove closing th or td tag, trim whitespace and decode html
                // entities
                $cols[$i] = html_entity_decode(trim(substr($cols[$i], 0, stripos($cols[$i], "</t"))));

                // If this is the first row, it is the header row and has the column
                // names
                if ($count == 1) {
                    $keys[$i] = $cols[$i];
                } else if ($count > 1) { // not the first row, has holding info
                    //look for location column
                    if (stripos($keys[$i], $loc_col_name) > -1) {
                        $ret[$count-2]['location'] = strip_tags($cols[$i]);
                    }
                    // Does column hold reserves information?
                    if (stripos($keys[$i], $reserves_col_name) > -1) {
                        if (stripos($cols[$i], $reserves_key_name) > -1) {
                            $ret[$count-2]['reserve'] = 'Y';
                        } else {
                            $ret[$count-2]['reserve'] = 'N';
                        }
                    }
                    // Does column hold call numbers?
                    if (stripos($keys[$i], $call_col_name) > -1) {
                        $ret[$count-2]['callnumber'] = strip_tags($cols[$i]);
                    }
                    // ADDED FOR SOAS: Does column hold loan period information?
                    if (stripos($keys[$i], $loan_col_name) > -1) {
                        $ret[$count-2]['loan_period'] = strip_tags($cols[$i]);
                    }
                    // Look for status information.
                    if (stripos($keys[$i], $status_col_name) > -1) {
                        if (stripos($cols[$i], 'LIB USE ONLY') > -1) {
                            $ret[$count-2]['status'] = "Reference only";
                            $ret[$count-2]['availability'] = 1;
                        } else if (stripos($cols[$i], 'Recently returned') > -1) {
                            $ret[$count-2]['status'] = "Recently returned";
                            $ret[$count-2]['availability'] = 1;
                        } else if (stripos($cols[$i], 'REF ASK STAFF') > -1) {
                            $ret[$count-2]['status'] = "Reference only";
                            $ret[$count-2]['availability'] = 1;
                        } else if (stripos($cols[$i], 'REF: OPEN ACSS') > -1) {
                            $ret[$count-2]['status'] = "Reference only";
                            $ret[$count-2]['availability'] = 1;
                        } else if (stripos($cols[$i], 'APPLY TO STAFF') > -1) {
                            $ret[$count-2]['status'] = "Ask library staff";
                            $ret[$count-2]['availability'] = 1;
                        } else if (stripos($cols[$i], 'AVAILABLE') > -1) {
                            $ret[$count-2]['status'] = "Available";
                            $ret[$count-2]['availability'] = 1;
                        } else if (stripos($cols[$i], 'Missing') > -1) { 
                            $ret[$count-2]['status'] = "Missing";
                            $ret[$count-2]['availability'] = 0;
                        } else if (stripos($cols[$i], 'BILLED') > -1) {
                            $ret[$count-2]['status'] = "Unavailable";
                            $ret[$count-2]['availability'] = 0;
                        } else if (stripos($cols[$i], 'ON HOLDSHELF') > -1) {
                            $ret[$count-2]['status'] = "On holdshelf";
                            $ret[$count-2]['availability'] = 0;
                        } else if (stripos($cols[$i], 'PERIODICALS') > -1) {
                            $ret[$count-2]['status'] = "Available";
                            $ret[$count-2]['availability'] = 1;
                        } else {
                            $ret[$count-2]['status'] = "On loan";
                            $ret[$count-2]['availability'] = 0;
                        }
                    //if (stripos($cols[$i], $stat_due) > -1) {
                    if (stripos($cols[$i], 'DUE ') > -1) {
                        $t = trim(
                             substr(
                                $cols[$i],
                                stripos($cols[$i], 'DUE ') + strlen('DUE ')
                             )
                        );
                        //$t = substr($t, 0, stripos($t, " "));
                        $ret[$count-2]['duedate'] = $t;
                    } 
                    // else { echo '<script type="text/javascript"> alert(\'BILGE\'); </script>';
                    //}
                }
                //$ret[$count-2][$keys[$i]] = $cols[$i];
                //$ret[$count-2]['id'] = $bibid;
                $ret[$count-2]['id'] = $id;
                $ret[$count-2]['number'] = ($count -1);
                // Return a fake barcode so hold link is enabled
                // TODO: Should be dependent on settings variable, if bib level
                // holds.
                //$ret[$count-2]['barcode'] = '1234567890123';
                $ret[$count-2]['barcode'] = ' ';
                }
            }
            $count++;
            }
            return $ret;
	}
    /**
    * Get Journal Status
    *
    * Function written by Simon Barron to get holdings information for journals in Millennium.
    *
    */
    public function getJournalStatus()
	{

	// Strip ID
	// $id_ = $this->prepID($id);

	$id_ = $GLOBALS['a'];

	// Load Record Page

	if (substr($this->config['Catalog']['url'], -1) == '/')
		{
		$host = substr($this->config['Catalog']['url'], 0, -1);
		}
	  else
		{
		$host = $this->config['Catalog']['url'];
		}

	// Grab the full item list view

	$result = $this->sendRequest($host . '/record=b' . $id_);
	if (strpos($result, 'CALL#') !== false)
		{

		// strip out html before the first occurance of 'bibItems', should be
		// '<table class="bibItems" '

		$r = substr($result, strpos($result, 'class="bibItems">'));

		// strip out the rest of the first table tag.
		// $r = substr($r, strpos($r, ">")+1);
		// strip out the next table closing tag and everything after it.

		$r = substr($r, 0, strpos($r, "</table"));
		$r = substr($r, strpos($r, '</tr'));
		$r = preg_replace("(<a href=\")", "<a href=\"http://lib.soas.ac.uk", $r);
		echo "<table id='journalholdings'> $r</table>";
		}
	elseif (strpos($result, 'class="bibHoldingsEntry">Internet') !== false)
		{
		}
	elseif (strpos($result, 'bibHoldingsEntry') !== false)
		{
		$r = substr($result, strpos($result, '<td  class="bibHoldingsLabel">'));
		$r = substr($r, 0, strpos($r, "</table"));
		$r = substr($r, 0, strrpos($r, "<td colspan"));
		$r = preg_replace("(<em>Location<\/em><\/td><td  class=\"bibHoldingsEntry\"><a href=\".+\">)", "<em>Location</em></td><td  class=\"bibHoldingsEntry\">", $r);
		$r = str_replace("<tr><td colspan=\"2\"><hr  class=\"holdingsDivider\" /></td></tr>", " ", $r);
		$r = preg_replace("(<em>Location<\/em>+)", "<b>Location:</b>", $r);
		$r = preg_replace("(Identity)", "<b>Format:</b>", $r);
		$r = str_replace("<em>Lib. Has</em>", "<b>Holdings:</b>", $r);
		$r = preg_replace("(<a href=\")", "<a href=\"http://lib.soas.ac.uk", $r);
		$r = str_replace("<em>", "<b>", $r);
		echo "<table class='table table-striped' id='journalholdings'>$r</table>";
		}
	}
    /**
    * Get eresources Status
    *
    * Function written by Simon Barron to get holdings information for eresources in Millennium.
    *
    */
    public function getEresourceStatus()
	{

	// Strip ID
	// $id_ = $this->prepID($id);

	$id_ = $GLOBALS['a'];

	// Load Record Page

	if (substr($this->config['Catalog']['url'], -1) == '/')
		{
		$host = substr($this->config['Catalog']['url'], 0, -1);
		}
	  else
		{
		$host = $this->config['Catalog']['url'];
		}

	// Grab the full item list view

	$result = $this->sendRequest($host . '/record=b' . $id_);
	$result = $this->sendRequest($host . '/record=b' . $id_);
	if (strpos($result, 'BEGIN ERM RESOURCE TABLE') !== false)
		{
		$r = substr($result, strpos($result, '<tr  class="bibResourceEntry">'));
		$r = substr($r, 0, strpos($r, "</table"));
		$r = preg_replace("(<a href=\"(.+\").+\/screens\/resource_record\.gif\".+)", "<a href=\"http://catalogue.ulrls.lon.ac.uk$1\">About this e-resource</a>", $r);
		$r = preg_replace("(<tr >(?s:.)+?bibResourceSubEntry(?s:.)+?<\/tr>)", "", $r);
		echo "<h4>Online Access</h4>";
		echo "<table class='table table-striped' id='eresourceholdings'>$r</table>";
		}
	}
    /**
    * Get Order Status
    *
    * Function written by Simon Barron to get order information.
    *
    */
    public function getOrderStatus()
	{

	// Strip ID
	// $id_ = $this->prepID($id);

	$id_ = $GLOBALS['a'];

	// Load Record Page

	if (substr($this->config['Catalog']['url'], -1) == '/')
		{
		$host = substr($this->config['Catalog']['url'], 0, -1);
		}
	  else
		{
		$host = $this->config['Catalog']['url'];
		}

	// Grab the full item list view

	$result = $this->sendRequest($host . '/record=b' . $id_);
	$result = $this->sendRequest($host . '/record=b' . $id_);
	if (strpos($result, 'bibOrderEntry') !== false)
		{
		$r = substr($result, strpos($result, '<tr  class="bibOrderEntry">'));
		$r = substr($r, 0, strpos($r, "</table"));
		echo "<table class='table table-striped' id='eresourceholdings'>$r</table>";
		}
	}
}