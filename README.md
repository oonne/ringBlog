# ringBlog
A simple blog. Base on Yii2.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

REQUIREMENTS
The minimum requirement by Yii is that your Web server supports PHP 5.4 .

一个基于Yii2的博客系统。您可以按照以下步骤安装：
1.确保你的服务器安装了PHP 5.4以上版本，推荐使用MySql数据库。请事先讲您的博客域名解析到您的服务器；
2.下载源码或将项目克隆到 Web 访问的目录下。将博客域名绑定到/project/frontend/web目录，后台管理域名绑定到/project/backend/web目录；
3.在project目录下运行"composer install"。composer将帮您安装所需的插件和依赖；
4.运行 init 对系统进行初始化；
5.打开project\common\config目录，创建main-local.php文件，填入您的数据库信息。您还可以通过修改params.php和params-local.php进一步修改您博客的设置；
6.在project目录下运行"php yii migrate/up"，这个命令将帮您初始化数据库；
7.访问您的博客后台，初始的帐号和密码是"admin"。