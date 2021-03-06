<?php
require_once 'CiviTest/CiviUnitTestCase.php';

/**
 * Class CRM_Utils_HttpClientTest
 */
class CRM_Utils_HttpClientTest extends CiviUnitTestCase {

  const VALID_HTTP_URL = 'http://sandbox.civicrm.org/';
  const VALID_HTTP_REGEX = '/<html/';
  const VALID_HTTPS_URL = 'https://civicrm.org/INSTALL.mysql.txt';
  const VALID_HTTPS_REGEX = '/MySQL/';
  const SELF_SIGNED_HTTPS_URL = 'https://self-signed.onebitwise.com:4443/';
  const SELF_SIGNED_HTTPS_REGEX = '/self-signed/';

  /**
   * @var string path to which we can store temp file
   */
  protected $tmpFile;

  /**
   * @var CRM_Utils_HttpClient
   */
  protected $client;

  public function setUp() {
    parent::setUp();

    $this->tmpFile = $this->createTempDir() . '/example.txt';

    $result = civicrm_api('Setting', 'create', array(
      'version' => 3,
      'verifySSL' => TRUE,
    ));
    $this->assertAPISuccess($result);
    $this->client = new CRM_Utils_HttpClient();
  }

  public function tearDown() {
    CRM_Core_DAO::executeQuery("DELETE FROM civicrm_setting WHERE name = 'verifySSL'");
    CRM_Core_Config::singleton(TRUE);
    parent::tearDown();
  }

  public function testFetchHttp() {
    $result = $this->client->fetch(self::VALID_HTTP_URL, $this->tmpFile);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_OK, $result);
    $this->assertRegExp(self::VALID_HTTP_REGEX, file_get_contents($this->tmpFile));
  }

  public function testFetchHttps_valid() {
    $result = $this->client->fetch(self::VALID_HTTPS_URL, $this->tmpFile);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_OK, $result);
    $this->assertRegExp(self::VALID_HTTPS_REGEX, file_get_contents($this->tmpFile));
  }

  public function testFetchHttps_invalid_verify() {
    $result = $this->client->fetch(self::SELF_SIGNED_HTTPS_URL, $this->tmpFile);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_DL_ERROR, $result);
    $this->assertEquals('', file_get_contents($this->tmpFile));
  }

  public function testFetchHttps_invalid_noVerify() {
    $result = civicrm_api('Setting', 'create', array(
      'version' => 3,
      'verifySSL' => FALSE,
    ));
    $this->assertAPISuccess($result);

    $result = $this->client->fetch(self::SELF_SIGNED_HTTPS_URL, $this->tmpFile);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_OK, $result);
    $this->assertRegExp(self::SELF_SIGNED_HTTPS_REGEX, file_get_contents($this->tmpFile));
  }

  public function testFetchHttp_badOutFile() {
    $result = $this->client->fetch(self::VALID_HTTP_URL, '/ba/d/path/too/utput');
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_WRITE_ERROR, $result);
  }

  public function testGetHttp() {
    list($status, $data) = $this->client->get(self::VALID_HTTP_URL);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_OK, $status);
    $this->assertRegExp(self::VALID_HTTP_REGEX, $data);
  }

  public function testGetHttps_valid() {
    list($status, $data) = $this->client->get(self::VALID_HTTPS_URL);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_OK, $status);
    $this->assertRegExp(self::VALID_HTTPS_REGEX, $data);
  }

  public function testGetHttps_invalid_verify() {
    list($status, $data) = $this->client->get(self::SELF_SIGNED_HTTPS_URL);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_DL_ERROR, $status);
    $this->assertEquals('', $data);
  }

  public function testGetHttps_invalid_noVerify() {
    $result = civicrm_api('Setting', 'create', array(
      'version' => 3,
      'verifySSL' => FALSE,
    ));
    $this->assertAPISuccess($result);

    list($status, $data) = $this->client->get(self::SELF_SIGNED_HTTPS_URL);
    $this->assertEquals(CRM_Utils_HttpClient::STATUS_OK, $status);
    $this->assertRegExp(self::SELF_SIGNED_HTTPS_REGEX, $data);
  }

}
