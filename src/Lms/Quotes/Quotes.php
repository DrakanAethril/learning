<?php

namespace App\Lms\Quotes;

Class Quotes {

    public static function getRandomQuote() : array {
        $quotes = [
            ['text' => 'I am always ready to learn although I do not always like being taught.', 'author' => 'W. Churchill'],
            ['text' => 'Tell me and I forget, teach me and I may remember, involve me and I learn.', 'author' => 'B. Franklyn']
        ];
        shuffle($quotes);
        return $quotes[0];
    }
}