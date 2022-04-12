<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
ini_set('error_reporting', E_ALL);

$userId = $_REQUEST['userId'];
$step = $_REQUEST['step'];
$theme = $_REQUEST['theme'];
$zoom = $_REQUEST['zoom'];
$dateTime = $_REQUEST['dateTime'];
$expert = $_REQUEST['expert'];
$urlForm = $_REQUEST['urlForm'];

//AUTH Б24
require_once 'auth.php';

/* About steps
1 - отправляем сразу как нашли слот для клиента;
2 - отправляем за 3 дня до $dateTime;
3 - отправляем за 2 дня до $dateTime;
4 - отправляем за 1 день до $dateTime;
5 - отправляем за 6 часов до $dateTime;
6 - отправляем за 1 час до $dateTime;
6.5 - оптравка отдельной ссылки на зум сразу за 6;
7 - отправляем за 15 минут до $dateTime;
8 - отправляем за 0 минут до $dateTime;
9 - отправляем через 10 минут после $dateTime;
10 - отправляем через 15 минут после $dateTime;
11 - отправляем через 1 час после $dateTime;
11.5 - отправляем еще одно сообщение сразу за 11;
12 - отправляем через 3 часа после $dateTime;

 */

//получаем ключ авторизации из сендпульса
$data = array(
    'grant_type' => 'client_credentials',
    'client_id' => '', //ID можно получить в личном кабинете SendPulse > Настройки аккаунта > Вкладка API
    'client_secret' => '', //Sectet можно получить в личном кабинете SendPulse > Настройки аккаунта > Вкладка API
);

$ch = curl_init('https://api.sendpulse.com/oauth/access_token');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);

$array = json_decode($res, true);
$token = $array['access_token'];

$Authorization = 'Authorization: Bearer ' . $token . '"';

