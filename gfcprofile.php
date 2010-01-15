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
define('CURSCRIPT', 'gfcprofile');
require_once './include/common.inc.php';
require_once DISCUZ_ROOT.'./uc_client/client.php';
require_once './plugins/gfc/common.php';
if (empty($fcauth)) {
  echo "ERROR";
}
$discuz_env = new DiscuzEnv($db, $tablepre, $cookiepre, $regname, DISCUZ_ROOT);
$discuz_plugin = new GFCPluginDiscuz($discuz_env, $gfcconfig);
$profile = getGFCProfile($fcauth);
if (!$profile) {
  echo "ERROR";
}
if ($_REQUEST['action'] == "update") {
  $update_level = 0;
  if ($_REQUEST['profilethumbnail'] == "1") {
    $update_level = $update_level | 1;
  }
  if ($_REQUEST['profilebio'] == "1") {
    $update_level = $update_level | 2;
  }
  if ($_REQUEST['profileurl'] == "1") {
    $update_level = $update_level | 4;
  }
  $uid = $discuz_uid;
  $discuz_plugin->SyncUserProfile($profile, $uid, $update_level);
  echo "1";
} else if ($_REQUEST['action'] == "ajaxupdate") {
   $uid = $discuz_uid;
   $discuz_plugin->SyncUserProfile($profile, $uid, 1|2|4);
   echo "1";
} else {
  $change = array();
  $profilestatus = $discuz_plugin->CheckProfile($profile, $change);
  extract($change);
  include template('gfcprofile');
}
?>