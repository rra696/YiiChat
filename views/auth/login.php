<h2>Логин</h2>
<?php use yii\widgets\ActiveForm; ?>

<?php $form = ActiveForm::begin(['action' => '/auth/login-submit', 'class' => 'form-horizontal']); ?>
    <?= $form->field($model, 'login')->textInput(['autofocus' => true])->label('Логин') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    <div>
        <button type="submit" class="btn btn-default pull-right">Войти</button>
    </div>
<?php ActiveForm::end(); ?>