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
define('CURSCRIPT', 'GFCregister');
require_once './include/common.inc.php';
require_once DISCUZ_ROOT.'./uc_client/client.php';
require_once './plugins/gfc/common.php';
if ($discuz_uid) {
  showmessage('login_succeed', $indexname);
}
if (empty($fcauth)) {
  showmessage('undefined_action');
} else {
  $profile = getGFCProfile($fcauth);
  if (!$profile) {
    showmessage('undefined_action');
  }
  $gfcid = $profile['id'];
  $gfcusername = $profile['displayName'];
  $guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
  $gfcusername = preg_replace("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is",
                            '_', $gfcusername);
  $len = strlen($gfcusername);
  if ($len > 15) {
    $gfcusername = substr($gfcusername, 0, 15);
  }
  if ($len < 3) {
    $gfcusername = $gfcusername . $gfcusername . $gfcusername;
  }
  $gfcemail = '';
  if ($_GET['regsubmit'] == "yes") {
    $username = $_REQUEST['username'];
    $email = $_REQUEST['email'];
    $formhash = $_REQUEST['formhash'];
    $discuz_env = new DiscuzEnv($db, $tablepre, $cookiepre, $regname,
                                DISCUZ_ROOT);
    $discuz_plugin = new GFCPluginDiscuz($discuz_env, $gfcconfig);
    $password = random(16);
    $uid = $discuz_plugin->Register($profile['id'], $username, $password,
                                    $email, $formhash, $onlineip);
    if ($uid > 0) {
      setcookie("gfcsyncprofile",1);
      $discuz_uid = $uid;
      $discuz_userss = $username;
      showmessage('register_succeed', dreferer());
    } else {
      showmessage('profile_username_duplicate');
    }
  } else {
    include template('gfcregister');
  }
}
?>