<h2>Регистрация</h2>
<?php
    use yii\widgets\ActiveForm;
?>

<?php
    $form = ActiveForm::begin(['action' => '/auth/register-submit' ,'class' => 'form-horizontal']);
?>
    <?= $form->field($model, 'login')->textInput(['autofocus' => true])->label('Логин') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    <?= $form->field($model, 'confirmPassword')->passwordInput()->label('Подтвердите пароль') ?>
    <div>
        <button type="submit" class="btn btn-default pull-right">Зарегистрироваться</button>
    </div>
<?php
    ActiveForm::end();
?>