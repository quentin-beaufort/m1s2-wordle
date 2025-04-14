<?php

namespace App\Models;

class WordleGame
{
    private string $word;
    private int $maxAttempts = 6;
    private int $currentAttempt = 0;
    private array $attempts = [];
    private array $guesses = [];
    private bool $isGameOver = false;
    private bool $isWon = false;

    public function __construct(string $word)
    {
        $this->word = strtoupper($word);
    }

    public function makeAttempt(string $guess): array
    {
        $guess = strtoupper($guess);
        
        if (!$this->isValidGuess($guess)) {
            throw new \InvalidArgumentException('Le mot doit contenir exactement 5 lettres.');
        }

        if ($this->isGameOver) {
            throw new \RuntimeException('La partie est terminée.');
        }

        $this->currentAttempt++;
        $result = $this->checkGuess($guess);
        $this->attempts[] = $result;
        $this->guesses[] = $guess;

        if ($guess === $this->word) {
            $this->isWon = true;
            $this->isGameOver = true;
        } elseif ($this->currentAttempt >= $this->maxAttempts) {
            $this->isGameOver = true;
        }

        return $result;
    }

    private function isValidGuess(string $guess): bool
    {
        return strlen($guess) === 5 && ctype_alpha($guess);
    }

    private function checkGuess(string $guess): array
    {
        $result = [];
        $wordArray = str_split($this->word);
        $guessArray = str_split($guess);

        for ($i = 0; $i < 5; $i++) {
            if ($guessArray[$i] === $wordArray[$i]) {
                $result[$i] = 'correct';
            } elseif (in_array($guessArray[$i], $wordArray)) {
                $result[$i] = 'present';
            } else {
                $result[$i] = 'absent';
            }
        }

        return $result;
    }

    public function isGameOver(): bool
    {
        return $this->isGameOver;
    }

    public function isWon(): bool
    {
        return $this->isWon;
    }

    public function getRemainingAttempts(): int
    {
        return $this->maxAttempts - $this->currentAttempt;
    }

    public function getAttempts(): array
    {
        return $this->attempts;
    }

    public function getGuesses(): array
    {
        return $this->guesses;
    }

    public function getWord(): string
    {
        return $this->word;
    }
} 