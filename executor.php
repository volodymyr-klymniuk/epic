<?php

/** @var Row[] $rowsContainer */
/** @var DataHeap[] $emails */
/** @var DataHeap[] $cards */
/** @var DataHeap[] $phones */
declare(strict_types=1);

require_once ('row.php');
require_once ('data_heap.php');
require_once ('container.php');

$rowIter = 1;
$emails = [];
$phones = [];
$cards = [];
$hp = new DataHeap();
$container = new Container();

if (($handle = \fopen("input.csv", "r")) !== false) {
    while (($row = \fgetcsv($handle, 9990, ",")) !== false) {

        if ($row[0] == 'ID') {
            continue;
        }

        $objRow = createRow($row);
        flushContainer($objRow, $container);
        $rowIter++;
        $num = \count($row);
    }

    \fclose($handle);
}

function createRow(array $row): Row {
    [ $tbodyID, $tbodyParentID, $tbodyEmail, $tbodyCard, $tbodyPhone, $tbodyTMP ] = $row;

    return new Row(
        (int) $tbodyID,
        \is_null($tbodyParentID) || \trim($tbodyParentID) == 'NULL' ? null : (int) $tbodyParentID,
        \is_null($tbodyEmail) || \trim($tbodyEmail) == 'NULL' ? null : (string) \trim($tbodyEmail),
        \is_null($tbodyCard) || \trim($tbodyCard) == 'NULL' ? null : (string) \trim($tbodyCard),
        \is_null($tbodyPhone) || \trim($tbodyPhone) == 'NULL' ? null : (string) \trim($tbodyPhone),
        \is_null($tbodyTMP) || \trim($tbodyTMP) == 'NULL' ? null : (string) \trim($tbodyTMP),
    );
}

function flushContainer(Row $row, Container $container): void {
    $container->addEmail($row->getEmail(), $row->getId());
    $container->addCard($row->getCard(), $row->getId());
    $container->addPhone($row->getPhone(), $row->getId());
    $container->addRow($row);
}

function drawTable(array $rows): void {
    echo "\tID\t|\tPARENT_ID";
    echo "\r\n";

    foreach ($rows as $row) {
        echo drawRow($row);
        echo "\r\n";
    }
}

function drawRow(Row $row): string {
    return "\t{$row->getId()}\t|\t{$row->getParentId()}";
}

$inputs = $container->getRows();

array_walk($inputs, function (Row &$row) use ($container) {
    $parentId = $row->getId();

    // Order priority (EMAIL, CARD, PHONE) also can be ordered by additional date.
    $emailParentId = $container->getEmails()[$row->getEmail()]->top();
    $phoneParentId = $container->getPhones()[$row->getPhone()]->top();
    $cardParentId = $container->getCards()[$row->getCard()]->top();

    switch (true) {
        case ($cardParentId !== $parentId):
            $parentId = $cardParentId;
        break;

        case ($phoneParentId !== $parentId):
            $parentId = $phoneParentId;
        break;

        case ($emailParentId !== $parentId):
            $parentId = $emailParentId;
        break;
    }

    if ($parentId !== $row->getId()) {
        $row->setParentId($parentId);
    }

    $originParentId = getOriginParentId($row->getParentId(), $container);

    if ($originParentId < $row->getParentId()) {
        $row->setParentId($originParentId);
    }
});


function getOriginParentId($requestedId, Container $container) {
    $originId = $container->getRow($requestedId)->getParentId();

    if ($originId === null) {
        return $requestedId;
    }

    if ($originId === $requestedId) {
        return $originId;
    }

    $originParentId = $container->getRow($originId)->getParentId();

    return getOriginParentId($originParentId, $container);
}

drawTable($container->getRows());

echo 'ok';