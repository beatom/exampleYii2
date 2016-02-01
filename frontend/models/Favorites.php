<?php

namespace frontend\models\Profile;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\AutoBaseQuery;
use common\models\Favorites as FavoritesModel;
use frontend\models\UserHideAnnouncement;

class Favorites extends Model
{

    public function search($params)
    {

        // USER ID
        $userId = Yii::$app->user->id;

        // FAVORITES ANNOUNCEMENTS IDS
        $rows = FavoritesModel::find()
                ->select(['announcement_id'])
                ->andFilterWhere(['user_id' => $userId])
                ->asArray()
                ->all();
        if(!count($rows)) {
            return;
        }

        $favoritesIds = [];
        foreach($rows as $row) {
            $favoritesIds[] = $row['announcement_id'];
        }

        // BASE QUERY
        $query = AutoBaseQuery::queryLongBlockFull();
        $query->andFilterWhere(['in', 'announcement.id', $favoritesIds]);

        // SORT
        if(isset($params['sort'])) {
            switch($params['sort']) {
                case 'created_asc':
                    $query->orderBy("announcement.id DESC");
                    break;
                case 'price_cheap':
                    $query->orderBy("announcement.price ASC");
                    break;
                case 'price_expensive':
                    $query->orderBy("announcement.price DESC");
                    break;
                default:
                    $query->orderBy("announcement.id DESC");
                    break;
            }
        }
        else {
            $query->orderBy("announcement.id DESC");
        }

        // PER PAGE
        $perPage = Yii::$app->params['catalogSettings']['defaultPageSize'];
        if(isset($params['pp']) && in_array($params['pp'], Yii::$app->params['catalogSettings']['pageSize'])) {
            $perPage = $params['pp'];
        }

        // DATA PROVIDER
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $perPage,
                'pageSizeParam' => 'pp'
            ],
        ]);

        return $dataProvider;
    }

    public function getCountHiddenAnnouncements()
    {

        // USER ID
        $userId = Yii::$app->user->id;

        $count = UserHideAnnouncement::find()
                ->where(['user_id' => $userId])
                ->count();

        return $count;
    }
}
