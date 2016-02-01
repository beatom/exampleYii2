<div class="breadcrumbs clearfix">
    <ul>
        <li>
            <a href="/"><?= Yii::t('profile', 'breadcrumbs_main') ?></a>
        </li>
        <li>
            <a href="/profile"><?= Yii::t('profile', 'breadcrumbs_profile') ?></a>
        </li>
        <?php if($crumb): ?>
            <li><?= $crumb ?></li>
        <?php endif; ?>
    </ul>
</div>