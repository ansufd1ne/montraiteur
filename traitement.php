
<?php
// Autoriser les requêtes CORS si tu testes localement
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

// Récupération et décodage des données JSON
$input = json_decode(file_get_contents("php://input"), true);

// Vérification des données reçues
if (!$input || !is_array($input)) {
  http_response_code(400);
  echo "❌ Aucune donnée reçue ou format invalide.";
  exit;
}

// Facultatif : journalisation des données dans un fichier log pour vérifier
file_put_contents("log.txt", print_r($input, true));

// Liste des champs obligatoires
$requiredFields = ['prenom', 'nom', 'email', 'tel', 'date', 'ville', 'budget'];

// Vérification des champs obligatoires
foreach ($requiredFields as $field) {
  if (empty($input[$field])) {
    http_response_code(400);
    echo "❌ Champ requis manquant : $field";
    exit;
  }
}

// Préparation de l'email
$to = "ansufdine.company@gmail.com"; // Mets ton adresse ici
$subject = "Nouvelle demande de devis";
$message = "📝 Demande de devis :\n\n";
$message .= "Nom : " . $input['prenom'] . " " . $input['nom'] . "\n";
$message .= "Email : " . $input['email'] . "\n";
$message .= "Téléphone : " . $input['tel'] . "\n";
$message .= "Date événement : " . $input['date'] . "\n";
$message .= "Ville : " . $input['ville'] . "\n";
$message .= "Budget : " . $input['budget'] . "\n";
$message .= "Commentaires :\n" . ($input['commentaires'] ?? 'Aucun') . "\n";

// ➕ Tu peux ajouter d'autres champs si tu veux les recevoir

// ❌ Désactivé en local : décommente en production
/*
$sent = mail($to, $subject, $message);
if ($sent) {
  echo "✅ Email envoyé avec succès.";
} else {
  http_response_code(500);
  echo "❌ Erreur lors de l'envoi de l'email.";
}
*/

// ✅ Retour console uniquement pour test en local
echo "✅ Données reçues et valides (envoi désactivé)";
?>