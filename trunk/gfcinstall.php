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

define('IN_DISCUZ', TRUE);
define('DISCUZ_ROOT', './');

//Install DB table
require_once './include/common.inc.php';
$sql = "CREATE TABLE {$tablepre}gfcmapping (gfcid char(25),
                                            dzid mediumint(8) unsigned,
                                            dzusername char(15),
                                            dzpassword char(32),
                                            thumbnail_url text,
                                            thumbnail_md5 char(32),
                                            bio text,
                                            site char(75))";
$db->query($sql);
echo "Install Sucessfully. And please delete this file [gfcinstall.php]";
?>