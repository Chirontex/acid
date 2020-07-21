<?php
/*
    Copyright (C) 2020  Dmitry Shumilin (dmitri.shumilinn@yandex.ru)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/
require_once __DIR__.'/config.php';

if (!file_exists(__DIR__.'/bootstrap.min.css')) file_put_contents(__DIR__.'/bootstrap.min.css', file_get_contents('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css'));

if (!file_exists(__DIR__.'/jquery-3.5.1.js')) file_put_contents(__DIR__.'/jquery-3.5.1.js', file_get_contents('https://code.jquery.com/jquery-3.5.1.js'));

if (!file_exists(__DIR__.'/popper.min.js')) @file_put_contents(__DIR__.'/popper.min.js', file_get_contents('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'));

if (!file_exists(__DIR__.'/bootstrap.min.js')) file_put_contents(__DIR__.'/bootstrap.min.js', file_get_contents('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js'));

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>After Cron is Dead</title>
    <link type="text/css" rel="stylesheet" href="<?php if (file_exists(__DIR__.'/bootstrap.min.css')) echo ACID_HOST;else echo 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css'; ?>/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?= ACID_HOST ?>/style.css">
    <script src="<?php if (file_exists(__DIR__.'/jquery-3.5.1.js')) echo ACID_HOST;else echo 'https://code.jquery.com'; ?>/jquery-3.5.1.js"></script>
    <script src="<?php if (file_exists(__DIR__.'/popper.min.js')) echo ACID_HOST;else echo 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd'; ?>/popper.min.js"></script>
    <script src="<?php if (file_exists(__DIR__.'/bootstrap.min.js')) echo ACID_HOST;else echo 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js'; ?>/bootstrap.min.js"></script>
    <script src="<?= ACID_HOST ?>/script.js"></script>
</head>
<body>
    <div class="container main">
        <h1>After Cron is Dead</h1><br>
        <form action="" method="POST">
            <p><label for="url">URL:</label><input type="text" id="url" name="url" class="form-control"></p>
            <p>
                <label for="interval">Time interval, minutes:</label>
                <select id="interval" name="interval" class="form-control">
                    <option value="1" selected>1</option>
                    <option value="5">5</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                </select>
            </p>
            <p><label for="success">Success phrase:</label><input type="text" id="success" name="success" class="form-control"></p>
            <p>
                <label for="headers">Query headers:</label>
                <textarea id="headers" name="headers" cols="50" rows="13" class="form-control"><?=
"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3
Accept-Encoding: gzip, deflate
DNT: 1
Connection: keep-alive
Upgrade-Insecure-Requests: 1"
            ?></textarea>
            </p>
            <input type="hidden" id="hash" name="hash" value="<?= password_hash($password, PASSWORD_DEFAULT) ?>">
            <button type="button" class="btn btn-primary" id="run_button" onclick="handler_start();">Run</button>
            <button type="button" class="btn btn-secondary" id="stop_button" onclick="handler_stop();" disabled="">Stop</button>
        </form>
        <p id="status"></p>
        <p id="timer"></p>
    </div>
</body>
</html>