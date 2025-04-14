<?php

use App\Models\WordList;

test('word list contains only 5-letter words', function () {
    $wordList = new WordList();
    
    // Test that getRandomWord returns a 5-letter word
    $word = $wordList->getRandomWord();
    expect(strlen($word))->toBe(5)
        ->and(ctype_alpha($word))->toBeTrue();
});

test('word list returns different words on multiple calls', function () {
    $wordList = new WordList();
    
    $word1 = $wordList->getRandomWord();
    $word2 = $wordList->getRandomWord();
    
    // While it's technically possible to get the same word twice,
    // with 50 words it's unlikely
    expect($word1)->not->toBe($word2);
}); 