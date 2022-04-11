# SendMessageSendPulse

### Данный скрипт позволяет отправлять сообщения через бот посредством SendPulse.

Данный скрипт является частью логики. Его суть, отправлять уведомления клиенту о предстоящем вебинаре. Внутри Битрикс24 автоматически происходит поиск слота под вебинар, который создан экспертом. Из данного слота получаем ссылку на конференцию Zoom, время проведения и ФИО эксперта.

Конкретно данный скрипт уведомлений работает для ВКонтакте, то есть, к SendPulse должен быть подлкючен бот ВКонтакте. Как это сделать: [Ссылки на документацию 1С-Битрикс и SendPulse](https://github.com/thnik911/SendMessageSendPulse/blob/main/README.md#%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B8-%D0%BD%D0%B0-%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%86%D0%B8%D1%8E-1%D1%81-%D0%B1%D0%B8%D1%82%D1%80%D0%B8%D0%BA%D1%81-%D0%B8-sendpulse).

Если необходимо отпралять сообщения не только через ВКонтакте, а к примеру, через Telegram (И/ИЛИ иной сервис), то необходимо доработать скрипт согласно документации: [Ссылки на документацию 1С-Битрикс и SendPulse](https://github.com/thnik911/SendMessageSendPulse/blob/main/README.md#%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B8-%D0%BD%D0%B0-%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%86%D0%B8%D1%8E-1%D1%81-%D0%B1%D0%B8%D1%82%D1%80%D0%B8%D0%BA%D1%81-%D0%B8-sendpulse).

Не забудьте изменить метод в строке 255, если требуется отправка в иную социальную сеть.

**Механизм работы**:
1. На основании созданного лида происходит поиск слота. Лид создается посредством SendPulse, более подробно о логике создании лида: https://github.com/thnik911/leadAdd
2. Если для клиента удалось найти слот с вебинаром, запускается отдельный бизнес-процесс, который в конструкции имеет вызов Webhook. Всего для отправки из бизнес-процесса предусмотрено 14 уведомдений клинету с разным интервалом. Интревалы отправки настроены бизнес-процессом. 
3. Как только внутри бизнес-процесса достингнут определенный интервал, срабатывает запуск и сообщение отправляется клиенту от имени бота.

<details><summary>Подробнее об интервалах (шагах отправки)</summary>

1 - отправляем сразу как нашли слот для клиента; 
  
2 - отправляем за 3 дня до $dateTime;
  
3 - отправляем за 2 дня до $dateTime;
  
4 - отправляем за 1 день до $dateTime;
  
5 - отправляем за 6 часов до $dateTime;
  
6 - отправляем за 1 час до $dateTime;
  
6.5 - оптравка отдельной ссылки на зум сразу за 6 шагом;
  
7 - отправляем за 15 минут до $dateTime;
  
8 - отправляем за 0 минут до $dateTime;
  
9 - отправляем через 10 минут после $dateTime;
  
10 - отправляем через 15 минут после $dateTime;
  
11 - отправляем через 1 час после $dateTime;
  
11.5 - отправляем еще одно сообщение сразу за 11;
  
12 - отправляем через 3 часа после $dateTime;
  

</details>

Решение может работать как на облачных, так и коробочных Битрикс24. 

**Как запустить**:
1. SendMessage.php и auth.php необходимо разместить на хостинге с поддержкой SSL.
2. В разделе "Разработчикам" необходимо создать входящий вебхук с правами на CRM (crm) и Бизнес-процессы (bizproc). Подробнее как создать входящий / исходящий вебхук: [Ссылки на документацию 1С-Битрикс и SendPulse](https://github.com/thnik911/SendMessageSendPulse/blob/main/README.md#%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B8-%D0%BD%D0%B0-%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%86%D0%B8%D1%8E-1%D1%81-%D0%B1%D0%B8%D1%82%D1%80%D0%B8%D0%BA%D1%81-%D0%B8-sendpulse).
3. Полученный "Вебхук для вызова rest api" прописать в auth.php.
4. На стороне SendPulse необходимо получить client_id и client_secret для авторизации в SendPulse. Подробнее о том, как получить ключи авторизации: [Ссылки на документацию 1С-Битрикс и SendPulse](https://github.com/thnik911/SendMessageSendPulse/blob/main/README.md#%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B8-%D0%BD%D0%B0-%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%86%D0%B8%D1%8E-1%D1%81-%D0%B1%D0%B8%D1%82%D1%80%D0%B8%D0%BA%D1%81-%D0%B8-sendpulse).
5. Полученные "client_id" и "client_secret" прописать в SendMessage.php в одноименные строки 40 и 41.
6. Скрипт разделен конструкциями if / elseif по шагам, где в строку 'text' можно прописать любой текст. Внутри сообщений есть функция 'hex2bin', которая вставляет смайлики в текст сообщений. Подробнее о смайликах можно ознакомиться: [Ссылки на документацию 1С-Битрикс и SendPulse](https://github.com/thnik911/SendMessageSendPulse/blob/main/README.md#%D1%81%D1%81%D1%8B%D0%BB%D0%BA%D0%B8-%D0%BD%D0%B0-%D0%B4%D0%BE%D0%BA%D1%83%D0%BC%D0%B5%D0%BD%D1%82%D0%B0%D1%86%D0%B8%D1%8E-1%D1%81-%D0%B1%D0%B8%D1%82%D1%80%D0%B8%D0%BA%D1%81-%D0%B8-sendpulse)
7. Делаем POST запрос посредством конструкции Webhook* через робот, или бизнес-процессом: https://yourdomain.com/path/SendMessage.php?userId=123&step=1&theme=ТестовыйВеб&zoom=https://zoom.us/&dateTime=01.01.2022&expert=Тестовый&urlForm=testcrmform.com

**Переменные передаваемые в POST запросе:**

yourdomain.com - адрес сайта, на котором размещены скрипты auth.php и SendMessage.php с поддержкой SSL.

path - путь до скрипта.

userId - ID клиента, который присвоен Сендпульсом.

step - № шага для оптравки сообщения.

theme - тема вебинара.

zoom - ссылка на конференцию Zoom.

dateTime - дата и время проведения вебинара

expert - ФИО эксперта

urlForm - форма для получения обратной связи от клиента

### Ссылки на документацию 1С-Битрикс и SendPulse 

<details><summary>Развернуть список</summary>

1. Действие Webhook внутри Бизнес-процесса / робота https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=57&LESSON_ID=8551
2. Как создать Webhook https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=99&LESSON_ID=8581&LESSON_PATH=8771.8583.8581
3. Как получить client_id и client_secret в SendPulse https://sendpulse.com/ru/integrations/api 
4. Как доработать скрипт для отправки через Telegram https://sendpulse.com/ru/integrations/api/chatbot/telegram#/contacts/post_contacts_sendText
5. Как подключить бота в SendPulse https://sendpulse.com/ru/knowledge-base/chatbot
6. Таблица смайликов https://apps.timwhitlock.info/emoji/tables/unicode

</details>

