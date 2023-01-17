<?php
$cde = $_POST['btn-cde'];
echo $_POST['img-download'];
$nomFichier = $cde."jpeg";
$contenuFichier = $_POST['img-download'];

/**
 * Télécharge le contenu d'un fichier sur le client de l'internaute, avec le nom spécifié.
 *
 * @param string $contenuFichier Le contenu du fichier à télécharger
 * (obtenu avec file_get_contents() par exemple).
 * @param string $nomFichier $Nom du fichier qui sera proposé par défaut à l'internaute.
 */
function telechargerFichier($contenuFichier, $nomFichier)
{
   // on détermine le type MIME du fichier
      $typeFichier=typeMime($nomFichier);
 
   // on nettoie le tampon d'affichage, et on désactive la compression ZLib
   @ob_end_clean();
   @ini_set('zlib.output_compression', '0');
 
   // date courante
   $maintenant=gmdate('D, d M Y H:i:s').' GMT';
 
   // envoi des en-têtes nécessaires au navigateur
   header('Content-Type: '.$typeFichier);
   header('Content-Disposition: attachment; filename="'.$nomFichier.'"');
 
   // Internet Explorer nécessite des en-têtes spécifiques
   if(preg_match('/msie|(microsoft internet explorer)/i', $_SERVER['HTTP_USER_AGENT']))
   {
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
   }
   else header('Pragma: no-cache');
 
   header('Last-Modified: '.$maintenant);
   header('Expires: '.$maintenant); 
   header('Content-Length: '.strlen($contenu));
 
   // il ne reste plus qu'à envoyer le contenu du fichier
   echo $contenu;
}
?>