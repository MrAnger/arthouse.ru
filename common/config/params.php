<?php

return [
	'CKEditorFileUploadAllowedExtensions' => 'gif, png, jpg, jpeg', // разрешенные расширения файлов
	'CKEditorFileUploadPath'              => dirname(dirname(__DIR__)) . '/frontend/web/file_uploads', // путь для сохранения файлов
	'CKEditorFileUploadedUrl'             => '/file_uploads', // ссылка, по которой будут доступны сохраненые файлы

	'countDaysForMoveNewsToArchive' => 7, // Кол-во дней, после которых новость будет автоматически архивированна
];
