<div class="main_section">
   <div class="container">
      <div class="chat_container">
    
      <?php if (Yii::$app->user->can('admin')) :?>
      <div class="col-sm-3 chat_sidebar">
            <div class="row">
                <div class="sidebar_header">
                    Пользователи
                </div>
                <div id="users_block" class="member_list">
                    <ul class="list-unstyled">
                        <?php foreach($users as $user) : ?>
                            <?= $this->context->renderPartial('member', ['user' => $user]) ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
         </div>
        <?php endif ?>
		
        <div class="col-sm-<?=Yii::$app->user->can('admin') ? 6 : 12 ?> message_section">
		    <div class="row">
		        <div class="new_message_head">
                    <div class="pull-left">
                        Сообщения
                    </div>
                </div>
		 
                <div class="chat_area">
                    <div id="hello_message">
                        <strong><?= Yii::$app->user->identity->login ?: 'Гость' ?>, Рады тебя видеть в нашем чате! </strong>
                    </div>
                    <ul id="messages_box" class="list-unstyled">
                        <?php foreach ($messages as $message) :?>
                            <?= $this->context->renderPartial('message', ['message' => $message]) ?>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="message_write">
                    <?php
                        $form = \yii\widgets\ActiveForm::begin([
                            'id' => 'newMessageForm',
                            'action' => '/chat/new-message',
                            'method'=>'post',
                            'enableAjaxValidation' => false,
                        ]);
                        ?>
                        <?php 
                            $placeholderText =  Yii::$app->user->isGuest 
                                ? 'Чтобы писать сообщения необходимо выполнить вход.'
                                : 'Введите сообщение'
                        ?>
                        <?= $form->field($model, 'text')->textarea(['readonly' => Yii::$app->user->isGuest, 'placeholder' => $placeholderText]); ?>
                        <div class="clearfix"></div>
                        <div class="chat_bottom">
                            <button type="submit" class="pull-right btn btn-success" <?= Yii::$app->user->isGuest ? 'disabled' : '' ?> >
                                 Отправить <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </button>
                        </div>
                    <?php $form->end(); ?>
		        </div>
            </div>
        </div>
        
        <?php if (Yii::$app->user->can('admin')) :?>
        <div class="col-sm-3 chat_sidebar">
            <div class="row">
                <div class="sidebar_header">
                    Заблокированные сообщения
                </div>
                <div id="blocked_messages_list" class="member_list">
                    
                </div>
            </div>
        </div>
        <?php endif ?>
        
   </div>
</div>

<?php
    $this->registerJsFile(
        '@web/js/chat.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );

    if (Yii::$app->user->can('admin')) {
        $this->registerJsFile(
            '@web/js/updateBlockedMessages.js',
            ['depends' => [\yii\web\JqueryAsset::class]]
        );
    }
?>