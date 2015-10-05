#summary Google Friend Connect Plugin for Discuz! 手册

# Google Friend Connect Plugin for Discuz! 手册 #


## 简介 ##

Google Friend Connect Plugin for Discuz!是为 Disucz! 7.0 编写的插件。它的目标是为Discuz!网站增加一种新的利用 Google Friend Connect 登录的登录方式。该插件安装简单容易（因为基本上没有修改Discuz!本身的代码），同时与Disucz!的整体风格一致；另外，该插件支持Discuz!的多种编码和不同的模板。

安装流程请参考http://code.google.com/p/discuz-friendconnect/wiki/Discuz_Install_CN。

## 界面 ##

安装了Google Friend Connect Plugin后，将在Discuz!的 注册、登录链接位置出现 Google Friend Connect 登录按钮。如图1所示。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图1 首页**                                                                                                                                                                           |

点击 Google Friend Connect 登录后，将弹出Google Friend Connect的验证页面，用户在这个页面输入Google帐号和密码。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图2 Google Friend Connect验证页**                                                                                                                                                     |

Google Friend Connect 验证成功后，将返回Discuz!。此时Google Friend Connect登录按钮将被题换成Google Friend Connect的链接（设置、邀请）。如果是该用户第一次登录，将弹出Discuz!的注册页面。在这里用户的Google Friend Connect Profile中的displayName将作为默认的用户名，来构造Discuz!的用户名和E-mail地址。用户可以选择输入正确的E-mail，也可以忽略直接提交。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_3_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_3_1.jpg)|
|:----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图3.1 用户首次登录注册页面**                                                                                                                                                                     |

如果用户名已经被注册，用户将不能提交。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_3_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_3_2.jpg)|
|:----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图3.2 用户名被注册后的页面**                                                                                                                                                                     |

注册成功后，如图4示。此时将发送一个Ajax请求在后台更新Google Friend Connect profile. 这样做是为了不用等待用户的profile更新完成后才显示注册成功。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_4.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_4.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图4 注册成功**                                                                                                                                                                         |

登录成功后的页面，如图5所示。此时用户可以进行通常的Discuz!操作。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_5.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_5.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图5 登录成功**                                                                                                                                                                         |

用户在Google Friend Connect上的个人资料在Discuz!上存有副本。用户每次登录都将检查用户的Google Friend Connect资料与Discuz!上保存的是否有更新。如果Google Friend Connect有更新的话，将在用户登录后弹出提示窗后，由用户来选择时候更新。此时用户可以选择取消，这样在本次登录中将不再提示。如果用户取消了所有的选项并提交，那么此次Google Friend Connect更新将不再提示。

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_6.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/figure_6.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **图6 如果Google Friend Connect的profile有更新**                                                                                                                                           |

## 多语言支持方式 ##

该插件使用一种简单的方式支持多语言多编码。插件中所用到的message信息都作为全局变量保存在 `message.*.php` 中(`*`代表语言编码)。在Discuz!的config.inc.php中有一个名为 `$charset`的全局变量。 在插件中会根据此变量的值 include 相应的 message 文件。

## 多模板支持 ##

下面是测试不同的编码和不同风格的模板的界面。

### 模板一 ［编码： 简体中文 UTF8］ ###

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **1. 登录前**                                                                                                                                                                          |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2. 首次登录注册**                                                                                                                                                                       |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_3.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_3.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2.1 如果默认的用户名已经被注册了**                                                                                                                                                              |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_4.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_1_4.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **3. 登录后**                                                                                                                                                                          |

### 模板二 ［编码： 简体中文 GBK］ ###

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_2_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_2_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **1. 登录前**                                                                                                                                                                          |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_2_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_2_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2. 首次登录注册**                                                                                                                                                                       |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_2_3.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_2_3.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **3. 登录后**                                                                                                                                                                          |

### 模板三 ［编码： 繁体中文BIG5］ ###

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_3_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_3_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **1. 登录前**                                                                                                                                                                          |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_3_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_3_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2. 首次登录注册**                                                                                                                                                                       |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_3_3.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_3_3.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **3. 登录后**                                                                                                                                                                          |

### 模板四 ［编码   繁体中文 UTF8］ ###

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_4_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_4_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **1. 登录前**                                                                                                                                                                          |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_4_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_4_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2. 首次登录注册**                                                                                                                                                                       |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_4_3.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_4_3.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **3. 登录后**                                                                                                                                                                          |

### 模板五  ［ 英文 ］ ###

需要说明的是 Discuz!官方没有发行英文版的Discuz! 7.0，这里选取的是第三方的“英化”版本，来自于 www.discuz2u.com.

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **1. 登录前**                                                                                                                                                                          |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2. 首次登录注册**                                                                                                                                                                       |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_3.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_3.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2.1 如果默认的用户名已经被注册了**                                                                                                                                                              |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_4.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_5_4.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **3. 登录后**                                                                                                                                                                          |

### 模板六  ［ Disucz 6.0风格的模板 ］ ###

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_6_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_6_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **1. 登录前**                                                                                                                                                                          |

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_6_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/cn/tmpl_6_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **2. 登录后**                                                                                                                                                                          |

## 总结 ##
Discuz!的风格多由CSS决定，而不同模板的header.htm的HTML结构差不多。 基本上说，Google Friend Connect插件只依赖模板的以下几个方面：
  * 引入 Google Friend Connect JavaScript 文件: ` {subtemplate gfc_jsscript} `；
  * 在适当的地方插入一个显示 Google Friend Connect 的控件：`<span id="friend_connect_gadget"></span>`；
  * 修改 Discuz!的 **退出** 链接，加入退出Google Friend Connect的功能。实现上，是通过js遍历网页中所有的链接，找到有 **action=logout** 的链接，修改其 onclick 函数。

由于上面这些基本上是模板的共性，所以Google Friend Connect插件是可以适应不同风格的模板的。