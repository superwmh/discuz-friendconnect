# Google Friend Connect for Discuz! 7.0 Installation Instructions #


## Step 1: Install Friend Connect and get your Site ID ##
  1. Sign up for Google Friend Connect at http://www.google.com/friendconnect.
  1. Get your Site ID.
See [InstallFriendConnect](http://code.google.com/p/discuz-friendconnect/wiki/InstallFriendConnect) for details.

## Step 2: Get Google Friend Connect for Discuz! 7.0 ##
Get the latest version of the plugin at http://code.google.com/p/discuz-friendconnect/downloads/list. After unzipping it, it should look like this:
<pre>
.<br>
|<br>
|-- images<br>
|   |<br>
|   `-- default<br>
|       |<br>
|       `-- gfc_arrow.gif<br>
|<br>
|-- plugins<br>
|   |<br>
|   `-- gfc<br>
|       |<br>
|       |-- common.php<br>
|       |-- config.inc.php<br>
|       |-- discuz.class.php<br>
|       |-- discuz_env_mock.php<br>
|       |-- gfcpluginunittest.php<br>
|       |-- global.func.php<br>
|       |-- message.big5.php<br>
|       |-- message.gbk.php<br>
|       |-- message.php<br>
|       |-- message.utf8.php<br>
|       |-- message.zh_TW.utf8.php<br>
|       `-- plugin.class.php<br>
|<br>
|-- templates<br>
|   |<br>
|   `-- default<br>
|       |<br>
|       |-- gfc_jsscript.htm<br>
|       |-- gfcprofile.htm<br>
|       `-- gfcregister.htm<br>
|<br>
|-- gfcauth.php<br>
|-- gfccheck.php<br>
|-- gfcinstall.php<br>
|-- gfcprofile.php<br>
|-- gfcregister.php<br>
`-- gfcuninstall.php<br>
</pre>

You must modify the file plugins/gfc/config.inc.php,
  * `$gfcconfig['siteid']＝"*****";` change `*****` to your site id.
  * `$gfcconfig['sitepath'] = '/*****/';` change `*****` to your site path (Ending with /).

## Step 3: Upload the Google Friend Connect Plugin to your site ##
Upload the plug-in to your site install directory.
  * Upload **plugins/gfc** to **plugins** of your install dir.
  * Upload **images/default/gfc\_arrow.gif** to **images/default** .
  * Upload files in **templates/default** to **templates/default** of your install dir.
  * Upload **gfcauth.php**, **gfccheck.php**, **gfcinstall.php**, **gfcprofile.php**, **gfcregister.php** to your install dir.

## Step 4: Edit necessary files in your site ##
Edit file templates/default/header.htm:
  * Insert line ` {subtemplate gfc_jsscript} ` before `</head>`
  * Find the following section of code around line 60 or so:
```
<!--{else}-->
   <a href="$regname" onclick="floatwin('open_register', this.href, 600, 400, '600,0');return false;" class="noborder">$reglinkname</a>
   <a href="logging.php?action=login" onclick="floatwin('open_login', this.href, 600, 400);return false;">{lang login}</a>
<!--{/if}-->
```
> add the following line after that part:
```
<span id="friend_connect_gadget"></span>
```
> and finally the code looks like:
```
<!--{else}-->
   <a href="$regname" onclick="floatwin('open_register', this.href, 600, 400, '600,0');return false;" class="noborder">$reglinkname</a>
   <a href="logging.php?action=login" onclick="floatwin('open_login', this.href, 600, 400);return false;">{lang login}</a>
<!--{/if}-->
<span id="friend_connect_gadget"></span>
```

## Step 5: Install Script ##
Open http://youdomainname.com/youpath/gfcinstall.php in your browser. After the installation completes, you should see a message telling you that your install succeeded. You will need to manually delete the installation script.

## Step 6: Clear the Discuz! cache ##
Login in to Discuz! using your admin account, click the Tools link of System Settings, and choose **Update Cache**.

## Note ##

For demo, please check: http://www.unickway.org.cn/discuz.en/

### If you want to add Google Friend Connect gadgets ###

Welcome to Google Friend Connect world! Since your forum site has already been registered as a Google Friend Connect enabled, for sure it could add any Google Friend Connect gadget as you like.  For more info on how to add a gadget, and how to find interesting gadgets like social-bar, recommendations, and events, please refer to the [gadget directory](http://www.google.com/friendconnect/home/gadgets).

### If you are using a different template ###
Please modify the coorsponding header.htm of the template.

### If you want to delete the plugin ###
  1. Upload the file gfcuninstall.php to the Discuz! directory, and open http://youdomainname.com/youpath/gfcuninstall.php in your browser.
  1. Delete the uploaded files
  1. Remove the code added to header.htm

### Troubleshooting ###

Please go to http://code.google.com/p/discuz-friendconnect/issues/list for help.

For more info, please refer to the manual: http://code.google.com/p/discuz-friendconnect/wiki/Discuz_Manual_EN.