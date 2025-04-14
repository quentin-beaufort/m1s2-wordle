<?php

namespace App\Console\Commands;

use App\Models\WordleGame;
use App\Models\WordList;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

class PlayWordleCommand extends Command
{
    protected $signature = 'wordle:play';
    protected $description = 'Jouer une partie de Wordle';

    private array $colors = [
        'correct' => '🟩',
        'present' => '🟨',
        'absent' => '⬜',
    ];

    public function handle()
    {
        $this->info('Bienvenue dans Wordle!');
        $this->info('Vous avez 6 tentatives pour deviner le mot de 5 lettres.');
        
        $playAgain = true;
        
        while ($playAgain) {
            // Pour cet exemple, nous utilisons un mot fixe
            // Dans une version plus avancée, on pourrait utiliser une base de données de mots
            $wordList = new WordList();
            $game = new WordleGame($wordList->getRandomWord());

            while (!$game->isGameOver()) {
                $this->displayBoard($game);
                $this->info(sprintf('Tentatives restantes : %d', $game->getRemainingAttempts()));
                
                $guess = $this->ask('Entrez votre mot (5 lettres)');
                
                try {
                    $result = $game->makeAttempt($guess);
                    
                    if ($game->isWon()) {
                        $this->displayBoard($game);
                        $this->info('Félicitations ! Vous avez gagné !');
                        break;
                    }
                    
                    if ($game->isGameOver()) {
                        $this->displayBoard($game);
                        $this->error(sprintf('Game Over ! Le mot était : %s', $game->getWord()));
                        break;
                    }
                } catch (\InvalidArgumentException $e) {
                    $this->error($e->getMessage());
                } catch (\RuntimeException $e) {
                    $this->error($e->getMessage());
                    break;
                }
            }
            
            // Ask if the user wants to play again
            $choice = select(
                label: 'Voulez-vous jouer une autre partie ?',
                options: ['Oui', 'Non'],
                default: 'Oui'
            );
            
            $playAgain = $choice === 'Oui';
            
            if ($playAgain) {
                $this->info('Nouvelle partie !');
                $this->info('Vous avez 6 tentatives pour deviner le mot de 5 lettres.');
            } else {
                $this->info('Merci d\'avoir joué à Wordle. À bientôt !');
            }
        }
    }

    private function displayBoard(WordleGame $game): void
    {
        $this->newLine();
        $this->info('=== Grille de jeu ===');
        
        $guesses = $game->getGuesses();
        $attempts = $game->getAttempts();
        
        for ($i = 0; $i < count($guesses); $i++) {
            $guess = str_split($guesses[$i]);
            $attempt = $attempts[$i];
            
            // Afficher les lettres
            $lettersLine = '';
            for ($j = 0; $j < 5; $j++) {
                $lettersLine .= $guess[$j] . '  ';
            }
            $this->line($lettersLine);
            
            // Afficher les couleurs
            $colorsLine = '';
            for ($j = 0; $j < 5; $j++) {
                $colorsLine .= $this->colorizeLetter($guess[$j], $attempt[$j]);
            }
            $this->line($colorsLine);
            $this->newLine();
        }

        // Afficher les lignes vides restantes
        $remainingLines = 6 - count($guesses);
        for ($i = 0; $i < $remainingLines; $i++) {
            $this->line('     '); // Espace pour les lettres
            $this->line('⬜ ⬜ ⬜ ⬜ ⬜');
            $this->newLine();
        }
        
        $this->info('===================');
        $this->newLine();
    }

    private function colorizeLetter(string $letter, string $status): string
    {
        $color = $this->colors[$status] ?? '⬜';
        return "$color ";
    }
}