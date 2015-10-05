# Google Friend Connect Plugin for Discuz! Manual #


## Introduction: Google Friend Connect Plugin for Discuz! 7.0 ##

The goal of this plugin is to add an optional login method, using Google Friend Connect, to Discuz!. It's simple to install, and is consistent with the Discuz!'s interface. Also, it supports different language encodings and different templates.

For install instruction, please refer to http://code.google.com/p/discuz-friendconnect/wiki/Discuz_Install_EN.

## UI ##

After installing Google Friend Connect Plugin, a login button will appear, shown as figure 1:

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_1.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 1: Login Button**                                                                                                                                                             |

When a user clicks this button, a Google Friend Connect verification page will pop up. The user should input his/her Google Account and password.

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_2.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 2: Google Friend Connect Verification**                                                                                                                                       |

After verification, the login button will be replaced by some Google Friend Connect links, and if this is the first time the user logs in, the registration page of Discuz! will pop up. The user needs to input a username(displayName is set as default). As an option, he/she can input his/her Email address, or just ignore it and click submit. The username must be unique.

When a user clicks this button, a Google Friend Connect verification page will pop up. The user should input his/her Google Account and password.

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_3_1.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_3_1.jpg)|
|:----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 3.1: Register Page**                                                                                                                                                              |

If the username is already in use, the user can not submit.

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_3_2.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_3_2.jpg)|
|:----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 3.2: If the username is taken**                                                                                                                                                   |

After registration, figure 4 will show that the user has registered successfully. In the meantime, an asynchronous Ajax request is sent to update the Discuz! personal profile with the Google Friend Connect profile, therefore we do not have to wait for it to finish.

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_4.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_4.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 4: Register Successfully**                                                                                                                                                    |

After login, shown as figure 5:

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_5.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_5.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 5: Login Successfully**                                                                                                                                                       |

Some fields of Discuz! personal profile will be synchronized with Google Friend Connect profile, shown as figure 6:

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_6.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_6.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 6: Personal Profile**                                                                                                                                                         |

A copy of the Google Friend Connect profile is stored at Discuz!. When a user logs in, the plugin will check whether the Google Friend Connect profile has been updated. If there are some updates, a window will pop up (shown in figure 7). The user can then choose which fields to be updated, or the user can also click Cancel, and this update will not be propagated until next login. If the user unchecks an item and clicks Submit, this update will not be propagated any more.

|![http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_7.jpg](http://discuz-friendconnect.googlecode.com/svn/wiki/discuz_images/manual/en/figure_7.jpg)|
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Fig 7: Profile Update**                                                                                                                                                           |

## Internationalization ##

Google Friend Connect plugin uses a simple approach to handle internationalization. All messages used are defined as global variables in `message.*.php`. The variable `$charset` defined in config.inc.php is checked to include the right message file.

## Templates ##

The Discuz! user interface is defined by CSS, and most templates have similar HTML structures in their header.htm files. The Google Friend Connect plugin modifies templates only in these areas, which are common to all templates:

  * Include of the the GFE javascript file: insert ` {subtemplate gfc_jsscript} ` before `</head>` label;
  * In an appropriate place, insert the login button: `<span id="friend_connect_gadget"></span>`;
  * Modify the **logout** functionality to log out of both Google Friend Connect and Disucz! at the same time. Essentially, iterate all links for a link whose url is **action=logout** , edit its onclick callback function.