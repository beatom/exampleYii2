<?php

namespace frontend\models\Profile;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Announcement;
use frontend\models\AutoBaseQuery;

class Announcements extends Model
{

    public function search($params)
    {

        // USER ID
        $userId = Yii::$app->user->id;

        // BASE QUERY
        $query = AutoBaseQuery::queryLongBlockFull();
        $query->andFilterWhere(['announcement.user_id' => $userId]);
        $query->andWhere(['in', 'announcement.status', [Announcement::STATUS_ENABLED, Announcement::STATUS_SALES]]);

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
}
