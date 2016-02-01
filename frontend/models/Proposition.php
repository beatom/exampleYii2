<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Proposition as PropositionModel;
use common\models\Announcement;
use frontend\models\AutoBaseQuery;

class Proposition extends Model
{

    public $id;
    public $parent_id;
    public $date_created;
    public $user_id;
    public $to_user_id;
    public $announcement_id;
    public $announcement_exchange_id;
    public $type;
    public $name;
    public $phone;
    public $amount;
    public $currency_id;
    public $comment;
    public $surcharge;

    protected $minAmount;
    protected $maxAmount;
    protected $avgAmount;

    public function getMinAmount()
    {

        return $this->minAmount;
    }

    public function getMaxAmount()
    {

        return $this->maxAmount;
    }

    public function getAvgAmount()
    {

        return $this->avgAmount;
    }

    public function prepareMinMaxAvg($announcementId)
    {

        $amounts = PropositionModel::find()
                ->select([
                    'minAmount' => 'MIN(amount_display)',
                    'maxAmount' => 'MAX(amount_display)',
                    'avgAmount' => 'AVG(amount_display)'
                ])
                ->andFilterWhere(['announcement_id' => $announcementId])
                ->andFilterWhere(['!=', 'type', PropositionModel::TYPE_SELLER_RESPONSE])
                ->asArray()
                ->all();
        if(!count($amounts)) {
            return;
        }

        $amounts = array_shift($amounts);

        $this->minAmount = (int) $amounts['minAmount'];
        $this->maxAmount = (int) $amounts['maxAmount'];
        $this->avgAmount = (int) $amounts['avgAmount'];
    }

    public function getCurrentUserAuto()
    {

        $userId = Yii::$app->user->id;
        if(!$userId) {
            return;
        }

        $query = AutoBaseQuery::queryLongBlockBase();
        $rows = $query->andFilterWhere([
                    'announcement.user_id' => $userId,
                    'announcement.status'  => Announcement::STATUS_ENABLED
                ])
                ->orderBy('announcement.id ASC')
                ->all();

        return $rows;
    }

    public function getPropositionCount($announcementId)
    {

        if(!$announcementId) {
            return 0;
        }

        $count = PropositionModel::find()
                ->andFilterWhere(['announcement_id' => $announcementId])
                ->andFilterWhere(['!=', 'type', PropositionModel::TYPE_SELLER_RESPONSE])
                ->count();

        return $count;
    }

    public function getTotalPropositionCount($userId)
    {

        if(!$userId) {
            return 0;
        }

        $db = Yii::$app->db;
        $totalCount = $db->cache(function($db) use ($userId) {
            $totalCount = PropositionModel::find()
                ->andFilterWhere(['to_user_id' => $userId])
                ->count();

            return $totalCount;
        }, Yii::$app->params['1minuteCacheSeconds']);

        return $totalCount;
    }

    public function getPropositionList($announcementId)
    {

        if(!$announcementId) {
            return;
        }

        $rows = PropositionModel::find()
                ->where(['announcement_id' => $announcementId])
                ->orderBy('date_created DESC')
                ->asArray()
                ->all();
        if(!count($rows)) {
            return;
        }

        $propositions = [];

        // PROPOSITIONS
        foreach($rows as $key => $row) {

            if($row['type'] == PropositionModel::TYPE_SELLER_RESPONSE) {

                continue;
            }

            $propositions[$row['id']] = $row;
            unset($rows[$key]);
        }

        // RESPONSES
        foreach($rows as $row) {
            if(isset($propositions[$row['parent_id']])) {
                $propositions[$row['parent_id']]['response'] = $row;
            }
        }

        return $propositions;
    }

    public function getToUserId($announcementId)
    {

        $db = Yii::$app->db;
        $toUserId = $db->cache(function($db) use ($announcementId) {
            $toUserId = Announcement::find()
                ->select(['user_id'])
                ->where(['id' => $announcementId])
                ->asArray()
                ->one();
            $toUserId = array_shift($toUserId);

            return $toUserId;
        });

        return $toUserId;
    }

    public function addExchangeAutoToProposition($propositions)
    {

        if(!count($propositions)) {
            return;
        }

        // EXCHANGE IDS
        $exchangeIds = [];
        foreach($propositions as $row) {
            if($row['announcement_exchange_id']) {
                $exchangeIds[] = $row['announcement_exchange_id'];
            }
        }

        // EXCHANGE AUTOS
        $query = AutoBaseQuery::queryLongBlockBase();
        $query->andFilterWhere(['announcement.status' => Announcement::STATUS_ENABLED]);
        $query->andFilterWhere(['in', 'announcement.id', $exchangeIds]);
        $rows = $query->orderBy('announcement.id ASC')
                ->all();

        $exchangeAutos = [];
        foreach($rows as $row) {
            $exchangeAutos[$row['id']] = $row;
        }

        // EXCHANGE AUTOS TO PROPOSITIONS
        foreach($propositions as $key => $row) {
            if($row['announcement_exchange_id']) {
                $propositions[$key]['exchange_auto'] = $exchangeAutos[$row['announcement_exchange_id']];
            }
        }

        return $propositions;
    }
}
