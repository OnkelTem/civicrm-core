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
 * @copyright CiviCRM LLC (c) 2004-2014
 * $Id$
 *
 */

/**
 * Drupal specific stuff goes here
 */
abstract class CRM_Utils_System_DrupalBase extends CRM_Utils_System_Base {

  /**
   * Does this CMS / UF support a CMS specific logging mechanism?
   * @todo - we should think about offering up logging mechanisms in a way that is also extensible by extensions
   * @var bool
   */
  var $supports_UF_Logging = TRUE;
  /**
   *
   */
  public function __construct() {
    /**
     * deprecated property to check if this is a drupal install. The correct method is to have functions on the UF classes for all UF specific
     * functions and leave the codebase oblivious to the type of CMS
     * @deprecated
     * @var bool
     */
    $this->is_drupal = TRUE;
    $this->supports_form_extensions = TRUE;
  }

  /**
   * @param string dir base civicrm directory
   * Return default Site Settings
   * @return array array
   * - $url, (Joomla - non admin url)
   * - $siteName,
   * - $siteRoot
   */
  public function getDefaultSiteSettings($dir) {
    $config = CRM_Core_Config::singleton();
    $siteName = $siteRoot = NULL;
    $matches = array();
    if (preg_match(
      '|/sites/([\w\.\-\_]+)/|',
      $config->templateCompileDir,
      $matches
    )) {
      $siteName = $matches[1];
      if ($siteName) {
        $siteName = "/sites/$siteName/";
        $siteNamePos = strpos($dir, $siteName);
        if ($siteNamePos !== FALSE) {
          $siteRoot = substr($dir, 0, $siteNamePos);
        }
      }
    }
    $url = $config->userFrameworkBaseURL;
    return array($url, $siteName, $siteRoot);
  }

  /**
   * Check if a resource url is within the drupal directory and format appropriately
   *
   * @param url (reference)
   *
   * @return bool: TRUE for internal paths, FALSE for external. The drupal_add_js fn is able to add js more
   * efficiently if it is known to be in the drupal site
   */
  public function formatResourceUrl(&$url) {
    $internal = FALSE;
    $base = CRM_Core_Config::singleton()->resourceBase;
    global $base_url;
    // Handle absolute urls
    // compares $url (which is some unknown/untrusted value from a third-party dev) to the CMS's base url (which is independent of civi's url)
    // to see if the url is within our drupal dir, if it is we are able to treated it as an internal url
    if (strpos($url, $base_url) === 0) {
      $internal = TRUE;
      $url = trim(str_replace($base_url, '', $url), '/');
    }
    // Handle relative urls that are within the CiviCRM module directory
    elseif (strpos($url, $base) === 0) {
      $internal = TRUE;
      $url = $this->appendCoreDirectoryToResourceBase(substr(drupal_get_path('module', 'civicrm'), 0, -6)) . trim(substr($url, strlen($base)), '/');
    }
    // Strip query string
    $q = strpos($url, '?');
    if ($q && $internal) {
      $url = substr($url, 0, $q);
    }
    return $internal;
  }

  /**
   * In instance where civicrm folder has a drupal folder & a civicrm core folder @ the same level append the
   * civicrm folder name to the url
   * See CRM-13737 for discussion of how this allows implementers to alter the folder structure
   * @todo - this only provides a limited amount of flexiblity - it still expects a 'civicrm' folder with a 'drupal' folder
   * and is only flexible as to the name of the civicrm folder.
   *
   * @param string $url
   *   Potential resource url based on standard folder assumptions.
   * @return string $url with civicrm-core directory appended if not standard civi dir
   */
  public function appendCoreDirectoryToResourceBase($url) {
    global $civicrm_root;
    $lastDirectory = basename($civicrm_root);
    if ($lastDirectory != 'civicrm') {
      return $url .= $lastDirectory . '/';
    }
    return $url;
  }

