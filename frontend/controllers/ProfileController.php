<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Announcement;
use common\models\MailSubscribe;
use frontend\controllers\ReonoController;
use frontend\models\ChangePasword;
use frontend\models\Proposition as PropositionService;
use frontend\models\Profile\Proposition as ProfilePropositionService;
use frontend\models\Profile\Favorites;
use frontend\models\Profile\UserHideAnnouncement;
use frontend\models\Profile\Announcements as MyAnnouncements;
use frontend\models\User as UserModel;
use frontend\models\User2Image;
use frontend\models\Form\SelectData;
use frontend\models\RemovePhone;

class ProfileController extends ReonoController
{
    public function behaviors()
    {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['user']
                    ]
                ],
                'denyCallback' => function($rule, $action) {

                    // GUEST
                    if(!Yii::$app->user->identity) {
                        return $this->redirect(Url::to(['auth/login']));
                    }

                    // CONFIRMED
                    $role = \Yii::$app->user->identity->role;
                    if($role == User::ROLE_CONFIRMED) {
                        return $this->redirect(Url::to(['auth/confirmed-phone']));
                    }
                }
            ],
        ];
    }

    public function actionIndex()
    {

        $userId = Yii::$app->user->id;

        // COUNT ANNOUNCEMENT
        $db = Yii::$app->db;
        $countAnnouncement = $db->cache(function($db) use ($userId) {
            $countAnnouncement = Announcement::find()
                    ->andFilterWhere(['user_id' => $userId])
                    ->andFilterWhere(['in', 'status', [Announcement::STATUS_ENABLED, Announcement::STATUS_SALES]])
                    ->count();
            return $countAnnouncement;
        }, Yii::$app->params['1minuteCacheSeconds']);

        // COUNT PROPOSITIONS
        $propositionService = new PropositionService();
        $countPropositions = $propositionService->getTotalPropositionCount($userId);

        // FAQ
        $faq = SelectData::getFAQ();

        return $this->render('index', [
            'countAnnouncement' => $countAnnouncement,
            'countPropositions' => $countPropositions,
            'faq'               => $faq
        ]);
    }

    public function actionAnnouncements()
    {

        $model = new MyAnnouncements();

        $dataProvider = $model->search(Yii::$app->request->queryParams);

        if($dataProvider && $dataProvider->getTotalCount()) {
            return $this->render('announcements', [
                'model'        => $model,
                'dataProvider' => $dataProvider,
            ]);
        }
        else {
            return $this->render('announcements_empty');
        }
    }

    public function actionPropositions()
    {

        $model = new ProfilePropositionService();

        // DATE PROVIDERS
        $incomeDataProvider = $model->getIncomeDataProvider(Yii::$app->request->queryParams);
        $outlayDataProvider = $model->getOutlayDataProvider(Yii::$app->request->queryParams);

        // ANNOUNCEMENTS
        list($incomeMyAnnouncements, $incomeExchange) = $model->getIncomeAnnouncements($incomeDataProvider);
        list($outlayAnnouncements, $outlayMyExchange) = $model->getOutlayAnnouncements($outlayDataProvider);

        // TYPE
        $type = '';
        if(isset(Yii::$app->request->queryParams['type'])) {
            $type = Yii::$app->request->queryParams['type'];
        }

        return $this->render('propositions', [
            'incomeMyAnnouncements' => $incomeMyAnnouncements,
            'incomeExchange'        => $incomeExchange,
            'incomeDataProvider'    => $incomeDataProvider,
            'outlayAnnouncements'   => $outlayAnnouncements,
            'outlayMyExchange'      => $outlayMyExchange,
            'outlayDataProvider'    => $outlayDataProvider,
            'type'                  => $type
        ]);
    }

    public function actionFavorites()
    {

        $model = new Favorites();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        if($dataProvider && $dataProvider->getTotalCount()) {
            return $this->render('favorites', [
                'model'        => $model,
                'dataProvider' => $dataProvider,
                'countHiddenAnnouncements' => $model->getCountHiddenAnnouncements()
            ]);
        }
        else {
            return $this->render('favorites_empty');
        }
    }

    public function actionHidden()
    {

        $model = new UserHideAnnouncement();
        $dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('hidden', [
            'model'        => $model,
            'dataProvider' => $dataProvider,
            'countFavorites' => $model->getCountFavorites()
        ]);
    }

    public function actionEdit()
    {

        $model = new UserModel();
        $model->scenario = 'edit';
        $user = Yii::$app->user->identity->getAttributes();
        $model->setAttributes($user, false);

        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('profile/edit'));
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('profile/edit'));

            try {
                if ($eauth->authenticate()) {

                    $attributes = User::getResponseEAuth($eauth);

                    // BIND SOCIAL ID
                    if (!empty($attributes['field']) && !empty($attributes['userId'])) {
                        $user = User::findOne($user['id']);
                        $user->load(['User' => [$attributes['field'] => $attributes['userId']]]);
                        $user->save();
                        Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Profile successfully changed'));
                    }

                    // UPLOAD SOCIAL AVATAR
                    $imageUrl = $attributes['photo'];
                    if($imageUrl) {
                        $filename = User2Image::copySocialImage($imageUrl);

                        $image = new User2Image();
                        $image->user_id    = $user['id'];
                        $image->main_image = $filename;
                        $image->images     = ['0' => $filename];

                        if(User2Image::hasImages($user['id'])) {
                            $db = Yii::$app->db;
                            $db->createCommand("UPDATE user_2_image SET is_main=0 WHERE user_id = {$user['id']}")->query();
                        }

                        $image->addImages();
                    }

                    return $eauth->redirect();
                }
                else {
                    return $eauth->redirect($eauth->getCancelUrl());
                }
            } catch (\nodge\eauth\ErrorException $e) {
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                return $eauth->redirect($eauth->getCancelUrl());
            }
        }

        // IMAGES
        list($images, $mainImage) = User2Image::existsImages(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'Profile successfully changed'));
            return $this->redirect(['/profile']);
        } else {
            return $this->render('edit', [
                'model'     => $model,
                'images'    => $images,
                'mainImage' => $mainImage,
                'user'      => $user
            ]);
        }
    }

    public function actionSubscribe()
    {

        // USER
        $userId = Yii::$app->user->identity->id;

        // MODEL
        $model = MailSubscribe::findOne(['user_id' => $userId]);
        if(NULL == $model) {
            $model = new MailSubscribe();
        }

        // POST
        if($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->save();

            Yii::$app->getSession()->setFlash('success', Yii::t('profile', 'subscribe_success_message'));
            return $this->redirect(['/profile']);
        }

        return $this->render('subscribe', [
            'model' => $model
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasword();

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'change_password_success'));
            return $this->redirect(['/profile']);
        } else {
            return $this->render('change-password', [
                'model' => $model,
            ]);
        }
    }

    public function actionRemovePhone()
    {

        $model = new RemovePhone();
        if(Yii::$app->user->can('removePhoneResendCodeShowLink')) {
            $model->sendRemovePhoneConfirmationSms();
        }

        return $this->redirect(Url::to('/profile/remove-phone-code'));
    }

    public function actionRemovePhoneCode()
    {

        $model = new RemovePhone();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->removePhone();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'remove_phone_success'));
            return Yii::$app->getResponse()->redirect(Url::to(['/profile']));
        }

        $waitingTime = $model->getWaitingTime();

        return $this->render('remove-phone-code', [
            'model'       => $model,
            'waitingTime' => $waitingTime
        ]);
    }

    public function actionRemovePhoneResend()
    {
        if(Yii::$app->user->can('removePhoneResendCodeShowLink')) {
            $model = new RemovePhone();
            $model->sendRemovePhoneConfirmationSms();
            Yii::$app->getSession()->setFlash('success', Yii::t('user', 'confirm_phone_sms_sent'));
        }

        return Yii::$app->getResponse()->redirect(Url::to(['remove-phone-code']));
    }
}
