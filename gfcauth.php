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
define('CURSCRIPT', 'GFCauth');
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
  $discuz_env = new DiscuzEnv($db, $tablepre, $cookiepre, $regname,
                              DISCUZ_ROOT);
  $discuz_plugin = new GFCPluginDiscuz($discuz_env, $gfcconfig);
  $uid = $discuz_plugin->Login($gfcid, $discuz_userss);
  $referer = $_GET["referer"];
  if (empty($referer)) {
    $referer = dreferer();
  }
  if ($uid > 0) {
    setcookie("gfcupdateprofilepre", 1);
    $discuz_uid = $uid;
    showmessage('login_succeed', $referer);
  } else {
    showmessage('login_invalid', $referer);
  }
}
?>