<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.4                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
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
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 *
 * Generated from xml/schema/CRM/Mailing/TrackableURL.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 */

namespace Civi\Mailing;

require_once 'Civi/Core/Entity.php';

use Doctrine\ORM\Mapping as ORM;
use Civi\API\Annotation as CiviAPI;
use JMS\Serializer\Annotation as JMS;

/**
 * TrackableURL
 *
 * @CiviAPI\Entity("TrackableURL")
 * @CiviAPI\Permission()
 * @ORM\Table(name="civicrm_mailing_trackable_url", indexes={@ORM\Index(name="FK_civicrm_mailing_trackable_url_mailing_id", columns={"mailing_id"})})
 * @ORM\Entity
 *
 */
class TrackableURL extends \Civi\Core\Entity {

  /**
   * @var integer
   *
   * @JMS\Type("integer")
   * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned":true} )
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;
    
  /**
   * @var string
   *
   * @JMS\Type("string")
   * @ORM\Column(name="url", type="string", length=255, nullable=true)
   * 
   * 
   */
  private $url;
  
  /**
   * @var \Civi\Mailing\Mailing
   *
   * 
   * @ORM\ManyToOne(targetEntity="Civi\Mailing\Mailing")
   * @ORM\JoinColumns({@ORM\JoinColumn(name="mailing_id", referencedColumnName="id", onDelete="CASCADE")})
   * 
   */
  private $mailing;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }
    
  /**
   * Set url
   *
   * @param string $url
   * @return TrackableURL
   */
  public function setUrl($url) {
    $this->url = $url;
    return $this;
  }

  /**
   * Get url
   *
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }
  
  /**
   * Set mailing
   *
   * @param \Civi\Mailing\Mailing $mailing
   * @return TrackableURL
   */
  public function setMailing(\Civi\Mailing\Mailing $mailing = null) {
    $this->mailing = $mailing;
    return $this;
  }

  /**
   * Get mailing
   *
   * @return \Civi\Mailing\Mailing
   */
  public function getMailing() {
    return $this->mailing;
  }

  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  public static $_fields = NULL;

  static function &fields( ) {
    if ( !self::$_fields) {
      self::$_fields = array (
      
              'id' => array(
      
        'name' => 'id',
        'propertyName' => 'id',
        'type' => \CRM_Utils_Type::T_INT,
                        'required' => true,
                                             
                                    
                          ),
      
              'url' => array(
      
        'name' => 'url',
        'propertyName' => 'url',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('Url'),
                        'required' => true,
                         'maxlength' => 255,
                         'size' => \CRM_Utils_Type::HUGE,
                           
                                    
                          ),
      
              'mailing_id' => array(
      
        'name' => 'mailing_id',
        'propertyName' => 'mailing',
        'type' => \CRM_Utils_Type::T_INT,
                        'required' => true,
                                             
                                    
                'FKClassName' => 'Civi_Mailing_Mailing',
                          ),
             );
    }
    return self::$_fields;
  }

}
