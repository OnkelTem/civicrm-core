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
 * Generated from xml/schema/CRM/Member/MembershipStatus.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 */

namespace Civi\Member;

require_once 'Civi/Core/Entity.php';

use Doctrine\ORM\Mapping as ORM;
use Civi\API\Annotation as CiviAPI;
use JMS\Serializer\Annotation as JMS;

/**
 * MembershipStatus
 *
 * @CiviAPI\Entity("MembershipStatus")
 * @CiviAPI\Permission()
 * @ORM\Table(name="civicrm_membership_status")
 * @ORM\Entity
 *
 */
class MembershipStatus extends \Civi\Core\Entity {

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
   * @ORM\Column(name="name", type="string", length=128, nullable=true)
   * 
   * 
   */
  private $name;
  
  /**
   * @var string
   *
   * @JMS\Type("string")
   * @ORM\Column(name="label", type="string", length=128, nullable=true)
   * 
   * 
   */
  private $label;
  
  /**
   * @var string
   *
   * @JMS\Type("string")
   * @ORM\Column(name="start_event", type="string", length=12, nullable=true)
   * 
   * 
   */
  private $startEvent;
  
  /**
   * @var string
   *
   * @JMS\Type("string")
   * @ORM\Column(name="start_event_adjust_unit", type="string", length=8, nullable=true)
   * 
   * 
   */
  private $startEventAdjustUnit;
  
  /**
   * @var integer
   *
   * @JMS\Type("integer")
   * @ORM\Column(name="start_event_adjust_interval", type="integer", nullable=true, options={"unsigned":true})
   * 
   * 
   */
  private $startEventAdjustInterval;
  
  /**
   * @var string
   *
   * @JMS\Type("string")
   * @ORM\Column(name="end_event", type="string", length=12, nullable=true)
   * 
   * 
   */
  private $endEvent;
  
  /**
   * @var string
   *
   * @JMS\Type("string")
   * @ORM\Column(name="end_event_adjust_unit", type="string", length=8, nullable=true)
   * 
   * 
   */
  private $endEventAdjustUnit;
  
  /**
   * @var integer
   *
   * @JMS\Type("integer")
   * @ORM\Column(name="end_event_adjust_interval", type="integer", nullable=true, options={"unsigned":true})
   * 
   * 
   */
  private $endEventAdjustInterval;
  
  /**
   * @var boolean
   *
   * @JMS\Type("boolean")
   * @ORM\Column(name="is_current_member", type="boolean", nullable=true)
   * 
   * 
   */
  private $isCurrentMember;
  
  /**
   * @var boolean
   *
   * @JMS\Type("boolean")
   * @ORM\Column(name="is_admin", type="boolean", nullable=true)
   * 
   * 
   */
  private $isAdmin;
  
  /**
   * @var integer
   *
   * @JMS\Type("integer")
   * @ORM\Column(name="weight", type="integer", nullable=true, options={"unsigned":true})
   * 
   * 
   */
  private $weight;
  
  /**
   * @var boolean
   *
   * @JMS\Type("boolean")
   * @ORM\Column(name="is_default", type="boolean", nullable=true)
   * 
   * 
   */
  private $isDefault;
  
  /**
   * @var boolean
   *
   * @JMS\Type("boolean")
   * @ORM\Column(name="is_active", type="boolean", nullable=false)
   * 
   * 
   */
  private $isActive = '1';
  
