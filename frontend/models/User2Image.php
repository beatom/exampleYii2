<?php

namespace frontend\models;

use yii\base\Model;
use Yii;
use common\vendor\FileManager\Manager\FileFactory;
use common\models\User2Image as User2ImageModel;

class User2Image extends Model
{

    public $user_id;
    public $main_image;
    public $images;

    public static function existsImages($userId)
    {

        // FILE MANAGER
        $options = Yii::$app->params;
        $fileManager = FileFactory::factory((object)$options['fileManager']);
        $fileManager->setAsset('user', ['id' => $userId]);

        // IMAGES
        $rows = User2ImageModel::find()
                ->select(['filename', 'is_main'])
                ->where(['user_id' => $userId])
                ->asArray()
                ->all();
        if(!count($rows)) {

            // WHEN NOT EXISTS IMAGES BUT IMAGES IN POST
            if(Yii::$app->request->post()) {
                if(isset(Yii::$app->request->post()['User']['images'])) {

                    $fileManager->setAsset('temp');

                    $postImages = Yii::$app->request->post()['User']['images'];
                    $images     = [];
                    $mainImage  = [];
                    foreach($postImages as $filename) {
                        $images[] = [
                            'filename' => $filename,
                            'filepath' => '/' . $fileManager->getPath($filename)
                        ];

                        $mainImage = [
                            'filename' => $filename,
                            'filepath' => '/' . $fileManager->getPath($filename)
                        ];
                    }

                    if(count($images)) {
                        return [$images, $mainImage];
                    }
                }
            }

            return [
                [],
                []
            ];
        }

        $images    = [];
        $mainImage = [];
        foreach($rows as $row) {

            $images[] = [
                'filename' => $row['filename'],
                'filepath' => '/' . $fileManager->getPath($row['filename'], 'gallery')
            ];

            if($row['is_main']) {
                $mainImage = [
                    'filename' => $row['filename'],
                    'filepath' => '/' . $fileManager->getPath($row['filename'], 'main')
                ];
            }
        }

        // MERGE EXISTS IMAGES WITH IMAGES FROM POST
        if(Yii::$app->request->post()) {

            $existsImages = [];
            foreach($images as $image) {
                $existsImages[] = $image['filename'];
            }

            $postImages = [];
            if(isset(Yii::$app->request->post()['User']['images'])) {
                $postImages = Yii::$app->request->post()['User']['images'];
            }

            if(count($postImages)) {

                $newImages  = [];
                foreach($postImages as $filename) {
                    if(!in_array($filename, $existsImages)) {
                        $newImages[] = $filename;
                    }
                }

                $fileManager->setAsset('temp');
                foreach($newImages as $filename) {
                    $images[] = [
                        'filename' => $filename,
                        'filepath' => '/' . $fileManager->getPath($filename)
                    ];

                    $mainImage = [
                        'filename' => $filename,
                        'filepath' => '/' . $fileManager->getPath($filename)
                    ];
                }
            }
        }

        return [$images, $mainImage];
    }

    public static function hasImages($userId)
    {

        $count = User2ImageModel::find()
                ->select(['id'])
                ->where(['user_id' => $userId])
                ->asArray()
                ->count();
        if($count) {
            return true;
        }

        return false;
    }

    public static function getAvatar($userId)
    {

        $avatarRow = User2ImageModel::find()
                ->select(['filename'])
                ->andWhere(['user_id' => $userId])
                ->andWhere(['is_main' =>  1])
                ->asArray()
                ->one();
        $avatar = '';
        if($avatarRow) {
            $avatar = $avatarRow['filename'];
        }

        $filepath = '';
        if($avatar) {
            $options = Yii::$app->params;
            $fileManager = FileFactory::factory((object)$options['fileManager']);
            $fileManager->setAsset('user', ['id' => $userId]);
            $filepath = '/' . $fileManager->getPath($avatar, 'item');
        }

        return $filepath;
    }

