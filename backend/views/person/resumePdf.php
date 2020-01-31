<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resume target.uz</title>
</head>
<body>
    <div class="wrapper">
        <hr>
        <div class="avatar-content" style="width: 50%;  justify-content: center; display: inline-block; float: left; clear: both;">
            <div style="width: 200px; text-align: center;">
                <img class="avatar" src="<?= \yii\helpers\Url::to('@web/uploads/'). $model->avatar?>" alt="">
            </div>
        </div>
        <div class="avatar-content" style="width: 50%; display: inline-block;">
            <div style="padding: 1px 20px">
                <h4><?= $model->firstname .' '. $model->lastname .' '. $model->middlename ?></h4>
                <hr>
                <ul style="list-style: none">
                    <li><b>Address:</b> <?= $model->address?></li>
                    <li><b>Phone:</b> <?= $model->phone?></li>
                    <li><b>Email:</b> <?= $model->email?></li>
                    <li><b>Hobbies:</b> <?= $model->hobbies?></li>
                </ul>
            </div>
        </div>
        <br>
        <br>
        <br>
        <hr>
        <h2>Work Experience</h2>
        <?php foreach ($model->works as $work): ?>
            <p style="background-color: rgba(142,175,189,0.31); padding: 12px"><?= $work->title?></p>
            <p style="color: grey"><small><?= $work->from_date?> - <?= $work->to_date?></small></p>
            <p><?= $work->description?></p>
            <hr>
        <?php endforeach;?>
        <br>
        <pagebreak/>
        <h2>Education Skills</h2>
	    <?php foreach ($model->education as $education): ?>
            <p style="background-color: rgba(142,175,189,0.31); padding: 12px"><?= $education->title?></p>
            <p style="color: grey"><small><?= $education->from_date?> - <?= $education->to_date?></small></p>
            <p><?= $education->description?></p>
            <hr>
	    <?php endforeach;?>
    </div>
</body>
</html>