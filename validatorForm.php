<?php

/**
 * Valide les données d'entrée selon les règles spécifiées.
 *
 * @param array $data Les données à valider.
 * @param array $rules Les règles de validation (par exemple ['username' => 'required|alpha', 'email' => 'required|email']).
 * @return array Un tableau avec les erreurs de validation, vide s'il n'y a pas d'erreurs.
 */
function validateInput($data, $rules)
{
    $errors = [];

    foreach ($rules as $field => $ruleSet) {
        $rulesArray = explode('|', $ruleSet);
        foreach ($rulesArray as $rule) {
            $value = isset($data[$field]) ? $data[$field] : null;

            // Règle: required
            if ($rule == 'required' && empty($value)) {
                $errors[$field][] = 'Ce champ est obligatoire.';
                continue;
            }

            // Règle: alpha
            if ($rule == 'alpha' && !preg_match('/^[a-zA-Z]+$/', $value)) {
                $errors[$field][] = 'Ce champ doit contenir uniquement des lettres.';
            }

            // Règle: numeric
            if ($rule == 'numeric' && !is_numeric($value)) {
                $errors[$field][] = 'Ce champ doit être un nombre.';
            }

            // Règle: min
            if (strpos($rule, 'min:') === 0) {
                $minValue = (int)substr($rule, 4);
                if ((int)$value < $minValue) {
                    $errors[$field][] = "Ce champ doit être supérieur ou égal à $minValue.";
                }
            }

            // Règle: max
            if (strpos($rule, 'max:') === 0) {
                $maxValue = (int)substr($rule, 4);
                if ((int)$value > $maxValue) {
                    $errors[$field][] = "Ce champ doit être inférieur ou égal à $maxValue.";
                }
            }

            // Règle: minLength
            if (strpos($rule, 'minLength:') === 0) {
                $minLength = (int)substr($rule, 10);
                if (strlen($value) < $minLength) {
                    $errors[$field][] = "Ce champ doit contenir au moins $minLength caractères.";
                }
            }

            // Règle: maxLength
            if (strpos($rule, 'maxLength:') === 0) {
                $maxLength = (int)substr($rule, 10);
                if (strlen($value) > $maxLength) {
                    $errors[$field][] = "Ce champ doit contenir au maximum $maxLength caractères.";
                }
            }

            // Règle: alphaNum
            if ($rule == 'alphaNum' && !preg_match('/^[a-zA-Z0-9]+$/', $value)) {
                $errors[$field][] = 'Ce champ doit contenir uniquement des lettres et des chiffres.';
            }

            // Règle: email
            if ($rule == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field][] = 'Adresse email invalide.';
            }

            // Règle: url
            if ($rule == 'url' && !filter_var($value, FILTER_VALIDATE_URL)) {
                $errors[$field][] = 'URL invalide.';
            }
        }
    }

    return $errors;
}

// Exemple d'utilisation
$data = [
    'username' => 'JohnDoe123',
    'email' => 'john.doe@example.com',
    'age' => '20',
    'website' => 'https://example.com'
];

$rules = [
    'username' => 'required|alphaNum|minLength:3|maxLength:20',
    'email' => 'required|email',
    'age' => 'required|numeric|min:18|max:99',
    'website' => 'required|url'
];

$errors = validateInput($data, $rules);

if (!empty($errors)) {
    // Afficher les erreurs de validation
    print_r($errors);
} else {
    echo 'Les données sont valides.';
}
