<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<div class="row">
<br>
</div>
<p>
	<?= Html::a('Update', ['update-profile', 'id' => Yii::$app->user->getId()], ['class' => 'btn btn-primary']) ?>
</p>

<?= DetailView::widget([
	'model' => $profile,
        'attributes' => [
		'fullname',
		'email:email',
		'gender',
		'phone',
		'address',
		'province',
		'city',
		'district',
		'subdistrict',
		'postcode',
	],
]) ?>