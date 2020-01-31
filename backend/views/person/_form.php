<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Persons */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="persons-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-4">
	        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
	        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
	        <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
		    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
		    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
		    <?= $form->field($model, 'avatar')->fileInput() ?>
        </div>
        <div class="col-md-6">
		    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
		    <?= $form->field($model, 'hobbies')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <hr>
    <div class="dynamic-form">
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Education skills</h4></div>
            <div class="panel-body">
			    <?php DynamicFormWidget::begin([
				    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
				    'widgetBody' => '.container-items1', // required: css class selector
				    'widgetItem' => '.item1', // required: css class
				    'limit' => 20, // the maximum times, an element can be cloned (default 999)
				    'min' => 1, // 0 or 1 (default 1)
				    'insertButton' => '.add-item', // css class
				    'deleteButton' => '.remove-item', // css class
				    'model' => $modelsEducations[0],
				    'formId' => 'dynamic-form',
				    'formFields' => [
					    'title',
					    'from_date',
					    'to_date',
					    'description',
				    ],
			    ]); ?>

                <div class="container-items1"><!-- widgetContainer -->
				    <?php foreach ($modelsEducations as $i => $modelEducation): ?>
                        <div class="item1 panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Education skills</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
							    <?php
							    // necessary for update action.
							    if (! $modelEducation->isNewRecord) {
								    echo Html::activeHiddenInput($modelEducation, "[{$i}]id");
							    }
							    ?>
                                <div class="row">
                                    <div class="col-sm-6">
		                                <?= $form->field($modelEducation, "[{$i}]from_date")->input('date') ?>
                                    </div>
                                    <div class="col-sm-6">
		                                <?= $form->field($modelEducation, "[{$i}]to_date")->input('date') ?>
                                    </div>
                                    <div class="col-sm-12">
									    <?= $form->field($modelEducation, "[{$i}]title")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-12">
									    <?= $form->field($modelEducation, "[{$i}]description")->textarea(['rows' => 6]) ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
				    <?php endforeach; ?>
                </div>
			    <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Works experience</h4></div>
            <div class="panel-body">
			    <?php DynamicFormWidget::begin([
				    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
				    'widgetBody' => '.container-items2', // required: css class selector
				    'widgetItem' => '.item2', // required: css class
				    'limit' => 20, // the maximum times, an element can be cloned (default 999)
				    'min' => 1, // 0 or 1 (default 1)
				    'insertButton' => '.add-item2', // css class
				    'deleteButton' => '.remove-item2', // css class
				    'model' => $modelsWorks[0],
				    'formId' => 'dynamic-form',
				    'formFields' => [
					    'title',
					    'from_date',
					    'to_date',
					    'description',
				    ],
			    ]); ?>

                <div class="container-items2"><!-- widgetContainer -->
				    <?php foreach ($modelsWorks as $k => $modelWork): ?>
                        <div class="item2 panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <h3 class="panel-title pull-left">Works experience</h3>
                                <div class="pull-right">
                                    <button type="button" class="add-item2 btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                    <button type="button" class="remove-item2 btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
							    <?php
							    // necessary for update action.
							    if (! $modelWork->isNewRecord) {
								    echo Html::activeHiddenInput($modelWork, "[{$k}]id");
							    }
							    ?>
                                <div class="row">
                                    <div class="col-sm-6">
		                                <?= $form->field($modelWork, "[{$k}]from_date")->input('date') ?>
                                    </div>
                                    <div class="col-sm-6">
		                                <?= $form->field($modelWork, "[{$k}]to_date")->input('date') ?>
                                    </div>
                                    <div class="col-sm-12">
									    <?= $form->field($modelWork, "[{$k}]title")->textInput(['maxlength' => true]) ?>
                                    </div>
                                    <div class="col-sm-12">
									    <?= $form->field($modelWork, "[{$k}]description")->textarea(['rows' => 6]) ?>
                                    </div>
                                </div><!-- .row -->
                            </div>
                        </div>
				    <?php endforeach; ?>
                </div>
			    <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
        <br>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php
$url = \yii\helpers\Url::toRoute(['person/render-works-form']);
$jsContent = <<< JS
    $(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
        console.log("beforeInsert");
    });
    
    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        console.log("afterInsert");
    });
    
    $(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
        if (! confirm("Are you sure you want to delete this item?")) {
            return false;
        }
        return true;
    });
    
    $(".dynamicform_wrapper").on("afterDelete", function(e) {
        console.log("Deleted item!");
    });
    
    $(".dynamicform_wrapper").on("limitReached", function(e, item) {
        alert("Limit reached");
    });
JS;
$this->registerJs($jsContent, \yii\web\View::POS_END)
?>
</div>
