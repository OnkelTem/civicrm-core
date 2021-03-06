<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.6                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2014                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License along with this program; if not, contact CiviCRM LLC       |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

require_once 'CiviTest/CiviSeleniumTestCase.php';

/**
 * Class WebTest_Contact_EditContactTest
 */
class WebTest_Contact_EditContactTest extends CiviSeleniumTestCase {
  protected function setUp() {
    parent::setUp();
  }

  public function testEditContact() {
    // Log in using webtestLogin() method
    $this->webtestLogin();

    // create contact
    $firstName = 'WebTest' . substr(sha1(rand()), 0, 7);
    $lastName  = 'ContactEdit' . substr(sha1(rand()), 0, 7);
    $this->openCiviPage("contact/add", "reset=1&ct=Individual");
    $this->type("first_name", $firstName);
    $this->type("last_name", $lastName);

    //fill in phone  1
    $this->type("phone_1_phone", "111113333");
    $this->type("phone_1_phone_ext", "101");

    //fill in phone  2

    $this->click("//a[@id='addPhone']");
    $this->type("phone_2_phone", "23213333");
    $this->type("phone_2_phone_ext", "165");
    $this->select('phone_2_location_type_id', 'value=2');

    //fill in phone  3
    $this->click("//a[@id='addPhone']");
    $this->type("phone_3_phone", "2321877699");
    $this->type("phone_3_phone_ext", "195");
    $this->select('phone_3_location_type_id', 'value=2');

    //fill in phone  4
    $this->click("//a[@id='addPhone']");
    $this->type("phone_4_phone", "2321398766");
    $this->type("phone_4_phone_ext", "198");
    $this->select('phone_4_location_type_id', 'value=2');

    // Submit form
    $this->click("_qf_Contact_upload_view-bottom");
    $this->waitForElementPresent('css=.crm-inline-edit-container.crm-edit-ready');

    //assert
    $this->assertTextPresent("111113333  ext. 101");
    $this->assertTextPresent("23213333  ext. 165");
    $this->assertTextPresent("2321877699  ext. 195");
    $this->assertTextPresent("2321398766  ext. 198");

    //Edit COntact
    $cid = $this->urlArg('cid');
    $this->openCiviPage("contact/add", "reset=1&action=update&cid={$cid}");

    //Edit in phone  1
    $this->type("phone_1_phone", "12223333");
    $this->type("phone_1_phone_ext", "100");

    //Edit in phone  2
    $this->type("phone_2_phone", "2321800000");
    $this->type("phone_2_phone_ext", "111");
    $this->select('phone_2_location_type_id', 'value=3');

    //Edit in phone  3
    $this->type("phone_3_phone", "777777699");
    $this->type("phone_3_phone_ext", "197");
    $this->select('phone_3_location_type_id', 'value=1');

    //Edit in phone  4
    $this->type("phone_4_phone", "2342322222");
    $this->type("phone_4_phone_ext", "198");
    $this->select('phone_4_location_type_id', 'value=3');

    // Submit form
    $this->click("_qf_Contact_upload_view-bottom");
    $this->waitForElementPresent('css=.crm-inline-edit-container.crm-edit-ready');

    //assert
    $this->assertTextPresent("12223333  ext. 100");
    $this->assertTextPresent("2321800000  ext. 111");
    $this->assertTextPresent("777777699  ext. 197");
    $this->assertTextPresent("2342322222  ext. 198");

  }
}
