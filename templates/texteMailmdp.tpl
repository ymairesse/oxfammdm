<p>Chère/cher {$identite.prenom} {$identite.nom},</p>

<p>
  Ce courriel vous est adressé par le système automatique d'envoi de mails de la
  plate-forme de gestion des bénévoles Oxfam.
</p>
<p>
  Ce {$jour} {$date} à {$heure}, quelqu'un (sans doute vous) à l'adresse IP
  {$identiteReseau.ip} ({$identiteReseau.hostname}) a demandé le changement de
  mot passe pour l'utilisateur <strong>{$identite.pseudo}</strong>.
</p>
<p>
  Si vous n'êtes pas à l'origine de cette demande ou si vous n'avez rien
  demandé, négligez simplement ce mail.
</p>
<p>
  Si vous souhaitez, par contre, réellement pouvoir changer votre mot de passe,
  cliquez sur le lien suivant (ou recopiez la ligne dans la barre d'adresse de
  votre navigateur).
</p>
<a
  href="{$URL}index.php?action=renewPasswd&amp;pseudo={$identite.pseudo}&amp;token={$link}"
  >{$URL}index.php?action=renewPasswd&amp;pseudo={$identite.pseudo}&amp;token={$link}</a
>
<p>
  Ce lien ne fonctionnera que pendant 48h à dater du moment précis de la
  demande, soit le moment d'envoi du présent mail.
</p>

<p>
  <u>/!\</u> Attention! Ce lien ne peut servir qu'une seule fois. Pour un autre
  renouvellement de mot de passe
<ul>
  <li>au-delà du délai de 48h ou</li>
  <li>si vous avez utilisé ce lien une fois</li>
</ul>
il faudra faire une nouvelle demande.
</p>

<p>&nbsp;</p>
<hr />
<p>
  Ce mail est généré par un robot. Les éventuelles réponses ne sont pas lues. Ne
  tentez pas d'y répondre.
</p>
