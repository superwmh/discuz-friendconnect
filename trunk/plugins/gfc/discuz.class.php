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

class DiscuzEnv {
  /**
   * constructor of the DiscuzEnv class
   * @param $dbobject: database object, to operate the database
   * @param $tabke_pre: prefix of database table
   * @param $cookie: prefix of cookie
   * @param $regname: the filename of register page
   * @param $root: the Discuz! install directory  
   * */
  function __construct($dbobj, $table_pre, $cookie_pre, $reg_name, $root) {
    $this->db = $dbobj;
    $this->tablepre = $table_pre;
    $this->cookiepre = $cookie_pre;
    $this->regname = $reg_name;
    $this->discuz_root = $root;
  }
  
  /**
   * Check whether the given username exists in the database.
   * @param $username: a username
   * @return true if the username exists; false if it does not exist.
   * */
  public function CheckUsernameExist($username) {
    $db = $this->db;
    $tablepre = $this->tablepre;
    $query = "SELECT uid FROM {$tablepre}members WHERE username='$username'";
    if ($db->fetch_first($query)) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * Check whether the given username is legal(not in the forbidden list).
   * @param $username: a username
   * @return true if the username is legal; false otherwise.
   * */
  public function CheckUsernameValid($username) {
    /* uc_user_checkname is defined as a global function */
    $result = uc_user_checkname($username);
    if ($result > 0) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * Call the Discuz! register.php using HTTP Request and Forward the cookies
   * @param $username: a legal and available username
   * @param $password: a genrated password
   * @param $email: the email address
   * @param $formhash: for HTTP Request
   * @param $regip: the IP address
   * @return the discuz_uid of the new registered user; false if register fail
   * */
  public function Register($gfcconfig, $username, $password, $email,
                           $formhash, $regip) {
    /**
     * In this function, we will update the session stored in database manually
     * This is a hack, not so elegant
     * */
    $db = $this->db;
    $tablepre = $this->tablepre;
    $cookiepre = $this->cookiepre;
    $regname = $this->regname;
    $registerurl = $gfcconfig['sitepath']."$regname?regsubmit=yes&inajax=1";
    $postdata = "formhash={$formhash}&handlekey=register&activationauth=&".
                "username={$username}&password={$password}&".
                "password2={$password}&email={$email}";
    $return = httpgets($registerurl, $postdata);
    if (!$return) {
      return false;
    }
    $content = $return['body'];
    $headers = $return['headers'];
    foreach ($headers as $header) {
      //hacking cookies
      header($header, false);
      $head = explode(';', $header);
      $head = $head[0];
      $pos = stripos($head, "{$cookiepre}sid");
      if ($pos !== false) {
        $sid = substr($head, $pos + strlen("{$cookiepre}sid="));
        break;
      }
    }
    $session = $db->fetch_first("SELECT uid
                                 FROM {$tablepre}sessions
                                 WHERE sid='$sid' AND uid>0");
    $uid = 0;
    if ($session) {
      //update session
      $ips = explode('.', $regip);
      $db->query("UPDATE {$tablepre}sessions
                  set ip1=$ips[0], ip2=$ips[1], ip3=$ips[2], ip4=$ips[3]
                  WHERE sid='$sid'");
      $uid = $session['uid'];
    }
    return $uid;    
  }
  
  /**
   * Call the Discuz! logging.php using HTTP Request and Forward the cookies.
   * @param $username: A registered username
   * @param $password: The password of the $username
   * @return true if login sucefully. false if login failed
   */
  public function Login($gfcconfig, $username, $password) {
    $cookiepre = $this->cookiepre;
    $loginurl = $gfcconfig['sitepath']."/logging.php?action=login".
                                       "&loginsubmit=yes";
    $postdata = "loginfield=username&username={$username}&password={$password}".
                "&questionid=0&answer=&cookietime=2592000";
    $return = httpgets($loginurl, $postdata);
    if (!$return) {
      return false;
    }
    $headers = $return['headers'];
    $content = $return['body'];
    foreach ($headers as $header) {
      //hacking cookies
      header($header, false);
      $head = explode(';', $header);
      $head = $head[0];
      $pos = stripos($head, "{$cookiepre}auth");
      if ($pos !== false) {
        $auth = substr($head, $pos + strlen("{$cookiepre}auth="));
      }
    }
    if (isset($auth)) {
      return true;
    } else {
      return false;
    }
  }
  
  /**
   * Download the thumbnail and save it to the Discuz dir.
   * @param $uid: the discuz_uid
   * @param $thumbnail: the url of thumbnail 
   */
  public function UpdateThumbnail($uid, $thumbnail) {
    $response = httpgets($thumbnail);
    if(!$response) {
      return;
    }
    $image = $response['body'];
    $uid = abs(intval($uid));
    $uid = sprintf("%09d", $uid);
    //create the directories
    $basedir = $this->discuz_root.'./uc_server/data/avatar/';
    $dir1 = $basedir.substr($uid, 0, 3);
    $dir2 = $dir1.'/'.substr($uid, 3, 2);
    $dir3 = $dir2.'/'.substr($uid, 5, 2);
    !is_dir($dir1) && @mkdir($dir1, 0777);
    !is_dir($dir2) && @mkdir($dir2, 0777);
    !is_dir($dir3) && @mkdir($dir3, 0777);
    //file names
    $smallavatarfile = $dir3.'/'.substr($uid, -2)."_avatar_small.jpg";
    $middleavatarfile = $dir3.'/'.substr($uid, -2)."_avatar_middle.jpg";
    $bigavatarfile = $dir3.'/'.substr($uid, -2)."_avatar_big.jpg";
    //write the files
    $fp = @fopen($smallavatarfile, 'wb');
    @fwrite($fp, $image);
    @fclose($fp);
    $fp = @fopen($middleavatarfile, 'wb');
    @fwrite($fp, $image);
    @fclose($fp);
    $fp = @fopen($bigavatarfile, 'wb');
    @fwrite($fp, $image);
    @fclose($fp);    
  }
  
  /**
   * Update Disucz user profile
   * @param $uid: uid of the user to be updated
   * @param $level: the fields to be updated
   * @param $about_me: the bio of user
   * @param $site:  the site of user
   */
  public function UpdateProfile($uid, $level, $about_me, $site) {
    $tablepre = $this->tablepre;
    $db = $this->db;
    $updatefields = "";
    if ($level & 2) {
      $updatefields = "bio='$about_me'";
    }
    if (($level &2) && ($level & 4)) {
      $updatefields .= " , ";
    }
    if ($level & 4) {
      $updatefields .= "site='$site'";
    }
    if ($level) {
      $query = "UPDATE {$tablepre}memberfields
                SET $updatefields
                WHERE uid='$uid'";
      $db->query($query);
    }
  }
  
  /**
   * Set a GFC-Discuz! mapping
   * @param $gfcid : id on GFC
   * @param $uid: id on Discuz!
   * @param $username: username on Discuz!
   * @param $password: password on Discuz!
   * */
  public function SetGFCMapping($gfcid, $uid, $username, $password) {
    $db = $this->db;
    $tablepre = $this->tablepre;
    $db->query("INSERT INTO {$tablepre}gfcmapping
                (gfcid, dzid, dzusername, dzpassword)
                VALUES ('$gfcid', '$uid', '$username', '$password')");
  }
  
  /**
   * Get a GFC-Discuz! mapping
   * @param $gfcid : id on GFC
   * @return an array which is a mapping
   * */
  public function GetGFCMapping($gfcid) {
    $db = $this->db;
    $tablepre = $this->tablepre;
    $entry = $db->fetch_first("SELECT gfcid, dzid, dzusername, dzpassword,
                                      thumbnail_url, bio, site
                               FROM {$tablepre}gfcmapping
                               WHERE gfcid='$gfcid'");
    return $entry;    
  }
  
  /**
   * Update a GFC-Discuz! mapping
   * @param $gfcid : id on GFC
   * @param $site : personal info field of Discuz!
   * @param $about_me : personal info field of Discuz!
   * @param $thumbnail : personal info field of Discuz!
   * */
  public function UpdateGFCMapping($gfcid, $site, $about_me, $thumbnail) {
    $db = $this->db;
    $tablepre = $this->tablepre;
    $checksum = $this->Checksum($thumbnail);
    $db->query("UPDATE {$tablepre}gfcmapping
                SET site='$site', bio='$about_me',
                    thumbnail_url='$thumbnail', thumbnail_md5 = '$checksum'
                WHERE gfcid='$gfcid'");
  }
  
  /**
   * Delete a GFC-Discuz! mapping
   * @param $gfcid : id on GFC
   * */
  public function DeleteGFCMapping($gfcid) {
    $db = $this->db;
    $tablepre = $this->tablepre;    
    $db->query("DELETE FROM {$tablepre}gfcmapping WHERE gfcid='$gfcid'");
  }
  
  /**
   * Get the md5 cheksum of an image, given its url
   * @param $url : the url of an image
   * @return the md5sum of the image, or empty string if failed. 
   * */
  public function Checksum($url) {
    $response = httpgets($url);
    if (!$response) {
      return "";
    } else {
      $image = $response['body'];
      $cheksum = md5($image);
      return $checksum;
    }
  }
  
  private $db;
  private $tablepre;
  private $cookiepre;
  private $regname;
  private $discuz_root;
}

?>