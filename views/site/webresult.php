<?php

/** @var yii\web\View $this */

$this->title = 'Web Controller';

/** @var $data */
?>

<link rel="stylesheet" href="../css/index.css">

<div class="site-about">
    <div class="site-index" id="app">
        <div class="jumbotron text-center bg-transparent">
            <h1 class="display-6">Получение кадастровых данных WebController</h1>

            <form action="webresult" method="GET">
                <div class="form-container">
                    <div class="form-group">
                        <label for="cn" style="float: left">
                            <b>Кадастровые номера</b>
                        </label>
                        <input type="text" v-model="cnModel" class="form-control" id="cns" name="cns" required>
                    </div>

                    <button type="submit" class="btn btn-lg btn-success">Получить данные
                    </button>
                </div>
            </form>
        </div>

        <?php if (!empty($data)): ?>
        <div class="jumbotron text-center bg-transparent" style="margin-top: 30px">
            <div class="jumbotron text-center bg-transparent">
                <h1 class="display-6" style="float: left; font-size: calc(1.375rem + -0.5vw); margin-left: 10px;">Всего
                    записи: <?= count($data) ?>
                </h1>
                <div class="form-container">
                    <table class="file-table">
                        <tr>
                            <th>Кадастровый номер</th>
                            <th>Адрес</th>
                            <th>Стоимость</th>
                            <th>Площадь</th>
                            <th>Дата обновления</th>
                        </tr>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= $row->cadastr_number; ?></td>
                                <td><?= $row->address; ?></td>
                                <td><?= $row->price; ?></td>
                                <td><?= $row->area; ?></td>
                                <td><?= $row->date_update; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>