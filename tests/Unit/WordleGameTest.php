<?php

use App\Models\WordleGame;

test('game validates word length', function () {
    $game = new WordleGame('PIANO');
    
    expect(fn() => $game->makeAttempt('PIAN'))->toThrow(InvalidArgumentException::class)
        ->and(fn() => $game->makeAttempt('PIANOS'))->toThrow(InvalidArgumentException::class);
});

test('game validates alphabetic characters', function () {
    $game = new WordleGame('PIANO');
    
    expect(fn() => $game->makeAttempt('PI4NO'))->toThrow(InvalidArgumentException::class);
});

test('game correctly identifies correct letters', function () {
    $game = new WordleGame('PIANO');
    
    $result = $game->makeAttempt('PIANO');
    
    expect($result)->toBe([
        0 => 'correct',
        1 => 'correct',
        2 => 'correct',
        3 => 'correct',
        4 => 'correct'
    ]);
});

test('game correctly identifies present letters', function () {
    $game = new WordleGame('PIANO');
    
    $result = $game->makeAttempt('PAINT');
    
    expect($result[0])->toBe('correct')  // P is correct
        ->and($result[1])->toBe('present') // I is present but wrong position
        ->and($result[2])->toBe('present')  // A is present but wrong position
        ->and($result[3])->toBe('correct')  // N is correct
        ->and($result[4])->toBe('absent'); // T is absent
});

test('game tracks remaining attempts', function () {
    $game = new WordleGame('PIANO');
    
    expect($game->getRemainingAttempts())->toBe(6);
    
    $game->makeAttempt('PAINT');
    expect($game->getRemainingAttempts())->toBe(5);
});

test('game ends after correct guess', function () {
    $game = new WordleGame('PIANO');
    
    $game->makeAttempt('PIANO');
    
    expect($game->isGameOver())->toBeTrue()
        ->and($game->isWon())->toBeTrue();
});

test('game ends after max attempts', function () {
    $game = new WordleGame('PIANO');
    
    for ($i = 0; $i < 6; $i++) {
        $game->makeAttempt('PAINT');
    }
    
    expect($game->isGameOver())->toBeTrue()
        ->and($game->isWon())->toBeFalse();
}); 