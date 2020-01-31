<?php
use kartik\date\DatePicker;
use mihaildev\ckeditor\CKEditor;
?>
<div class="row">
    <div class="col-md-12">
		<?php
		echo DatePicker::widget([
			'name' => "from_date",
			'type' => DatePicker::TYPE_RANGE,
			'name2' => "to_date",
			'attribute' => "from_date",
			'attribute2' => "to_date",
			'options' => ['placeholder' => 'Start date'],
			'options2' => ['placeholder' => 'End date'],
			'pluginOptions' => [
				'autoclose' => true,
				'format' => 'yyyy-mm-dd'
			]
		]);
		?>
    </div>
    <div class="col-md-12">
        <input type="text" name="title" class="form-control">
    </div>
    <div class="col-md-12">
        <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
    </div>
</div>