  /**
   * Generate an internal CiviCRM URL (copied from DRUPAL/includes/common.inc#url)
   *
   * @param $path
   *   String The path being linked to, such as "civicrm/add".
   * @param $query
   *   String A query string to append to the link.
   * @param $absolute
   *   Boolean Whether to force the output to be an absolute link (beginning with http:).
   *                           Useful for links that will be displayed outside the site, such as in an
   *                           RSS feed.
   * @param $fragment
   *   String A fragment identifier (named anchor) to append to the link.
   * @param $htmlize
   *   Boolean whether to convert to html eqivalant.
   * @param $frontend
   *   Boolean a gross joomla hack.
   * @param $forceBackend
   *   Boolean a gross joomla hack.
   *
   * @return string an HTML string containing a link to the given path.
   *
   */
  function url(
    $path = NULL, $query = NULL, $absolute = FALSE,
    $fragment = NULL, $htmlize = TRUE,
    $frontend = FALSE, $forceBackend = FALSE
  ) {
    $config = CRM_Core_Config::singleton();
    $script = 'index.php';

    $path = CRM_Utils_String::stripPathChars($path);

    if (isset($fragment)) {
      $fragment = '#' . $fragment;
    }

    if (!isset($config->useFrameworkRelativeBase)) {
      $base = parse_url($config->userFrameworkBaseURL);
      $config->useFrameworkRelativeBase = $base['path'];
    }
    $base = $absolute ? $config->userFrameworkBaseURL : $config->useFrameworkRelativeBase;

    $separator = $htmlize ? '&amp;' : '&';

    if (!$config->cleanURL) {
      if (isset($path)) {
        if (isset($query)) {
          return $base . $script . '?q=' . $path . $separator . $query . $fragment;
        }
        else {
          return $base . $script . '?q=' . $path . $fragment;
        }
      }
      else {
        if (isset($query)) {
          return $base . $script . '?' . $query . $fragment;
        }
        else {
          return $base . $fragment;
        }
      }
    }
    else {
      if (isset($path)) {
        if (isset($query)) {
          return $base . $path . '?' . $query . $fragment;
        }
        else {
          return $base . $path . $fragment;
        }
      }
      else {
        if (isset($query)) {
          return $base . $script . '?' . $query . $fragment;
        }
        else {
          return $base . $fragment;
        }
      }
    }
  }

  /**
   * Get User ID from UserFramework system (Drupal)
   * @param object $user
   *   Object as described by the CMS.
   * @return mixed <NULL, number>
   */
  public function getUserIDFromUserObject($user) {
    return !empty($user->uid) ? $user->uid : NULL;
  }

  /**
   * Get Unique Identifier from UserFramework system (CMS)
   * @param object $user
   *   Object as described by the User Framework.
   * @return mixed $uniqueIdentifer Unique identifier from the user Framework system
   *
   */
  public function getUniqueIdentifierFromUserObject($user) {
    return empty($user->mail) ? NULL : $user->mail;
  }

  /**
   * Get currently logged in user unique identifier - this tends to be the email address or user name.
   *
   * @return string $userID logged in user unique identifier
   */
  public function getLoggedInUniqueIdentifier() {
    global $user;
    return $this->getUniqueIdentifierFromUserObject($user);
  }

  /**
   * Action to take when access is not permitted
   */
  public function permissionDenied() {
    drupal_access_denied();
  }

  /**
   * Get Url to view user record
   * @param int $contactID
   *   Contact ID.
   *
   * @return string
   */
  public function getUserRecordUrl($contactID) {
    $uid = CRM_Core_BAO_UFMatch::getUFId($contactID);
    if (CRM_Core_Session::singleton()->get('userID') == $contactID || CRM_Core_Permission::checkAnyPerm(array('cms:administer users', 'cms:view user account'))) {
      return CRM_Utils_System::url('user/' . $uid);
    };
  }

  /**
   * Is the current user permitted to add a user
   * @return bool
   */
  public function checkPermissionAddUser() {
    if (CRM_Core_Permission::check('administer users')) {
      return TRUE;
    }
  }


  /**
   * Log error to CMS
   */
  public function logger($message) {
    if (CRM_Core_Config::singleton()->userFrameworkLogging) {
      watchdog('civicrm', $message, NULL, WATCHDOG_DEBUG);
    }
  }

  /**
   * Flush css/js caches
   */
  public function clearResourceCache() {
    _drupal_flush_css_js();
  }

  /**
   * Append to coreResourcesList
   */
  public function appendCoreResources(&$list) {
    $list[] = 'js/crm.drupal.js';
  }

  /**
   * Reset any system caches that may be required for proper CiviCRM
   * integration.
   */
  public function flush() {
    drupal_flush_all_caches();
  }

  /**
   * Get a list of all installed modules, including enabled and disabled ones
   *
   * @return array CRM_Core_Module
   *
   */
  public function getModules() {
    $result = array();
    $q = db_query('SELECT name, status FROM {system} WHERE type = \'module\' AND schema_version <> -1');
    foreach ($q as $row) {
      $result[] = new CRM_Core_Module('drupal.' . $row->name, ($row->status == 1) ? TRUE : FALSE);
    }
    return $result;
  }

