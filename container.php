<?php

require_once ('./data_heap.php');

class Container {

    /** @var Row[] $rows */
    private $rows = [];

    /** @var DataHeap[]  */
    private $emails = [];

    /** @var DataHeap[]  */
    private $cards = [];

    /** @var DataHeap[]  */
    private $phones = [];

//    public function getEarliestEmailId($email) {
//        return $this->emails[$email]->top();
//    }
//
//    public function getEarliestCardsId($card) {
//        return $this->cards[$card]->top();
//    }
//
//    public function getEarliestPhoneId($phone) {
//        return $this->phones[$phone]->top();
//    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function addRow(Row $row): void
    {
        $this->rows[$row->getId()] = $row;
    }

    public function getRow($id): Row
    {
        return $this->rows[$id];
    }

    public function addEmail($email, $id): void
    {
        if (false === isset($this->emails[$email])) {
            $this->emails[$email] = new DataHeap();
        }

        $this->emails[$email]->insert($id);
    }

    public function addPhone($phone, $id): void
    {
        if (false === isset($this->phones[$phone])) {
            $this->phones[$phone] = new DataHeap();
        }

        $this->phones[$phone]->insert($id);
    }

    public function addCard($card, $id): void
    {
        if (false === isset($this->cards[$card])) {
            $this->cards[$card] = new DataHeap();
        }

        $this->cards[$card]->insert($id);
    }

    /**
     * @return array
     */
    public function getEmails(): array
    {
        return $this->emails;
    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @return array
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

}