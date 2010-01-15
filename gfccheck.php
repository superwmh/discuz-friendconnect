<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

define('NOROBOT', TRUE);
define('CURSCRIPT', 'GFCcheck');
require_once './include/common.inc.php';
require_once DISCUZ_ROOT.'./uc_client/client.php';
require_once './plugins/gfc/common.php';
$discuz_env = new DiscuzEnv($db, $tablepre, $cookiepre, $regname, DISCUZ_ROOT);
$discuz_plugin = new GFCPluginDiscuz($discuz_env, $gfcconfig);
if (empty($fcauth)) {
  echo "ERROR";
} else {
  if ($_REQUEST['action'] == "checkgfcid") {
    $profile = getGFCProfile($fcauth);
    if (!$profile) {
      echo "ERROR : can not get GFC Profile";
    } else {
      $gfcid = $profile['id'];
      if ($discuz_plugin->IsGFCidRegistered($gfcid)) {
        //login
        $ret = "1";
      } else {
        //register
        $ret = "0";
      }
      echo $ret;
    }
  } else if ($_REQUEST['action'] == "checkusername") {
    $username = $_REQUEST["username"];
    if ($discuz_plugin->IsUsernameAvailable($username)) {
      echo "1";
    } else {
      echo "0";
    }
  } else if ($_REQUEST['action'] == "checkprofile") {
    $profile = getGFCProfile($fcauth);
    if (!$profile) {
      echo "ERROR : can not get GFC Profile";
    }
    $change = array();
    if ($discuz_plugin->CheckProfile($profile, $change) > 0) {
      echo "1";
    } else {
      echo "0";
    }
  }
}
?>