# vaneck-coveo-challenge

Suite à mon challenge recu par Coveo, qui est une superbe entreprise canadienne ayant pour champ d'activité principale l'IA. Ci dessous les étapes d'installation de ma solution. 
Pour tester ma solution, vous aurrez besoins d'une seul chose: <b>Docker</b>.
si vousutilisez windows :<br/>
<ul>
  <li>Télécharge le dossier vaneck-coveo-challenge à l'emplacement de ton choix </li>
  <li>Décompresse le dossier</li>
  <li>Ouvre le terminal (nous allons créer une nouvelle image à partir du dockerfile)
    <ol>
      <li><b>docker build -t coveo-challenge/</b> (Build via le dockerfile) dans l'exécution de cette commande repère la ligne <br/>  <b> ---> Running in 285fa81dca19</b></li>
        <li>l'application a besoin du protocole HTTTP pour fonctionner il faut donc utiliser le port qui te convient moi j'utilise le port 80 à l'aide de la commande:<br> <b>docker run -d -p 80:80 X285fa81dca19</b></li>
     </ol>  
     
  </li>
  <li>Allez dans le navigateur de votre machine et entrez http://localhost ou sur un ordinateur du même réseau entrez l'ip du conteneur docker </li>
</ul>
