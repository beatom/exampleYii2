<div class="half block">
    <h5><?= Yii::t('profile', 'edit_avatar') ?></h5>

    <?php
        $mainFilepath = '';
        $mainFilename = '';
        if(isset($mainImage['filepath'])) {
            $mainFilepath = $mainImage['filepath'];
        }
        if(isset($mainImage['filename'])) {
            $mainFilename = $mainImage['filename'];
        }
    ?>

    <div class="profile-avatar-edit-main">
        <?php if($mainFilepath): ?>
            <img id="mainImg" src="<?= $mainFilepath ?>" />
        <?php else: ?>
            <img id="mainImg" src="/img/no-avatar.png" />
        <?php endif; ?>

        <input type="hidden" name="User[main_image]" id="mainFile" value="<?= $mainFilename ?>" />

        <div class="profile-avatar-edit-buttons">

            <!-- ЗАГРУЗИТЬ -->
            <p>
                <div id="uploader"></div>
                <script type="text/template" id="qq-template">
                    <div class="qq-uploader-selector qq-uploader">
                        <div class="qq-upload-button-selector qq-upload-button" style="width:163px;">
                            <a href="#" class="button button-lite">Загрузить новый</a>
                        </div>

                        <ul class="qq-upload-list-selector qq-upload-list">
                            <li></li>
                        </ul>
                    </div>
                </script>
            </p>

            <!-- УДАЛИТЬ -->
            <?php
                $style='display:none;';
                if($mainFilepath) {
                    $style = '';
                }
            ?>
            <p id="deleteBlock" style="<?= $style ?>">
                <a href="" id="deleteButton" class="button button-lite"><?= Yii::t('profile', 'edit_delete_photo') ?></a>
            </p>
        </div>
    </div>

    <!-- ГАЛЕРЕЯ -->
    <ul class="profile-avatar-list clearfix">
        <li id="photoTemplate" style="display:none;">
            <a class="galleryImage" href="">
                <img src="" alt="">
            </a>
            <div class="del-lite"></div>
            <input type="hidden" name="User[images][]" disabled />
        </li>

        <?php if(count($images)): ?>
            <?php foreach($images as $image): ?>
                <li>
                    <a class="galleryImage" href="">
                        <img src="<?= $image['filepath'] ?>" alt="" />
                    </a>
                    <div class="del-lite"></div>
                    <input type="hidden" name="User[images][]" value="<?= $image['filename'] ?>" />
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
