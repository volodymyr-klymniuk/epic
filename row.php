<?php

class Row {
    private ?int $id;
    private ?int $parentId;
    private ?string $email;
    private ?string $card;
    private ?string $phone;
    private ?string $tmp = '';

    // ID, PARENT_ID, EMAIL, CARD, PHONE, TMP
    // 1,   NULL,   email1,   NULL,  phone1,
    // 15,  NULL,   email094, card7, phone314,
    public function __construct(
        int $id, string|null $parentId, string|null $email,
        string|null $card, string|null $phone, string|null $tmp = ''
    ) {
        $this->id = $id;
        $this->parentId = $parentId ?: $id;
        $this->email = $email;
        $this->card = $card;
        $this->phone = $phone;
        $this->tmp = $tmp;
    }

    /**
     * @return string|null
     */
    public function getCard(): ?string
    {
        return $this->card;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getTmp(): ?string
    {
        return $this->tmp;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }
}