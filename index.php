<?php
declare(strict_types=1);

// Определение констант для операций
const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

// Массив с описаниями операций
$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

// Инициализация списка покупок
$items = [];

// Функция для отображения списка покупок
function displayItems(array $items): void {
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode(PHP_EOL, $items) . PHP_EOL;
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
}

// Функция для запроса операции у пользователя
function getOperation(array $operations): int {
    do {
        // Вывод доступных операций
        echo 'Выберите операцию для выполнения: ' . PHP_EOL;
        echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';

        // Чтение номера операции от пользователя
        $operationNumber = (int)trim(fgets(STDIN));

        // Проверка на корректность выбранной операции
        if (!array_key_exists($operationNumber, $operations)) {
            system('clear');
            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }
    } while (!array_key_exists($operationNumber, $operations));

    return $operationNumber;
}

// Функция для добавления товара в список покупок
function addItem(array &$items): void {
    echo "Введите название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    if ($itemName !== '') {
        $items[] = $itemName;
    }
}

// Функция для удаления товара из списка покупок
function deleteItem(array &$items): void {
    displayItems($items);

    echo 'Введите название товара для удаления из списка:' . PHP_EOL . '> ';
    $itemName = trim(fgets(STDIN));

    // Проверка наличия товара в списке перед удалением
    if (in_array($itemName, $items, true)) {
        while (($key = array_search($itemName, $items, true)) !== false) {
            unset($items[$key]);
        }
        $items = array_values($items); // сбросить ключи массива
    }
}

// Функция для печати списка покупок
function printItems(array $items): void {
    displayItems($items);
    echo 'Всего ' . count($items) . ' позиций.' . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

// Основной цикл программы
do {
    // Очистка экрана (в данном случае комментирована для UNIX, а для Windows используется 'cls')
    // system('clear');
    system('cls'); // для Windows

    // Отображение списка покупок
    displayItems($items);

    // Получение операции от пользователя
    $operationNumber = getOperation($operations);

    // Вывод выбранной операции
    echo 'Выбрана операция: ' . $operations[$operationNumber] . PHP_EOL;

    // Обработка выбранной операции
    switch ($operationNumber) {
        case OPERATION_ADD:
            addItem($items);
            break;

        case OPERATION_DELETE:
            deleteItem($items);
            break;

        case OPERATION_PRINT:
            printItems($items);
            break;
    }

    // Разделитель между операциями
    echo "\n ----- \n";

} while ($operationNumber !== OPERATION_EXIT);

// Завершение программы
echo 'Программа завершена' . PHP_EOL;
