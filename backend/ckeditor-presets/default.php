<?php

use yii\helpers\Url;

return array_merge(
	require(__DIR__ . '/_main.php'),
	[
		'height'               => 400,
		'extraPlugins'         => 'codemirror',
		'toolbarGroups' => [
			['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup', 'list', 'colors']],
			['name' => 'paragraph', 'groups' => ['align']],
			['name' => 'links'],
			['name' => 'insert'],
			['name' => 'document', 'groups' => ['mode']],
		],

		'removeButtons' => 'Subscript,Superscript,Flash,HorizontalRule,Smiley,SpecialChar,PageBreak,Form,TextField,Textarea,Radio,Button,HiddenField,Select,Save,NewPage,Preview,Print,Templates',

		'filebrowserUploadUrl' => Url::to(['/wysiwyg/ckeditor-file-upload'], true),
	]
);