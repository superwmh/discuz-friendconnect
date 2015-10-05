# Google Friend Connect Plugin for Discuz! 7.0 安装指南 #


## 一：在Google Friend Conenct上注册您的网站 ##
  1. 在浏览器中打开http://www.google.com/friendconnect/?hl=zh_cn；
  1. 用您的Google帐号和密码登录；
  1. 点击链接设置新网站，选择用于标准网站的Google朋友群；
  1. 阅读概要，点击继续；
  1. 输入您网站的名称和主页网址(在本指南中将以http://youdomainname.com/yourpath/为例，youdomainname.com为您服务器的域名或IP，yourpath为您的论坛的路径)，并选择您的网站的语言。完成之后点击继续；

## 二：下载Google Friend Conenct Plugin for Discuz! 7.0 ##
从[项目主页](http://code.google.com/p/discuz-friendconnect/downloads/list)下载最新版本的Google Friend Conenct Plugin for Discuz!。将下载的zip解压缩到本地，该插件应该有如下的结构：
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
您需要修改 plugins/gfc/config.inc.php, 将文件中：
  * `$gfcconfig['siteid'] = "网站ID"`中的"网站ID"修改成您的网站ID（该ID在上一步中得到）
  * `$gfcconfig['sitepath'] = '/网站路径/'`中的'/网站路径/'修改成您网站的路径 (注意以 / 结束)

## 三：将Google Friend Conenct Plugin上传到您的网站上 ##

您需要使用ftp等工具将上述文件复制到对应的文件夹下：
  * 将 **plugins/gfc** 目录复制到您的论坛安装目录的 **plugins** 文件夹下
  * 将 **images/default/gfc\_arrow.gif** 复制到 **images/default** 下
  * 将 **templates/default** 目录下的文件复制到您的论坛的安装目录的 **templates/default** 下
  * 将 **gfcauth.php**, **gfccheck.php**, **gfcinstall.php**, **gfcprofile.php**, **gfcregister.php** 复制到您的论坛安装目录下

## 四：修改必要的文件 ##
您需要修改您的服务器上的文件 **templates/default/header.htm**:
  * 在 标签`</head>`之前插入` {subtemplate gfc_jsscript} `
  * 在大约60行左右的位置，找到
```
<!--{else}-->
   <a href="$regname" onclick="floatwin('open_register', this.href, 600, 400, '600,0');return false;" class="noborder">$reglinkname</a>
   <a href="logging.php?action=login" onclick="floatwin('open_login', this.href, 600, 400);return false;">{lang login}</a>
<!--{/if}-->
```
> 在之后插入
```
<span id="friend_connect_gadget"></span>
```
> 则代码看起来是：
```
<!--{else}-->
   <a href="$regname" onclick="floatwin('open_register', this.href, 600, 400, '600,0');return false;" class="noborder">$reglinkname</a>
   <a href="logging.php?action=login" onclick="floatwin('open_login', this.href, 600, 400);return false;">{lang login}</a>
<!--{/if}-->
<span id="friend_connect_gadget"></span>
```

## 五：运行安装脚本 ##
在浏览器中打开http://youdomainname.com/youpath/gfcinstall.php, 安装完成后浏览器中应该显示安装成功。并请在成功后将该脚本删除。

## 六：清空Discuz!缓存 ##
用管理员帐号登录 Discuz!, 在系统设置的工具选项中选择 **更新缓存** 。

## 附录 ##

更多详细的功能请试用示例网站：http://www.unickway.org.cn/discuz/

### 如果您想安装Google Friend Connect应用 ###

欢迎来到Google Friend Connect的世界！由于您已经在Google Friend Connect上注册了您的论坛，所有的Google Friend Connect应用就自然地可以被安装在您的论坛上。关于如何安装应用，及如何找到有趣的应用如“社交栏位”、“推荐”、“活动”，请访问[应用目录](http://www.google.com/friendconnect/home/gadgets)。

### 如果您使用不同的模板 ###
请按照上面所述修改对应模板的header.htm。

### 如果您要删除该插件 ###
  1. 将安装包中的 gfcuninstall.php上传到您的安装目录，然后在浏览器中打开http://youdomainname.com/youpath/gfcuninstall.php；
  1. 删除之前上传到服务器上的plugin文件；
  1. 恢复在header.htm中添加的代码。

### 更多资讯 ###

如您有问题或建议，请访问：http://code.google.com/p/discuz-friendconnect/issues/list。

更多资讯请参考用户手册：http://code.google.com/p/discuz-friendconnect/wiki/Discuz_Manual_CN。