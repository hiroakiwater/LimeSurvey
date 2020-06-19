<?php
use Google\Cloud\Storage\StorageClient;

class CommonStorage {
        public static function upload_file($filename) {
                if (!Yii::app()->params['use_external_storage']) {
                        return;
                }

                $bucket_name = Yii::app()->params['bucket'];

                $storage = new StorageClient(array('keyFilePath' => Yii::app()->params['key_file_path']));
                $destination = str_replace(dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR, '', $filename);
                $bucket = $storage->bucket($bucket_name);
                $bucket->upload( fopen($filename, 'r'), array(
                        'name' => $destination,
                ) );
        }

        // define same name functions.
        
        public static function scandir($path) {
                if (!Yii::app()->params['use_external_storage']) {
                        return scandir($path);
                }

                $bucket_name = Yii::app()->params['bucket'];

                $storage = new StorageClient(array('keyFilePath' => Yii::app()->params['key_file_path']));
                $storage_path = str_replace(dirname(Yii::app()->basePath) . DIRECTORY_SEPARATOR, '', $path);
                $bucket = $storage->bucket($bucket_name);

                $files = [];
                $objects = $bucket->objects(array(
                        'prefix' => $storage_path,
                        'fields' => 'items/name'
                ));

                foreach ($objects as $object) {
                        $name = basename($object->name());
                        $files[] = $name;
                }

                return $files;
        }

        public static function is_dir($path) {
                if (!Yii::app()->params['use_external_storage']) {
                        return is_dir($path);
                }

        }

        public static function finfo_file($finfo, $file_name) {
                if (!Yii::app()->params['use_external_storage']) {
                        return finfo_file($path);
                }
        }

        public static function filesize($file_name) {
                if (!Yii::app()->params['use_external_storage']) {
                        return filesize($path);
                }
        }
        
}
