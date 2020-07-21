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

if (isset($_POST['url']) &&
    isset($_POST['method']) &&
    isset($_POST['headers']) &&
    isset($_POST['success']) &&
    isset($_POST['hash'])) {

    if (password_verify($password, $_POST['hash'])) {

        if (empty($_POST['url'])) echo 'Error: empty URL; -3';
        else {

            $ch = curl_init($_POST['url']);

            if ($_POST['method'] === 'POST') {

                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

                if (isset($_POST['request'])) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_POST['request']));

            } else curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, explode("\n", $_POST['headers']));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $result = curl_exec($ch);

            if (empty($_POST['success'])) $output = $result.' ';
            else {

                if (strpos($result, $_POST['success']) === false) $output = 'Fail! ';
                else $output = 'Success! ';

            }

            echo $output.date('H:i:s');

        }

    } else echo 'Error: Access error; -2';

} else echo 'Error: Too few arguments; -1';
