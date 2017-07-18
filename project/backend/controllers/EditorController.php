<?php

namespace backend\controllers;

use yii;
use crazydb\ueditor\UEditorController;

/**
 * UEditor controller
 */
class EditorController extends UEditorController
{   
    public $config;

    public function init()
    {
        //CSRF 基于 POST 验证，UEditor 无法添加自定义 POST 数据，同时由于这里不会产生安全问题，故简单粗暴地取消 CSRF 验证。
        //如需 CSRF 防御，可以使用 server_param 方法，然后在这里将 Get 的 CSRF 添加到 POST 的数组中。。。
        Yii::$app->request->enableCsrfValidation = false;

        //当客户使用低版本IE时，会使用swf上传插件，维持认证状态可以参考文档UEditor「自定义请求参数」部分。
        //http://fex.baidu.com/ueditor/#server-server_param

        //保留UE默认的配置引入方式
        if (file_exists(__DIR__ . '/../config/UEditor.json'))
            $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", '', file_get_contents(__DIR__ . '/../config/UEditor.json')), true);
        else
            $CONFIG = [];

        if (!is_array($this->config))
            $this->config = [];

        if (!is_array($CONFIG))
            $CONFIG = [];

        $default = [
            // Custom config of ueditor
            // @see http://fex.baidu.com/ueditor/#server-config
        ];
        $this->config = $this->config + $default + $CONFIG;
        $this->webroot = Yii::getAlias('@webroot');
        if (!is_array($this->thumbnail))
            $this->thumbnail = false;
    }

    public function actionConfig()
    {
        $this->config['imageUrlPrefix'] = Yii::$app->params['blogUrl'];
        $this->config['fileUrlPrefix'] = Yii::$app->params['blogUrl'];
        return $this->show($this->config);
    }

    protected function upload($fieldName, $config, $base64 = 'upload')
    {
        $up = new Uploader($fieldName, $config, $base64);

        if ($this->allowIntranet)
            $up->setAllowIntranet(true);

        $info = $up->getFileInfo();
        if (($this->thumbnail or $this->zoom or $this->watermark) && $info['state'] == 'SUCCESS' && in_array($info['type'], ['.png', '.jpg', '.bmp', '.gif'])) {
            $info['thumbnail'] = Yii::$app->request->baseUrl . $this->imageHandle($info['url']);
        }
        $info['url'] = Yii::$app->request->baseUrl .'/uploads/'. $info['name'];
        $info['original'] = htmlspecialchars($info['original']);
        $info['width'] = $info['height'] = 760;
        return $info;
    }
}
