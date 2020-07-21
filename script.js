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
var handler_timer = false;
var status_timer = false;

function handler_request(url, interval, success, headers, hash)
{
    var status = document.querySelector('#status');

    status.innerHTML = 'Execution...';

    status_timer = true;
    timer_start(0);

    var request = $.ajax({
        url: "/handler.php",
        method: "POST",
        data: {
            url: url,
            success: success,
            headers: headers,
            hash: hash,
            method: "GET"
        },
        dataType: "html"
    });

    request.done(function(msg) {
        status.innerHTML = msg;
        status_timer = false;

        if (handler_timer == true) setTimeout(handler_timeout_callback, interval*60000, url, interval, success, headers, hash);

    });
    
    request.fail(function(jqXHR, textStatus) {
        status.innerHTML = textStatus;
        status_timer = false;

        if (handler_timer == true) setTimeout(handler_timeout_callback, interval*60000, url, interval, success, headers, hash);

    });
}

function handler_timeout_callback(url, interval, success, headers, hash)
{
    if (handler_timer == true) handler_request(url, interval, success, headers, hash);
}

function handler_start()
{
    var url = document.querySelector('#url').value;
    var interval = document.querySelector('#interval').value;
    var success = document.querySelector('#success').value;
    var headers = document.querySelector('#headers').value;
    var hash = document.querySelector('#hash').value;
    var run_button = document.querySelector('#run_button');
    var stop_button = document.querySelector('#stop_button');

    handler_timer = true;

    if (!run_button.hasAttribute('disabled')) run_button.setAttribute('disabled', '');

    if (stop_button.hasAttribute('disabled')) stop_button.removeAttribute('disabled');

    handler_request(url, interval, success, headers, hash);
}

function handler_stop()
{
    var status = document.querySelector('#status');
    var timer = document.querySelector('#timer');
    var run_button = document.querySelector('#run_button');
    var stop_button = document.querySelector('#stop_button');

    handler_timer = false;

    if (run_button.hasAttribute('disabled')) run_button.removeAttribute('disabled');

    if (!stop_button.hasAttribute('disabled')) stop_button.setAttribute('disabled', '');

    status.innerHTML = 'Stopped by user.';
    timer.innerHTML = '';

    setTimeout(window.location.reload(), 2000);
}

function timer_start(seconds)
{
    var timer = document.querySelector('#timer');

    if (status_timer == true) {

        timer.innerHTML = seconds+' sec.';

        setTimeout(timer_timeout_callback, 1000, seconds + 1);

    }
}

function timer_timeout_callback(seconds)
{
    if (status_timer == true) timer_start(seconds);
}