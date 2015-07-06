<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $model common\models\Profile */

$this->title = empty($profile->fullname) ? Html::encode($profile->user->username) : Html::encode($profile->fullname);
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['show','id'=>$profile->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
    	<div class="col-md-12">
    	<?= Menu::widget([
    		 'options' => [
                    'class' => 'nav nav-pills'
                ],
                'activateItems' => false,
                'encodeLabels' => false,
                'items' => [
                    // Important: you need to specify url as 'controller/action',
                    // not just as 'controller' even if default action is used.
                    ['label' => 'Detail Profile', 'url' => ['profile/show', 'id'=>$profile->user->id], 'active' => true],
                    ['label' => 'Educations', 'url' => ['profile/educations','id'=>$profile->user->id], 'active' => false],

                ],
    	])?>
    	<hr>
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
    	</div>    	
    </div>
</div>
