<li id="message_<?=$message->getId()?>" class="message_item left clearfix">
    <span class="chat-img1 pull-left">
        <img src="https://fakeimg.pl/40/" alt="User Avatar" class="img-circle">
    </span>
    <div class="chat-body1 clearfix">
        <?php 
            $myMessage = Yii::$app->user->id == $message->getUserId() ? ' my_message ' : '';
            $isAdmin = Yii::$app->authManager->getAssignment('admin', $message->getUserId());
            $adminMessage = $isAdmin ? ' admin_message ' : '';
        ?>
        <p class="<?= $myMessage ?> <?= $adminMessage ?> ">
            <span>
                <strong><?= $message->user->getLogin() ?></strong>
                <?php if (Yii::$app->user->can('admin')) :?>
                    <button  title="Заблокировать сообщение" class="pull-right btn btn-default btn-sm" onclick="blockMessage(<?=$message->getId()?>)">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </button> 
                <?php endif ?>
            </span>
            </br>
            
            <?= $message->getText() ?>
            
        </p>
        <div class="chat_time pull-right"><?= $message->getDate() ?></div>
    </div>
</li>