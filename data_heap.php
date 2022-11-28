<?php

class DataHeap extends \SplHeap {
    protected function compare(mixed $value1, mixed $value2): int
    {
        return ( $value2 - $value1 );
    }
}
