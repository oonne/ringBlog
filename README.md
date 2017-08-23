# ringBlog
A simple blog. Base on Yii2.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

REQUIREMENTS
The minimum requirement by Yii is that your Web server supports PHP 5.4 .

一个基于Yii2的博客系统。Demo：http://blog.oonne.com

【准备工作】
1. 确保你的服务器安装了PHP 5.4以上版本，推荐使用MySql数据库；
2. 将域名解析到您的服务器，您需要准备两个二级域名：一个用于博客，一个用于后台管理。这能使博客更加安全；
3. 确保服务器已经安装了composer（可以在Composer中文官网找到下载地址和安装方式）；
4. 运行 composer global require "fxp/composer-asset-plugin:*" 来安装Composer Asset插件，Yii2 通过这个插件来安前端开发所用到依赖包；
5. 确保服务器安装了git。

【安装流程】
1. 在您服务器的 Web 访问目录下运行 "git clone https://github.com/oonne/ringBlog.git"。git会把ringBlog的源码自动下载到您的目录下；
2. 打开 project目录下运行"composer install"。composer将帮您安装所需的插件和依赖；
3. 运行 init 对系统进行初始化，在这一步您可以选择作为开发模式还是生产模式；
4. 打开project/common/config目录，编辑main-local.php文件，填入您的数据库信息。您还可以通过修改params.php和params-local.php进一步修改您博客的设置；
5. 在project目录下运行"php yii migrate/up"，这个命令将帮您初始化数据库；
在project/frontend/web目录下创建一个名为"uploads"的文件夹，该文件夹需要写入的权限（777）。您也可以修改project/backend/config/UEditor.json的配置，将上传图片和附件的文件夹改为其他路径；
6. 访问您的博客后台，初始的帐号和密码是"admin"。