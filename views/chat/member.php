<li id="member_block_<?=$user->getId()?>" class="left clearfix">
    <span class="chat-img pull-left">
        <img src="https://fakeimg.pl/40/" alt="User Avatar" class="img-circle">
    </span>
    <div class="chat-body clearfix">
        <div class="header_sec">
            <strong class="primary-font">
                <!-- <i class="online fa fa-circle" aria-hidden="true"></i> -->
                <?= $user->getLogin() ?>
                (<?= implode(', ', array_keys(Yii::$app->authManager->getRolesByUser($user->getId()))) ?>)
            </strong> 
            <div class="dropdown pull-right">
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Роль
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a onclick="changeUserRole(<?=$user->getId()?>, 'user')">Пользователь</a></li>
                    <li><a onclick="changeUserRole(<?=$user->getId()?>, 'admin')">Админ</a></li>
                </ul>
            </div>
        </div>
    </div>
</li>