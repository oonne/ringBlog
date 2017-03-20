<?php

namespace backend\controllers;

use yii;
use crazydb\ueditor\UEditorController;

/**
 * Usersuper controller
 */
class EditorController extends UEditorController
{   

    public function actionConfig()
    {
        $this->config['imagePathFormat'] = '/uploads/{yyyy}{mm}{dd}{time}{rand:6}';
        $this->config['filePathFormat'] = '/uploads/{yyyy}{mm}{dd}{time}{filename}_{rand:6}';
        $this->config['imageUrlPrefix'] = 'http://'. Yii::$app->params['blogUrl'];
        $this->config['fileUrlPrefix'] = 'http://'. Yii::$app->params['blogUrl'];
        return $this->show($this->config);
    }

    /**
     * 上传图片
     */
    public function actionUploadImage()
    {
        $config = [
            'pathFormat' => '/../../frontend/web/uploads/{yyyy}{mm}{dd}{time}{rand:6}',
            'maxSize' => $this->config['imageMaxSize'],
            'allowFiles' => $this->config['imageAllowFiles']
        ];
        $fieldName = $this->config['imageFieldName'];        
        $result = $this->upload($fieldName, $config);
        return $this->show($result);
    }

    /**
     * 上传文件
     */
    public function actionUploadFile()
    {
        $config = [
            'pathFormat' => '/../../frontend/web/uploads/{yyyy}{mm}{dd}{time}{filename}_{rand:6}',
            'maxSize' => $this->config['fileMaxSize'],
            'allowFiles' => $this->config['fileAllowFiles']
        ];
        $fieldName = $this->config['fileFieldName'];
        $result = $this->upload($fieldName, $config);
        return $this->show($result);
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
        $info['url'] = Yii::$app->request->baseUrl .'/uploads/'. $info['title'];
        $info['original'] = htmlspecialchars($info['original']);
        $info['width'] = $info['height'] = 500;
        return $info;
    }
}
