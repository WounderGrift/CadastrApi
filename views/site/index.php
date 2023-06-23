<?php
$this->title = 'Rest Controller';
?>

<link rel="stylesheet" href="css/index.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>

<div class="site-index" id="app">
    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-6">Получение кадастровых данных RestController</h1>

        <form onsubmit="return false;">
            <div class="form-container">
                <div class="form-group">
                    <label for="cn" style="float: left">
                        <b>Кадастровые номера</b>
                    </label>
                    <input type="text" v-model="cnModel" class="form-control" id="cns" name="cns" required>
                </div>

                <button @click="getTableCN()" class="btn btn-lg btn-success">Получить данные</button>
            </div>
        </form>
    </div>

    <div class="jumbotron text-center bg-transparent" style="margin-top: 30px" v-if="cnInfo">
        <div class="jumbotron text-center bg-transparent">
            <h1 class="display-6" style="float: left; font-size: calc(1.375rem + -0.5vw); margin-left: 10px;">Всего
                записи: {{ cnInfo.length }}
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
                    <tr v-for="info in cnInfo" :key="cnInfo.id">
                        <td>{{info.cadastr_number}}</td>
                        <td>{{info.address}}</td>
                        <td>{{info.price}}</td>
                        <td>{{info.area}}</td>
                        <td>{{info.date_update}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="module" src="index.js"></script>