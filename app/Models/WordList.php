<?php

namespace App\Models;

class WordList
{
    public array $words = [
        'PIANO', 'LIVRE', 'TABLE', 'CHANT', 'FLEUR',
        'MONDE', 'TRAIN', 'PLAGE', 'POIRE', 'VAGUE',
        'ROUGE', 'BLANC', 'BOIRE', 'MANGE', 'CHIEN',
        'BRISE', 'PLUIE', 'FROID', 'CHAUD', 'VERRE',
        'TOMBE', 'POMME', 'FRAIS', 'CARTE', 'PORTE',
        'ROULE', 'DANSE', 'SPORT', 'PLUME', 'FONCE',
        'COEUR', 'REINE', 'PLEIN', 'VIENT', 'SABLE',
        'PLAIT', 'BRUIT', 'CRANE', 'PENSE', 'TENTE',
        'NOEUD', 'PISTE', 'TRACE', 'PLACE', 'BANDE',
        'PASSE', 'LANCE', 'DROIT', 'COURT', 'RESTE',
        // Nouveaux mots ajoutés
        'ABIME', 'ACIER', 'ADORE', 'AGILE', 'ALBUM',
        'AMOUR', 'ANGLE', 'APPEL', 'ARBRE', 'ARIDE',
        'ASTRE', 'ATOUT', 'AVION', 'AVRIL', 'BALAI',
        'BANJO', 'BARBE', 'BARRE', 'BATON', 'BIERE',
        'BIJOU', 'BLOCS', 'BLOND', 'BLUES', 'BOITE',
        'BONUS', 'BORDS', 'BOULE', 'BOURG', 'BRAVE',
        'BRUNS', 'BULLE', 'BUTIN', 'CABLE', 'CADRE',
        'CALME', 'CANAL', 'CANNE', 'CANON', 'CARGO',
        'CARIE', 'CARRE', 'PALME', 'CASSE', 'CEDRE',
        'CHAMP', 'CHATS', 'CHENE', 'CHOCS', 'CHUTE',
        'CIBLE', 'CIDRE', 'CIMES', 'CLAIR', 'CLOWN',
        'COBRA', 'COLLE', 'CONTE', 'CORDE', 'CORPS',
        'COUDE', 'COUPE', 'CREME', 'CREPE', 'CROIX',
        'CUBES', 'CULTE', 'CYCLE', 'DAMES', 'DEBUT',
        'DEGRE', 'DELAI', 'DEUIL', 'DEVIS', 'DIVIN',
        'DOIGT', 'DOUTE', 'DRAME', 'DROLE', 'DUREE',
        'ECART', 'ECHOS', 'ECOLE', 'ECRAN', 'EMAIL',
        'ENVIE', 'EPAIS', 'EPICE', 'EPOUX', 'ETAIN',
        'ETANG', 'ETATS', 'ETHER', 'ETUDE', 'EVIER',
        'EXCES', 'EXILE', 'FABLE', 'PIZZA', 'FAUNE'
    ];

    public function __construct()
    {
        $this->validateWords();
    }

    private function validateWords(): void
    {
        $wordCounts = [];
        $invalidWords = [];

        foreach ($this->words as $index => $word) {
            // Vérification de la longueur et des caractères alphabétiques
            if (strlen($word) !== 5 || !ctype_alpha($word)) {
                $invalidWords[] = "$word (doit faire exactement 5 lettres alphabétiques)";
            }

            // Vérification des doublons
            if (isset($wordCounts[$word])) {
                $invalidWords[] = "$word (doublon trouvé)";
            }
            $wordCounts[$word] = ($wordCounts[$word] ?? 0) + 1;
        }

        // S'il y a des mots invalides, lever une exception
        if (!empty($invalidWords)) {
            throw new \InvalidArgumentException("Liste de mots invalide:\n- " . implode("\n- ", $invalidWords));
        }

        // Enlever les doublons de la liste
        $this->words = array_keys($wordCounts);
    }

    public function getRandomWord(): string
    {
        return $this->words[array_rand($this->words)];
    }
}