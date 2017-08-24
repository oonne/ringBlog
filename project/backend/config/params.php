<?php
return [
    'adminEmail' => 'SB@oonne.com',
    'UEditor'=>[
        'config' => [
            'serverUrl' => ['/editor/index'],
            'toolbars' => [
                [
                    'fullscreen',//全屏
                    'source', //源代码
                    'insertcode',//插入代码
                    'formatmatch', //格式刷
                    'undo', //撤销
                    'redo', //重做
                    'pasteplain', //纯文本粘贴模式
                    'removeformat', //清除格式
                    'simpleupload', //单图上传
                    'attachment', //附件
                    'insertframe', //插入Iframe
                ],
                [
                    'justifyleft', //居左对齐
                    'justifycenter', //居中对齐
                    'justifyright', //居右对齐
                    'justifyjustify', //两端对齐
                    'insertorderedlist', //有序列表
                    'insertunorderedlist', //无序列表
                    'bold', //加粗
                    'italic', //斜体
                    'underline', //下划线
                    'strikethrough', //删除线
                    'subscript', //下标
                    'superscript', //上标
                    'fontborder', //字符边框
                    'horizontal', //分隔线
                    'link', //超链接
                    'unlink', //取消链接
                    'fontsize', //字号
                    'paragraph', //段落格式
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'lineheight', //行间距
                ],
                [
                    'inserttable', //插入表格
                    'insertparagraphbeforetable', //"表格前插入行"
                    'insertrow', //前插入行
                    'insertcol', //前插入列
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'splittorows', //拆分成行
                    'splittocols', //拆分成列
                    'splittocells', //完全拆分单元格
                    'deletecaption', //删除表格标题
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'deletetable', //删除表格
                ]
            ],
            'lang' => 'zh-cn',
            'elementPathEnabled' => false,
            'wordCountMsg' => '当前已输入 {#count} 个字符',
//            'iframeCssUrl' => Yii::getAlias('@web') . '/static/css/ueditor.css',// 自定义编辑器内显示效果
            'z-index' => 1
        ]
    ]
];