  /**
   * @var boolean
   *
   * @JMS\Type("boolean")
   * @ORM\Column(name="is_reserved", type="boolean", nullable=false)
   * 
   * 
   */
  private $isReserved = '0';

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }
    
  /**
   * Set name
   *
   * @param string $name
   * @return MembershipStatus
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }
  
  /**
   * Set label
   *
   * @param string $label
   * @return MembershipStatus
   */
  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  /**
   * Get label
   *
   * @return string
   */
  public function getLabel() {
    return $this->label;
  }
  
  /**
   * Set startEvent
   *
   * @param string $startEvent
   * @return MembershipStatus
   */
  public function setStartEvent($startEvent) {
    $this->startEvent = $startEvent;
    return $this;
  }

  /**
   * Get startEvent
   *
   * @return string
   */
  public function getStartEvent() {
    return $this->startEvent;
  }
  
  /**
   * Set startEventAdjustUnit
   *
   * @param string $startEventAdjustUnit
   * @return MembershipStatus
   */
  public function setStartEventAdjustUnit($startEventAdjustUnit) {
    $this->startEventAdjustUnit = $startEventAdjustUnit;
    return $this;
  }

  /**
   * Get startEventAdjustUnit
   *
   * @return string
   */
  public function getStartEventAdjustUnit() {
    return $this->startEventAdjustUnit;
  }
  
  /**
   * Set startEventAdjustInterval
   *
   * @param integer $startEventAdjustInterval
   * @return MembershipStatus
   */
  public function setStartEventAdjustInterval($startEventAdjustInterval) {
    $this->startEventAdjustInterval = $startEventAdjustInterval;
    return $this;
  }

  /**
   * Get startEventAdjustInterval
   *
   * @return integer
   */
  public function getStartEventAdjustInterval() {
    return $this->startEventAdjustInterval;
  }
  
  /**
   * Set endEvent
   *
   * @param string $endEvent
   * @return MembershipStatus
   */
  public function setEndEvent($endEvent) {
    $this->endEvent = $endEvent;
    return $this;
  }

  /**
   * Get endEvent
   *
   * @return string
   */
  public function getEndEvent() {
    return $this->endEvent;
  }
  
  /**
   * Set endEventAdjustUnit
   *
   * @param string $endEventAdjustUnit
   * @return MembershipStatus
   */
  public function setEndEventAdjustUnit($endEventAdjustUnit) {
    $this->endEventAdjustUnit = $endEventAdjustUnit;
    return $this;
  }

  /**
   * Get endEventAdjustUnit
   *
   * @return string
   */
  public function getEndEventAdjustUnit() {
    return $this->endEventAdjustUnit;
  }
  
  /**
   * Set endEventAdjustInterval
   *
   * @param integer $endEventAdjustInterval
   * @return MembershipStatus
   */
  public function setEndEventAdjustInterval($endEventAdjustInterval) {
    $this->endEventAdjustInterval = $endEventAdjustInterval;
    return $this;
  }

  /**
   * Get endEventAdjustInterval
   *
   * @return integer
   */
  public function getEndEventAdjustInterval() {
    return $this->endEventAdjustInterval;
  }
  
  /**
   * Set isCurrentMember
   *
   * @param boolean $isCurrentMember
   * @return MembershipStatus
   */
  public function setIsCurrentMember($isCurrentMember) {
    $this->isCurrentMember = $isCurrentMember;
    return $this;
  }

  /**
   * Get isCurrentMember
   *
   * @return boolean
   */
  public function getIsCurrentMember() {
    return $this->isCurrentMember;
  }
  
  /**
   * Set isAdmin
   *
   * @param boolean $isAdmin
   * @return MembershipStatus
   */
  public function setIsAdmin($isAdmin) {
    $this->isAdmin = $isAdmin;
    return $this;
  }

  /**
   * Get isAdmin
   *
   * @return boolean
   */
  public function getIsAdmin() {
    return $this->isAdmin;
  }
  
  /**
   * Set weight
   *
   * @param integer $weight
   * @return MembershipStatus
   */
  public function setWeight($weight) {
    $this->weight = $weight;
    return $this;
  }

  /**
   * Get weight
   *
   * @return integer
   */
  public function getWeight() {
    return $this->weight;
  }
  
  /**
   * Set isDefault
   *
   * @param boolean $isDefault
   * @return MembershipStatus
   */
  public function setIsDefault($isDefault) {
    $this->isDefault = $isDefault;
    return $this;
  }

  /**
   * Get isDefault
   *
   * @return boolean
   */
  public function getIsDefault() {
    return $this->isDefault;
  }
  
  /**
   * Set isActive
   *
   * @param boolean $isActive
   * @return MembershipStatus
   */
  public function setIsActive($isActive) {
    $this->isActive = $isActive;
    return $this;
  }

  /**
   * Get isActive
   *
   * @return boolean
   */
  public function getIsActive() {
    return $this->isActive;
  }
  
  /**
   * Set isReserved
   *
   * @param boolean $isReserved
   * @return MembershipStatus
   */
  public function setIsReserved($isReserved) {
    $this->isReserved = $isReserved;
    return $this;
  }

  /**
   * Get isReserved
   *
   * @return boolean
   */
  public function getIsReserved() {
    return $this->isReserved;
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
      
              'membership_status' => array(
      
        'name' => 'name',
        'propertyName' => 'name',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('Membership Status'),
                                 'maxlength' => 128,
                         'size' => \CRM_Utils_Type::HUGE,
                           
                'import' => true,
        'where' => 'civicrm_membership_status.name',
        'headerPattern' => '',
        'dataPattern' => '',
                         'export' => true,
                                   
                          ),
      
              'label' => array(
      
        'name' => 'label',
        'propertyName' => 'label',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('Label'),
                                 'maxlength' => 128,
                         'size' => \CRM_Utils_Type::HUGE,
                           
                                    
                          ),
      
              'start_event' => array(
      
        'name' => 'start_event',
        'propertyName' => 'startEvent',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('Start Event'),
                                 'maxlength' => 12,
                         'size' => \CRM_Utils_Type::TWELVE,
                           
                                    
                                     'pseudoconstant' => array(
                                '0' => 'not in database',
                    )
                 ),
      
              'start_event_adjust_unit' => array(
      
        'name' => 'start_event_adjust_unit',
        'propertyName' => 'startEventAdjustUnit',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('Start Event Adjust Unit'),
                                 'maxlength' => 8,
                         'size' => \CRM_Utils_Type::EIGHT,
                           
                                    
                                     'pseudoconstant' => array(
                                '0' => 'not in database',
                    )
                 ),
      
              'start_event_adjust_interval' => array(
      
        'name' => 'start_event_adjust_interval',
        'propertyName' => 'startEventAdjustInterval',
        'type' => \CRM_Utils_Type::T_INT,
                'title' => ts('Start Event Adjust Interval'),
                                                     
                                    
                          ),
      
              'end_event' => array(
      
        'name' => 'end_event',
        'propertyName' => 'endEvent',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('End Event'),
                                 'maxlength' => 12,
                         'size' => \CRM_Utils_Type::TWELVE,
                           
                                    
                                     'pseudoconstant' => array(
                                '0' => 'not in database',
                    )
                 ),
      
              'end_event_adjust_unit' => array(
      
        'name' => 'end_event_adjust_unit',
        'propertyName' => 'endEventAdjustUnit',
        'type' => \CRM_Utils_Type::T_STRING,
                'title' => ts('End Event Adjust Unit'),
                                 'maxlength' => 8,
                         'size' => \CRM_Utils_Type::EIGHT,
                           
                                    
                                     'pseudoconstant' => array(
                                '0' => 'not in database',
                    )
                 ),
      
              'end_event_adjust_interval' => array(
      
        'name' => 'end_event_adjust_interval',
        'propertyName' => 'endEventAdjustInterval',
        'type' => \CRM_Utils_Type::T_INT,
                'title' => ts('End Event Adjust Interval'),
                                                     
                                    
                          ),
      
              'is_current_member' => array(
      
        'name' => 'is_current_member',
        'propertyName' => 'isCurrentMember',
        'type' => \CRM_Utils_Type::T_BOOLEAN,
                'title' => ts('Current Membership?'),
                                                     
                                    
                          ),
      
              'is_admin' => array(
      
        'name' => 'is_admin',
        'propertyName' => 'isAdmin',
        'type' => \CRM_Utils_Type::T_BOOLEAN,
                'title' => ts('Admin Assigned Only?'),
                                                     
                                    
                          ),
      
              'weight' => array(
      
        'name' => 'weight',
        'propertyName' => 'weight',
        'type' => \CRM_Utils_Type::T_INT,
                'title' => ts('Weight'),
                                                     
                                    
                          ),
      
              'is_default' => array(
      
        'name' => 'is_default',
        'propertyName' => 'isDefault',
        'type' => \CRM_Utils_Type::T_BOOLEAN,
                'title' => ts('Default Status?'),
                                                     
                                    
                          ),
      
              'is_active' => array(
      
        'name' => 'is_active',
        'propertyName' => 'isActive',
        'type' => \CRM_Utils_Type::T_BOOLEAN,
                'title' => ts('Is Active'),
                                                     
                                           'default' => '1',
         
                          ),
      
              'is_reserved' => array(
      
        'name' => 'is_reserved',
        'propertyName' => 'isReserved',
        'type' => \CRM_Utils_Type::T_BOOLEAN,
                'title' => ts('Is Reserved'),
                                                     
                                    
                          ),
             );
    }
    return self::$_fields;
  }

}
