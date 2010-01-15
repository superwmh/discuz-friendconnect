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

if(!defined('CURSCRIPT')) {
  exit('Access Denied');
}
require_once dirname(__FILE__).'/config.inc.php';
require_once dirname(__FILE__).'/global.func.php';
require_once dirname(__FILE__).'/discuz.class.php';
require_once dirname(__FILE__).'/plugin.class.php';
$fcauthid = 'fcauth'.$gfcconfig['siteid'];
$fcauth = $_COOKIE[$fcauthid];
if ($charset == "utf-8") {
  require_once dirname(__FILE__).'/message.utf8.php';
} else if ($charset == "gbk") {
  require_once dirname(__FILE__).'/message.gbk.php';
} else if ($charset == "big5") {
  require_once dirname(__FILE__).'/message.big5.php';
} else {
  require_once dirname(__FILE__).'/message.php';
}
?>