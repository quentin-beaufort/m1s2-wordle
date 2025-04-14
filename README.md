# M1S2 Wordle

A command-line implementation of the popular Wordle game built with Laravel.

## Requirements

To run this project, you'll need:

- PHP 8.1 or higher
- Composer
- Node.js and NPM (for frontend assets)
- SQLite (or another database supported by Laravel)

## Installation

1. Clone the repository:

```bash
git clone <repository-url>
cd m1s2-wordle
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install JavaScript dependencies:

```bash
npm install
```

4. Create a `.env` file by copying the example file:

```bash
cp .env.example .env
```

5. Generate an application key:

```bash
php artisan key:generate
```

6. Set up the database:

```bash
touch database/database.sqlite
php artisan migrate
```

7. Compile the frontend assets (optional for CLI usage):

```bash
npm run dev
```

## Running the Wordle Game

To play the Wordle game in your terminal, run:

```bash
php artisan wordle:play
```

This will start a new game where you have 6 attempts to guess a 5-letter word. For each guess, you'll receive feedback in the form of colored squares:

- 🟩 Green: The letter is in the correct position.
- 🟨 Yellow: The letter is in the word but in the wrong position.
- ⬜ White: The letter is not in the word.

Follow the on-screen prompts to play the game.

## Running Tests

This project uses [Pest PHP](https://pestphp.com/) for testing.

### Running All Tests

To run all tests, use:

```bash
php artisan test
```

or

```bash
./vendor/bin/pest
```

### Running Specific Tests

To run a specific test file:

```bash
./vendor/bin/pest tests/Unit/WordleGameTest.php
```

### Code Coverage

To generate a code coverage report, you'll need to have Xdebug or PCOV installed and enabled in your PHP configuration.

1. Generate HTML coverage report:

```bash
./vendor/bin/pest --coverage
```

2. For a detailed HTML coverage report:

```bash
./vendor/bin/pest --coverage-html reports/
```

After running this command, you can open `reports/index.html` in your browser to view the detailed coverage report.

3. To see the coverage percentage in the console:

```bash
./vendor/bin/pest --coverage-text
```

## Project Structure

- `app/Models/WordleGame.php`: The main game logic class
- `app/Models/WordList.php`: Handles the list of possible words
- `app/Console/Commands/PlayWordleCommand.php`: Command-line interface for the game
- `tests/Unit/WordleGameTest.php`: Unit tests for the game logic
