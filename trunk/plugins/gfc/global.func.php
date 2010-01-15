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

/**
 * This HTTP function is used to get user profile and to register and login.
 * @return: the content of the url. '' if failed.
 */
function httpgets($url, $post) {
  $return = array();
  $return['body'] = '';
  $return['headers'] = array();
  $cookie = '';
  $matches = parse_url($url);
  !isset($matches['host']) && $matches['host'] = $_SERVER['SERVER_ADDR'];
  !isset($matches['path']) && $matches['path'] = '/';
  !isset($matches['query']) && $matches['query'] = '';
  !isset($matches['port']) && $matches['port'] = 80;
  $host = $matches['host'];
  $port = $matches['port'];
  $path = $matches['path'].($matches['query'] ? '?'.$matches['query'] : '');
  if ($post) {
    $out = "POST $path HTTP/1.0\r\n";
    $out .= "Accept: */*\r\n";
    $out .= "Accept-Language: zh-cn\r\n";
    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
    $out .= "Host: $host\r\n";
    $out .= 'Content-Length: '.strlen($post)."\r\n";
    $out .= "Connection: Close\r\n";
    $out .= "Cache-Control: no-cache\r\n";
    $out .= "Cookie: $cookie\r\n\r\n";
    $out .= $post;
  } else {
    $out = "GET $path HTTP/1.0\r\n";
    $out .= "Accept: */*\r\n";
    $out .= "Accept-Language: zh-cn\r\n";
    $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
    $out .= "Host: $host\r\n";
    $out .= "Connection: Close\r\n";
    $out .= "Cookie: $cookie\r\n\r\n";
  }
  $timeout = 15;
  $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
  if (!$fp) {
    return '';
  } else {
    stream_set_blocking($fp, true);
    stream_set_timeout($fp, $timeout);
    @fwrite($fp, $out);
    $status = stream_get_meta_data($fp);
    if (!$status['timed_out']) {
      while (!feof($fp)) {
        if (($header = @fgets($fp))) {
          $return['headers'][] = $header;
          if ($header == "\r\n" ||  $header == "\n") {
            break;
          }
        }
      }
      while (!feof($fp)) {
        $data = fread($fp, 8192);
        $return['body'] .= $data;
      }
    } else {
      return '';
    }
    @fclose($fp);
    return $return;
  }
}

/**
*  get the sign-in user profile. 
*  @param string $fcauth The fcauth string get from cookie
*  @return a user(as an array) if success. false if failed
*/
function getGFCProfile($fcauth) {
  $apiurl = "http://www.google.com/friendconnect/api/people/@me/@self";
  $apiurl .= '?fields=aboutMe,profileUrl,urls&';
  $apiurl .= 'fcauth='.$fcauth;
  $content = httpgets($apiurl, '');
  if ($content == '') {
    return false;
  }
  $content = $content['body'];
  $obj = json_decode($content, true);
  if ($obj) {
    return $obj["entry"];
  } else {
    return false;
  }
}
?>