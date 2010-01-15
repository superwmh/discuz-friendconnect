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

class GFCPluginDiscuz {
  function __construct($env, $config) {
    $this->discuz_env = $env;
    $this->gfcconfig = $config;
  }
  
  /**
   * Register the GFC user at Discuz!. This includes mapping the GFCid-username
   * registering at Discuz!
   * 
   * @param $gfcid: the id of GFC to be registered
   * @param $username: the username to be registered at Disucz!
   * @param $email:
   * @param $formhash: for HTTP Request
   * @return uid if successful, 0 otherwise
   * */
  public function Register($gfcid, $username, $password,
                           $email, $formhash, $regip) {
    $uid = $this->discuz_env->Register($this->gfcconfig, $username,
                                       $password, $email, $formhash, $regip);
    if ($uid > 0) {
      $this->discuz_env->SetGFCMapping($gfcid, $uid, $username, $password);
      return $uid;
    } else {
      return 0;
    }
  }
  
  /**
   * Login to Discuz!. This includes get the username and password and
   * call Disucz! logging
   * 
   * @param $gfcid: the gfcid of the user
   * @param $discuz_userss: 
   * @return uid if successful, 0 otherwise
   * */
  public function Login($gfcid, &$discuz_userss) {
    $entry = $this->discuz_env->GetGFCMapping($gfcid);
    if (!$entry) {
      return 0;
    }
    $username = $entry['dzusername'];
    $password = $entry['dzpassword'];
    $status = $this->discuz_env->Login($this->gfcconfig, $username, $password);
    if ($status) {
      $discuz_userss = $username;
      return $entry['dzid'];
    } else {
      return 0;
    }
  }
  
  /**
   * Check whether a GFCid is registered
   * 
   * @param $gfcid
   * @return true if it is registered, false otherwise.
   * */
  public function IsGFCidRegistered($gfcid) {
    $entry = $this->discuz_env->GetGFCMapping($gfcid);
    if ($entry) {
      $username = $entry["dzusername"];
      $result = $this->discuz_env->CheckUsernameExist($username);
      if ($result) {
        return true;
      } else {
        $this->discuz_env->DeleteGFCMapping($gfcid);
        return false;
      }
    } else {
      return false;
    }    
  }
  
  /**
   * Check whether a username is available
   * 
   * @param $username: the username to be checked
   * @return true if the username is available. false otherwise
   * */
  public function  IsUserNameAvailable($username) {
    $exist = $this->discuz_env->CheckUsernameExist($username);
    if ($exist) {
      return false;
    }
    $result = $this->discuz_env->CheckUsernameValid($username);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * Check whether a user's GFC profile has been changed since last profile sync
   * 
   * @param $profile
   * @param $uid
   * @return 1 if thumbnail changed. 2 if bio changed. 4 if url changed.
   *         0 if nothing changed.
   **/
  public function CheckProfile($profile, &$change) {
    $ret = 0;
    $gfcid = $profile['id'];
    $entry = $this->discuz_env->GetGFCMapping($gfcid);
    if ($entry) {
      $thumbnail = $profile['thumbnailUrl'];
      $about_me = $profile['aboutMe'];
      $urls = $profile['urls'];
      $site = '';
      if ($urls) {
        foreach ($urls as $url) {
          if ($url['type'] == 'externalProfile') {
            $site = $url['value'];
            break;
          }
        }
      }
      if ($thumbnail && $thumbnail != $entry['thumbnail_url'] ) {
        $md5sum = $this->discuz_env->Checksum($thumbnail);
        if ($md5sum != $entry['thumbnail_md5']) {
          $change['thum_url_before'] = $entry['thumbnail_url'];
          $change['thum_url_after'] = $thumbnail;
          $ret = $ret | 1;
        }
      }
      if ($about_me && $about_me != $entry['bio'] ) {
        $change['bio_before'] = $entry['bio'];
        $change['bio_after'] = $about_me;
        $ret = $ret | 2;
      }
      if ($site && $site != $entry['site'] ) {
        $change['site_before ']= $entry['site'];
        $change['site_after'] = $site;
        $ret = $ret | 4;
      }
    }
    return $ret;    
  }
  
  public function SyncUserProfile($profile, $uid, $level) {
    $gfcid = $profile['id'];
    $thumbnail = $profile['thumbnailUrl'];
    $lvl = 0;
    if (($level & 1) && $thumbnail) { /*thumbnail need update*/
      $entry = $this->discuz_env->GetGFCMapping($gfcid);
      if (!($entry && $entry['thumbnail_url'] == $thumbnail)) {
        $this->discuz_env->UpdateThumbnail($uid, $thumbnail);
      }
    }
    $about_me = $profile['aboutMe'];
    if ($level & 2) {
      $lvl |= 2;
    }
    $urls = $profile['urls'];
    if (($level & 4) && $urls) {
      $lvl |= 4;
      foreach ($urls as $url) {
        if ($url['type'] == 'externalProfile') {
          $site = $url['value'];
          break;
        }
      }
    }
    $this->discuz_env->UpdateProfile($uid, $lvl, $about_me, $site);
    $this->discuz_env->UpdateGFCMapping($gfcid, $site, $about_me, $thumbnail);
  }
  
  private $discuz_env;
  private $gfcconfig;
}
?>