if ($step == 1) {
    $data = array(
        'contact_id' => $userId,
        'text' => 'Привет! ' . hex2bin('F09F918B') . ' Меня зовут XXX. Я директор онлайн школы XXX.

У нас вы получите знания, которые помогут вам заработать.

Поздравляю Вы успешно записались на вебинар "' .
        $theme . '", который проведет ' . $expert . ' - ведущий эксперт XXX.
Дата и время проведения вебинара ' . $dateTime . '

Ссылку мы отправим за час до занатий.
Увидимся! ' . hex2bin('E29C8A'),
    );
} elseif ($step == 2) {
    $data = array(
        'contact_id' => $userId,
        'text' => hex2bin('F09F918B') . ' Привет!
Это ' . $expert . ' и XXX!
Вы зарегистрировались на мой вебинар ' . $theme . '.' .
        hex2bin('F09F9A80') . ' Стартуем через 3 дня!!! Не забудьте внести в календарь!
Подписывайтесь на канал https://t.me/XXX: актуальные новости финтеха, аналитика рынков, сигналы, стратегии, которые помогут зарабатывать',
    );
} elseif ($step == 3) {
// $data = array(
    //     'contact_id'  => $userId,
    //     'text' => 'Шаг пока не нужен',
    // );
} elseif ($step == 4) {
// $data = array(
    //     'contact_id'  => $userId,
    //     'text' => 'Шаг пока не нужен',
    // );
} elseif ($step == 5) {
    $data = array(
        'contact_id' => $userId,
        'text' => hex2bin('F09F918B') . ' Привет!
Это ' . $expert . ' и XXX

Этот день настал!

Уже через 6 часов я проведу долгожданный вебинар!

К концу вебинара у вас будет чёткий пошаговый план, как и что делать чтобы двигаться к высоким доходам ' . hex2bin('F09F92B5') . '

Вы узнаете:
про современные финансовые технологии;
про рынки, на которых можно делать деньги;
как совершать сделки и предсказывать рынок;
какие знания нужны чтобы зарабатывать;
какие курсы нужно пройти, чтобы получать максимальный результат',
    );
} elseif ($step == 6) {
    $data = array(
        'contact_id' => $userId,
        'text' => hex2bin('E28FB0') . ' Стартуем через час!
Вы готовы?
Не забудьте приготовить блокнот и ручку!
Будет интересно!

Не забудьте скачать zoom. Переходите по ссылке:
https://zoom.us/download

На купюре 100 долларов изображен американский президент Бенжамин Франклин. Он всегда говорил «Инвестиции в знания приносят наибольший доход»',
    );
} elseif ($step == 6.5) {
    sleep(1);
    $data = array(
        'contact_id' => $userId,
        'text' => 'А вот и обещанная ссылка на вебинар
' . hex2bin('F09F92A5') . '
' . $zoom . '',
    );
} elseif ($step == 7) {
    $data = array(
        'contact_id' => $userId,
        'text' => hex2bin('F09F9494') . ' Осталось всего 15 минут до начала эфира ' . hex2bin('E28C9B') . '

Приготовьте себе чай ' . hex2bin('E29895') . ' и устраивайтесь поудобнее

Подключиться к эфиру
' . hex2bin('F09F92A5') . ' ' . hex2bin('F09F92A5') . ' ' . hex2bin('F09F92A5') . ' ' . $zoom . '

Мы собираемся!
Ждем вас в онлайн комнате. Скоро начнем! ',
    );
} elseif ($step == 8) {
    $data = array(
        'contact_id' => $userId,
        'text' => '' . hex2bin('F09F948A') . ' ' . hex2bin('F09F948A') . ' ' . hex2bin('F09F948A') . ' Я уже в эфире!
Вы с нами?
Присоединяйтесь скорее! Пропустите самое интересное! ' . hex2bin('F09F92B8') . '
Подключиться к эфиру
' . hex2bin('F09F92A5') . ' ' . hex2bin('F09F92A5') . ' ' . hex2bin('F09F92A5') . ' ' . $zoom . ' ',
    );
} elseif ($step == 9) {
    $data = array(
        'contact_id' => $userId,
        'text' => 'Вы все еще не с нами?

Пропускаете самое важное! ' . hex2bin('F09F92B9') . '

Присоединяйитесь!

Подключиться к эфиру
' . hex2bin('F09F92A5') . ' ' . hex2bin('F09F92A5') . ' ' . hex2bin('F09F92A5') . ' ' . $zoom . ' ',
    );
} elseif ($step == 10) {
    $data = array(
        'contact_id' => $userId,
        'text' => 'ВНИМАНИЕ!!!
Хотим убедиться, что у Вас не возникло никаких проблем с подключением к вебинару. Для этого перейдите по ссылке и ответьте на 1 вопрос. ' . $urlForm . '',
    );
} elseif ($step == 11) {
    $data = array(
        'contact_id' => $userId,
        'text' => '' . hex2bin('F09F918B') . ' Это ' . $expert . ' и XXX!

Всем кто был на вебинаре - СПАСИБО! Приятно было слышать ваше СПАСИБО!

Но мы привыкли оценивать свои успехи по вашим успехам. Поэтому спасибо вы скажете чуть позже, когда заработаете свой первый икс!

Теперь вы поняли, что биржи и трейдинг не так страшен, как вы думали пару часов назад.
Это доступно каждому!

Чтобы достичь успехов, необходимо научиться прогнозировать поведение цен на рынке.
Знание куда пойдет цена - деньги.',
    );
} elseif ($step == 11.5) {
    sleep(1);
    $data = array(
        'contact_id' => $userId,
        'text' => 'Вы получили топ 5 стратегий. Чтобы правильно ими пользоваться нужно знать ряд нюансов

Теперь самое время приобрести курс со скидкой!

Переходите по ссылке, которую вы получили на вебинаре.

Если пропустили, присоединяйтесь в ближайший понедельник или четверг в 19-00
Анонс и ссылка будет в нашем телеграм канале

XXX
Учись, думай, зарабатывай! «Инвестиции в знания приносят наибольший доход» — Бенджамин Франклин

https://XXX/',
    );
} elseif ($step == 12) {
    $data = array(
        'contact_id' => $userId,
        'text' => '' . hex2bin('F09F918B') . ' Это ' . $expert . ' и XXX!

Вы уже приобрели мой курс?

Если нет, то спешите. Чем раньше вы начнете, тем больше сможете заработать.

Увидимся!

Оставайтесь на связи.

XXX
«Инвестиции в знания приносят наибольший доход» — Бенджамин Франклин

Наш сайт: https://XXX/
Наш телеграм канал: https://t.me/XXX',
    );
}

$ch = curl_init('https://api.sendpulse.com/vk/contacts/sendText');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $Authorization));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);
$array = json_decode($res, true);

function executeREST($method, array $params, $domain, $auth, $user)
{
    $queryUrl = 'https://' . $domain . '/rest/' . $user . '/' . $auth . '/' . $method . '.json';
    $queryData = http_build_query($params);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));
    return json_decode(curl_exec($curl), true);
    curl_close($curl);
}

function writeToLog($data, $title = '')
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/logs/SendVK.log', $log, FILE_APPEND);
    return true;
}