  /**
   * Find any users/roles/security-principals with the given permission
   * and replace it with one or more permissions.
   *
   * @param $oldPerm
   *   String.
   * @param $newPerms
   *   Array, strings.
   *
   * @return void
   */
  public function replacePermission($oldPerm, $newPerms) {
    $roles = user_roles(FALSE, $oldPerm);
    if (!empty($roles)) {
      foreach (array_keys($roles) as $rid) {
        user_role_revoke_permissions($rid, array($oldPerm));
        user_role_grant_permissions($rid, $newPerms);
      }
    }
  }
  /**
   * Format the url as per language Negotiation.
   *
   * @param string $url
   *
   * @return string $url, formatted url.
   * @static
   */
  public function languageNegotiationURL($url, $addLanguagePart = TRUE, $removeLanguagePart = FALSE) {
    if (empty($url)) {
      return $url;
    }

    //CRM-7803 -from d7 onward.
    $config = CRM_Core_Config::singleton();
    if (function_exists('variable_get') &&
      module_exists('locale') &&
      function_exists('language_negotiation_get')
    ) {
      global $language;

      //does user configuration allow language
      //support from the URL (Path prefix or domain)
      if (language_negotiation_get('language') == 'locale-url') {
        $urlType = variable_get('locale_language_negotiation_url_part');

        //url prefix
        if ($urlType == LOCALE_LANGUAGE_NEGOTIATION_URL_PREFIX) {
          if (isset($language->prefix) && $language->prefix) {
            if ($addLanguagePart) {
              $url .= $language->prefix . '/';
            }
            if ($removeLanguagePart) {
              $url = str_replace("/{$language->prefix}/", '/', $url);
            }
          }
        }
        //domain
        if ($urlType == LOCALE_LANGUAGE_NEGOTIATION_URL_DOMAIN) {
          if (isset($language->domain) && $language->domain) {
            if ($addLanguagePart) {
              $url = (CRM_Utils_System::isSSL() ? 'https' : 'http') . '://' . $language->domain . base_path();
            }
            if ($removeLanguagePart && defined('CIVICRM_UF_BASEURL')) {
              $url = str_replace('\\', '/', $url);
              $parseUrl = parse_url($url);

              //kinda hackish but not sure how to do it right
              //hope http_build_url() will help at some point.
              if (is_array($parseUrl) && !empty($parseUrl)) {
                $urlParts           = explode('/', $url);
                $hostKey            = array_search($parseUrl['host'], $urlParts);
                $ufUrlParts         = parse_url(CIVICRM_UF_BASEURL);
                $urlParts[$hostKey] = $ufUrlParts['host'];
                $url                = implode('/', $urlParts);
              }
            }
          }
        }
      }
    }
    return $url;
  }

  /**
   * GET CMS Version
   * @return string
   */
  public function getVersion() {
    return defined('VERSION') ? VERSION : 'Unknown';
  }

  /**
   */
  public function updateCategories() {
    // copied this from profile.module. Seems a bit inefficient, but i dont know a better way
    // CRM-3600
    cache_clear_all();
    menu_rebuild();
  }

  /**
   * Get the locale set in the hosting CMS
   *
   * @return string  with the locale or null for none
   *
   */
  public function getUFLocale() {
    // return CiviCRM’s xx_YY locale that either matches Drupal’s Chinese locale
    // (for CRM-6281), Drupal’s xx_YY or is retrieved based on Drupal’s xx
    // sometimes for CLI based on order called, this might not be set and/or empty
    global $language;

    if (empty($language)) {
      return NULL;
    }

    if ($language->language == 'zh-hans') {
      return 'zh_CN';
    }

    if ($language->language == 'zh-hant') {
      return 'zh_TW';
    }

    if (preg_match('/^.._..$/', $language->language)) {
      return $language->language;
    }

    return CRM_Core_I18n_PseudoConstant::longForShort(substr($language->language, 0, 2));
  }
  /**
   * Perform any post login activities required by the UF -
   * e.g. for drupal: records a watchdog message about the new session, saves the login timestamp,
   * calls hook_user op 'login' and generates a new session.
   *
   * @param array params
   *
   * FIXME: Document values accepted/required by $params
   *
   */
  public function userLoginFinalize($params = array()) {
    user_login_finalize($params);
  }

  /**
   * Figure out the post url for the form
   *
   * @param mix $action
   *   The default action if one is pre-specified.
   *
   * @return string the url to post the form
   */
  public function postURL($action) {
    if (!empty($action)) {
      return $action;
    }
    return $this->url($_GET['q']);
  }
}
