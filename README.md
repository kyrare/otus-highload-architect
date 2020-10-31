# Проект для выполнения домашних заданий курса [Highload Architect](https://otus.ru/lessons/highloadarchitect/)


Основано на [docker-compose-laravel](https://github.com/aschmelyun/docker-compose-laravel)

Пример команд для запуска artisan через docker

- `docker-compose run --rm composer install`
- `docker-compose run --rm npm run dev`
- `docker-compose run --rm artisan migrate` 

## Домашние задания

### №1 Заготовка для социальной сети

*Цель:* В результате выполнения ДЗ вы создадите базовый скелет социальной сети, который будет развиваться в дальнейших ДЗ.

*В данном задании тренируются навыки:*
- декомпозиции предметной области;
- построения элементарной архитектуры проекта

Требуется разработать создание и просмотр анект в социальной сети.

*Функциональные требования:*
- Авторизация по паролю.
- Страница регистрации, где указывается следующая информация:
    1) Имя
    1) Фамилия
    1) Возраст
    1) Пол
    1) Интересы
    1) Город
- Страницы с анкетой.

*Нефункциональные требования:*
- Любой язык программирования
- В качестве базы данных использовать MySQL
- Не использовать ORM
- Программа должна представлять из себя монолитное приложение.
- Не рекомендуется использовать следующие технологии:
    1) Репликация
    1) Шардинг
    1) Индексы
    1) Кэширование


Верстка не важна. Подойдет самая примитивная.

Разместить приложение на любом хостинге. Например, heroku.

*Требования:*
Есть возможность регистрации, создавать персональные страницы, возможность подружиться, список друзей.
Отсутствуют SQL-инъекции.
Пароль хранится безопасно.

### №2 Производительность индеков

*Цель:* В результате выполнения ДЗ вы создадите набор тестовых данных для проведения нагрузочного тестирования, подберете наиболее подходящие индексы и проведете тесты производительности.

В данном задании тренируются навыки:
- генерация тестовых данных;
- работа с индексами;
- нагрузочное тестирование;
    1) Сгенерировать любым способ 1,000,000 анкет. Имена и Фамилии должны быть реальными (чтобы учитывать селективность индекса)
    1) Реализовать функционал поиска анкет по префиксу имени и фамилии (одновременно) в вашей социальной сети (запрос в форме firstName LIKE ? and secondName LIKE ?). Сортировать вывод по id анкеты. Использовать InnoDB движок.
    1) С помощью wrk провести нагрузочные тесты по этой странице. Поиграть с количеством одновременных запросов. 1/10/100/1000.
    1) Построить графики и сохранить их в отчет
    1) Сделать подходящий индекс.
    1) Повторить пункт 3 и 4.
    1) В качестве результата предоставить отчет в котором должны быть:
- графики latency до индекса;
- графики throughput до индекса;
- графики latency после индекса;
- графики throughput после индекса;
- запрос добавления индекса;
- explain запросов после индекса;
- объяснение почему индекс именно такой;

ДЗ принимается в виде отчета по выполненной работе.
*Критерии оценки:* Оценка происходит по принципу зачет/незачет.

*Требования:*
Правильно выбраны индексы.
Нагрузочное тестирование проведено и результаты адекватны.

### №3 Полусинхронная репликация 

*Цель:* В результате выполнения ДЗ вы настроите полусинхронную репликацию, протестируете ее влияние на производительность системы и убедитесь, что теперь вы не теряете транзакции в случае аварии.

*В данном задании тренируются навыки:*
- обеспечение отказоустойчивости проекта;
- администрирование MySQL;
- настройка репликации;
- проведение нагрузочных тестов.
    1) Настраиваем асинхронную репликацию.
    1) Выбираем 2 любых запроса на чтения (в идеале самых частых и тяжелых по логике работы сайта) и переносим их на чтение со слейва.
    1) Делаем нагрузочный тест по странице, которую перевели на слейв до и после репликации. Замеряем нагрузку мастера (CPU, la, disc usage, memory usage).
    1) ОПЦИОНАЛЬНО: в качестве конфига, который хранит IP реплики сделать массив для легкого добавления реплики. Это не самый правильный способ балансирования нагрузки. Поэтому опционально.
    1) Настроить 2 слейва и 1 мастер.
    1) Включить row-based репликацию.
    1) Включить GTID.
    1) Настроить полусинхронную репликацию.
    1) Создать нагрузку на запись в любую тестовую таблицу. На стороне, которой нагружаем считать, сколько строк мы успешно записали.
    1) С помощью kill -9 убиваем мастер MySQL.
    1) Заканчиваем нагрузку на запись.
    1) Выбираем самый свежий слейв. Промоутим его до мастера. Переключаем на него второй слейв.
    1) Проверяем, есть ли потери транзакций.

Результатом сдачи ДЗ будет в виде исходного кода на github и отчета в текстовом виде, где вы отразите как вы выполняли каждый из пунктов.
*Критерии оценки:* Оценка происходит по принципу зачет/незачет.

*Требования:*
- В отчете корректно описано, как настроена репликация.
- 2 запроса переведено на чтение со слейва.
- Нагрузочное тестирование показало, что нагрузка перешла на слейв.
- В отчете описано как включить row-based репликацию и GTID
- Проведен эксперимент по потере и непотере транзакций при аварийной остановке master.