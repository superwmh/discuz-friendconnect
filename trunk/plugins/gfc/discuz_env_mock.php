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

class User {
  /**
   * constructor of Discuz! user.
   * @param $gid: GFC id
   * @param $username: Discuz! username
   * @param $passwd: Discuz! password
   * */
  public function __construct($gid, $username, $passwd) {
    $this->uid = $gid;
    $this->username = $username;
    $this->password = $passwd;
    $this->thumbnail = '';
    $this->bio = '';
    $this->aboutme = '';
  }
  public $uid;
  public $username;
  public $password;
  public $thumbnail;
  public $bio;
  public $aboutme;
}

function createMapping($gid, $uid, $username, $passwd, $url = '', $bio = '', $site = '') {
  $m = array();
  $m['gfcid'] = $gid;
  $m['dzid'] = $uid; 
  $m['dzusername'] = $username;
  $m['dzpassword'] = $passwd;
  $m['thumbnail_url'] = $url;
  $m['bio'] = $bio;
  $m['site'] = $site;
  $m['thumbnail_md5'] = $url;
  return $m;
}

class MockDiscuzEnv {
  /**
   * constructor of the MockDiscuzEnv class.
   * Add some user manually
   * */
  public function __construct() {
    $this->users = array();
    $u = new User(1, "admin", "admin");
    $this->users[] = $u;
    $u = new User(2, "sys", "sys");
    $this->users[] = $u;
    $u = new User(3, "user", "user");
    $this->users[] = $u;
    $this->mapping = array();
  }
  
  /**
   * Fake register.
   * @param $username: a username
   * @param $password: a password
   * @param $email: a email address
   * @param $formhash: not used
   * @param $regip: not used
   * @return the discuz_uid of the new registered user
   * */
  public function Register($gfcconfig, $username, $password, $email,
                           $formhash, $regip) {
    if ($this->CheckUsernameExist($username)) {
      return 0;
    }
    if (!$this->CheckUsernameValid($username)) {
      return 0;
    }
    $size = count($this->users) + 1;
    $u = new User($size, $username, $password);
    $this->users[] = $u;
    return $size;
  }

  /**
   * Fake login, check whether username and password match.
   * @param $username: A registered username
   * @param $password: The password of the $username
   * @return true if login sucefully. false if login failed
   */  
  public function Login($gfcconfig, $username, $password) {
    $users = $this->users;
    foreach ($users as $u) {
      if ($u->username == $username && $u->password == $password) {
        return $u->uid;
      }
    }
    return 0;
  }

  /**
   * Update the thumbnail of a user.
   * @param $uid: the discuz_uid
   * @param $thumbnail: the url of thumbnail 
   */  
  public function UpdateThumbnail($uid, $thumbnail) {
    $users = $this->users;
    foreach ($users as $k => $u) {
      if ($u->uid == $uid) {
        $this->users[$k]->thumbnail = $thumbnail;
      }
    }
  }

  /**
   * Update Disucz user profile.
   * @param $uid: uid of the user to be updated
   * @param $level: the fields to be updated
   * @param $about_me: the bio of user
   * @param $site:  the site of user
   */  
  public function UpdateProfile($uid, $level, $about_me, $site) {
    $users = $this->users;
    foreach ($users as $k => $u) {
      if ($u->uid == $uid) {
        if ($level & 2) {
          $this->users[$k]->bio = $about_me;
        }
        if ($level & 4) {
          $this->users[$k]->site = $site;
        }
      }
    }
  }
  
  /**
   * Check whether the given username exists.
   * @param $username: a username
   * @return true if the username exists; false if it does not exist.
   * */  
  public function CheckUsernameExist($username) {
    $users = $this->users;
    foreach ($users as $u) {
      if ($u->username == $username) {
        return true;
      }
    }
    return false;
  }
  
  /**
   * Check whether the given username is legal.
   * @param $username: a username
   * @return true if the username is legal; false otherwise.
   * */  
  public function CheckUsernameValid($username) {
    return true;
  }

  /**
   * Set a GFC-Discuz! mapping.
   * @param $gfcid : id on GFC
   * @param $uid: id on Discuz!
   * @param $username: username on Discuz!
   * @param $password: password on Discuz!
   * */  
  public function SetGFCMapping($gfcid, $uid, $username, $password) {
    $m = createMapping($gfcid, $uid, $username, $password);
    $this->mapping[] = $m;
  }

  /**
   * Get a GFC-Discuz! mapping.
   * @param $gfcid : id on GFC
   * @return an array which is a mapping
   * */  
  public function GetGFCMapping($gfcid) {
    foreach ($this->mapping as $m) {
      if ($m["gfcid"] == $gfcid) {
        return $m;
      }
    }
  }

  /**
   * Update a GFC-Discuz! mapping.
   * @param $gfcid : id on GFC
   * @param $site : personal info field of Discuz!
   * @param $about_me : personal info field of Discuz!
   * @param $thumbnail : personal info field of Discuz!
   * */  
  public function UpdateGFCMapping($gfcid, $site, $about_me, $thumbnail) {
      foreach ($this->mapping as $k => $m) {
      if ($m["gfcid"] == $gfcid) {
        $this->mapping[$k]["site"] = $site;
        $this->mapping[$k]["thumbnail_url"] = $thumbnail;
        $this->mapping[$k]['bio'] = $about_me;
      }
    }    
  }

  /**
   * Delete a GFC-Discuz! mapping.
   * @param $gfcid : id on GFC
   * */  
  public function DeleteGFCMapping($gfcid) {
      foreach ($this->mapping as $k => $m) {
      if ($m["gfcid"] == $gfcid) {
        unset($k);
      }
    }
  }

  /**
   * Get the (fake) cheksum of an image, given its url.
   * @param $url : the url of an image
   * @return the url of the image. 
   * */  
  public function Checksum($url) {
    return $url;
  }
  
  public $users;
  public $mapping;
}

?>