    public function addImages()
    {

        if(!count($this->images)) {
            return;
        }

        $options = Yii::$app->params;
        $fileManager = FileFactory::factory((object)$options['fileManager']);

        foreach($this->images as $image) {

            $fileManager->setAsset('temp', []);
            $target = $fileManager->getDestination();

            $fileManager->setAsset('user', ['id' => $this->user_id]);

            try {
                $fileManager->persist($target, $image);
            } catch (Exception $e) {

            }

            $isMain = 0;
            if($image == $this->main_image) {
                $isMain = 1;
            }

            $model = new User2ImageModel();
            $model->filename = $image;
            $model->is_main  = $isMain;
            $model->user_id  = $this->user_id;
            $model->save();
        }
    }

    public function updateImages()
    {

        // EXISTS IMAGES
        $rows = User2ImageModel::find()->select(['id'])->where(['user_id' => $this->user_id])->asArray()->all();
        if(!count($rows)) {
            return;
        }

        $oldIds = [];
        foreach($rows as $row) {
            $oldIds[] = $row['id'];
        }

        $insert = $this->images;
        $delete = $oldIds;
        $update = array();

        // IF NO IMAGES - DELETE FROM DB
        if(!count($insert)) {
            foreach($delete as $id) {
                $announcement2image = User2ImageModel::findOne($id);
                $announcement2image->delete();
            }
            return;
        }

        foreach($oldIds as $id) {

            $update[] = array(
                'filename' => array_shift($insert),
                'id' => $id
            );

            array_shift($delete);

            if(!count($insert)) {
                break;
            }
        }

        $filenames = [];

        // UPDATE
        if(count($update)) {

            foreach($update as $row) {

                $id = $row['id'];
                $filename = $row['filename'];

                $isMain = 0;
                if($filename == $this->main_image) {
                    $isMain = 1;
                }

                $announcement2image = User2ImageModel::findOne($id);
                $announcement2image->filename = $filename;
                $announcement2image->is_main  = $isMain;
                $announcement2image->save();

                $filenames[] = $filename;
            }
        }

        // INSERT
        if(count($insert)) {

            foreach($insert as $filename) {

                $isMain = 0;
                if($filename == $this->main_image) {
                    $isMain = 1;
                }

                $announcement2image = new User2ImageModel();
                $announcement2image->user_id  = $this->user_id;
                $announcement2image->filename = $filename;
                $announcement2image->is_main  = $isMain;
                $announcement2image->save();

                $filenames[] = $filename;
            }
        }

        // DELETE
        if(count($delete)) {

            foreach($delete as $id) {
                $announcement2image = User2ImageModel::findOne($id);
                $announcement2image->delete();
            }
        }

        // MOVE NEW IMAGES TO PERMANENT DIRECTORY
        if(!count($filenames)) {
            return;
        }

        $options = Yii::$app->params;
        $fileManager = FileFactory::factory((object)$options['fileManager']);
        foreach($filenames as $filename) {

            $fileManager->setAsset('temp', []);
            $target = $fileManager->getDestination();

            $fileManager->setAsset('user', ['id' => $this->user_id]);

            try {
                if(file_exists($target . '/' . $filename)) {
                    $fileManager->persist($target, $filename);
                }
            } catch (Exception $e) {

            }
        }
    }

    public static function copySocialImage($imageUrl)
    {

        // FILE PROPERTIES
        $pathinfo = pathinfo($imageUrl);

        $extension = 'jpg';
        if(isset($pathinfo['extension']) && !empty($pathinfo['extension'])) {
            $extension = $pathinfo['extension'];
        }

        $filename = md5(uniqid()) . '.' . $extension;

        // FILEPATH
        $console = Yii::getAlias('@frontend');
        $filepath = $console . '/web/uploads/temp/' . $filename;

        // UPLOAD FILE TO TEMP
        $file = file_get_contents($imageUrl);
        file_put_contents($filepath, $file);

        return $filename;
    }
}
