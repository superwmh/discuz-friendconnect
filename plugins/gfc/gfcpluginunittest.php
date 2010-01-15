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

require_once 'PHPUnit/Framework.php';
require_once 'plugin.class.php';
require_once 'discuz_env_mock.php';

class gfcpluginunittest  extends PHPUnit_Framework_TestCase {

  protected $gfcconfig;
  protected $discuz_plugin;
  
  protected function setUp() {
    $this->gfcconfig = array();
    $discuz_env=new MockDiscuzEnv();
    $this->discuz_plugin = new GFCPluginDiscuz($discuz_env, $this->gfcconfig);
  }

  private function createProfile() {
    $profile = array();
    $profile['id'] = "123456789";
    $profile['displayName'] = "newuser";
    $profile['thumbnailUrl'] = "http://pic/";
    $profile['aboutMe'] = "unit test";
    $profile['urls'] = array("1" => array(
                                   "type" => "externalProfile",
                                   "value" => "http://profile"
                                   )
                            );
    return $profile;
  }
  
  public function testCheckUsername() {
    $username = "admin";
    $r = $this->discuz_plugin->IsUserNameAvailable($username);
    $this->assertFalse($r);
    $username = "notexist";
    $r = $this->discuz_plugin->IsUserNameAvailable($username);
    $this->assertTrue($r);
  }
  
  public function testGFCRegister() {
    $gfcid = "123456789";
    $username = "NewUser";
    $password = "password";
    $email = "";
    $formhash = "hash";
    $regip = "";
    $r = $this->discuz_plugin->IsUserNameAvailable($username);
    $this->assertTrue($r);
    $r = $this->discuz_plugin->IsGFCidRegistered($gfcid);
    $this->assertFalse($r);
    $r = $this->discuz_plugin->Register($gfcid, $username, $password, $email, $formhash, $regip);
    $this->assertTrue($r > 0);
    $r = $this->discuz_plugin->IsUserNameAvailable($username);
    $this->assertFalse($r);
    $r = $this->discuz_plugin->IsGFCidRegistered($gfcid);
    $this->assertTrue($r);
    $r = $this->discuz_plugin->Register($gfcid, $username, $password, $email, $formhash, $regip);
    $this->assertFalse($r > 0);
  }
   
  public function testGFCLogin() {
    $gfcid = "123456789";
    $username = "NewUser";
    $password = "password";
    $display = "";
    $email = "";
    $formhash = "";
    $regip = "";
    $r = $this->discuz_plugin->Login($gfcid, $display);
    $this->assertFalse($r > 0);
    $r = $this->discuz_plugin->Register($gfcid, $username, $password, $email, $formhash, $regip);
    $r = $this->discuz_plugin->Login($gfcid, $display);
    $this->assertTrue($r > 0);
    $this->assertEquals($username, $display);
    
  }
  
  public function testProfileCheck() {
    $gfcid = "123456789";
    $username = "NewUser";
    $password = "password";
    $display = "";
    $email = "";
    $formhash = "";
    $regip = "";
    $r = $this->discuz_plugin->Register($gfcid, $username, $password, $email, $formhash, $regip);
    $profile = $this->createProfile();
    $change = array();
    $level = $this->discuz_plugin->CheckProfile($profile, $change);
    $this->assertEquals($level, 7);
    $this->assertEquals($change['thum_url_after'], $profile["thumbnailUrl"]);
    $this->assertEquals($change['bio_after'], $profile["aboutMe"]);
  }
  
  public function testProfileUpdate() {    
    $gfcid = "123456789";
    $username = "NewUser";
    $password = "password";
    $display = "";
    $email = "";
    $formhash = "";
    $regip = "";
    $uid = $this->discuz_plugin->Register($gfcid, $username, $password, $email, $formhash, $regip);
    $profile = $this->createProfile();
    $change = array();
    $level = $this->discuz_plugin->CheckProfile($profile, $change);
    $this->assertEquals($level, 7);
    $this->discuz_plugin->SyncUserProfile($profile, $uid, $level);
    $level = $this->discuz_plugin->CheckProfile($profile, $change);
    $this->assertEquals($level, 0);
  }
}
?>