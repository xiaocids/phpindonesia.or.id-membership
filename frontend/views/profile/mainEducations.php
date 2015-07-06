<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Menu;

$this->title = 'Educations';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['show','id'=>$id]];
$this->params['breadcrumbs'][] = $this->title;
?>
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
                    ['label' => 'Detail Profile', 'url' => ['profile/show', 'id'=>$id], 'active' => false],
                    ['label' => 'Educations', 'url' => ['profile/educations','id'=>$id], 'active' => true],

                ],
    	])?>
    	<hr>
		<p>
			<?= Html::a('Add Education', ['add-edu', 'id'=>$id], ['class' => 'btn btn-success']) ?>
		</p>
		
		<?php Pjax::begin()?>
		<?= GridView::widget([
			'dataProvider' => $educations,
			'columns' => [
			['class' => 'yii\grid\SerialColumn'],
		
				//'id',
				//'user_id',
				'institution_name',
				'institution_type',
				'institution_location:ntext',
				'from_date',
				'to_date',
				'graduated_status',
				'gpa',
				'gpa_max',
				'description:ntext',
				[
					'class' => 'yii\grid\ActionColumn',
    				'template' => '{update} {delete}',
    				'header' => 'Actions',
    				'urlCreator' => function ($action, $model, $key, $index) {
    					if ($action === 'update') {
    						$url = Yii::$app->urlManager->createUrl(['profile/update-edu', 'id'=>$model->id]); // your own url generation logic
    						return $url;
    					}elseif ($action === 'delete') {
    						$url = Yii::$app->urlManager->createUrl(['profile/delete-edu', 'id'=>$model->id]); // your own url generation logic
    						return $url;
    					}
    				}
                	
    			],
			],
		]); ?>
		<?php Pjax::end()?>   	
    </div>
</div>
		