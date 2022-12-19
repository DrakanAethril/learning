<?php

namespace App\Lms\Quotes;

Class Quotes {

    public static function getRandomQuote() : array {
        $quotes = [
            ['text' => 'I am always ready to learn although I do not always like being taught.', 'author' => 'W. Churchill'],
            ['text' => 'Tell me and I forget, teach me and I may remember, involve me and I learn.', 'author' => 'B. Franklin'],
            ['text' => 'Learning never exhausts the mind.', 'author' => 'Leonardo da Vinci'],
            ['text' => 'For the best return on your money, pour your purse into your head.', 'author' => 'B. Franklin'],
            ['text' => 'I am always doing that which I cannot do, in order that I may learn how to do it.', 'author' => 'Pablo Picasso'],
            ['text' => 'Intellectual growth should commence at birth and cease only at death.', 'author' => 'Albert Einstein'],
            ['text' => 'Learn as if you were not reaching your goal and as though you were scared of missing it.', 'author' => 'Confucius'],
            ['text' => 'The beautiful thing about learning is that nobody can take it away from you.', 'author' => 'B.B. King'],
            ['text' => 'Anyone who stops learning is old, whether at twenty or eighty. Anyone who keeps learning stays young.', 'author' => 'Henry Ford'],
            ['text' => 'Wisdom…. comes not from age, but from education and learning.', 'author' => 'Anton Chekhov'],
            ['text' => 'For the things we have to learn before we can do them, we learn by doing them.', 'author' => 'Aristote'],
            ['text' => 'In learning you will teach, and in teaching you will learn.', 'author' => 'Phil Collins'],
            ['text' => 'In the end we retain from our studies only that which we practically apply.', 'author' => 'J.W. von Goethe'],
            ['text' => 'Being a student is easy. Learning requires actual work.', 'author' => 'William Crawford'],
            ['text' => 'Education without application is just entertainment.', 'author' => 'Tim Sanders'],
            ['text' => 'The great aim of education is not knowledge but action.', 'author' => 'Herbert Spencer'],
            ['text' => 'The expert in anything was once a beginner.', 'author' => 'Anonymous'],
            ['text' => 'No problem can withstand the assault of sustained thinking.', 'author' => 'Voltaire'],
            ['text' => 'The greatest teacher, failure is.', 'author' => 'Master Yoda']
            
        ];
        shuffle($quotes);
        return $quotes[0];
    }
}