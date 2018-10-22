Suite à mon challenge reçu par Coveo, qui est une superbe entreprise canadienne ayant pour champ d'activité principale l'IA.

Le défie était de développer un outil permettant d’analyser la taille des ressources de stockage S3 d’un compte Amazon Web Services (AWS).
Ma solution est faite à base du SDK php et integre certains langage web tels que: Javascript, jquery. n'ai pas peur il est quand même assez bien documenté.

 Ci-dessous, les étapes d'installation de ma solution.
Pour tester ma solution, vous aurrez besoins d'une seul chose: <b>Docker</b>.

si vous utilisez linux et/ou Macos vous pouvez utiliser <b>git clone https://github.com/duvaneck/vaneck-coveo-challenge.git
si vous utilisez windows :<br/>

<ul>
  <li>Télécharge le dossier vaneck-coveo-challenge à l'emplacement de ton choix </li>
  <li>Décompresse le dossier</li>
  <li>Ouvre le terminal (nous allons créer une nouvelle image à partir du dockerfile)
    <ol>
      <li><b>docker build -t vaneck-coveo-challenge/</b> (Build via le dockerfile) dans l'exécution de cette commande repère la ligne <br/>  <b> ---> Running in xxxxx </b>(xxx représente des caractères alpha-numérique)</li>
        <li>l'application a besoin du protocole HTTTP pour fonctionner il faut donc utiliser le port qui te convient moi j'utilise le port 80 à l'aide de la commande:<br> <b>docker run -d -p 80:80 xxxxx</b> (il s'agit du xxxx précédent ) ou pour valider tu peux utiliser la commande:
        <b>docker images</b> et ainsi récupérer l'image id la plus récente. Cette image id correspond à notre <b>xxx</b> de tout à l'heure </li>
     </ol>  

  </li>
  <li>une fois le tout configurer, aller dans le navigateur de votre machine et entrer http://localhost si vous utiliser le port 80 ou http://localhost:port si vous utilisez un autre port ou encore sur un ordinateur du même réseau avec l'ip du conteneur ainsi que le port configuré. </li>
</ul>

si le message <b> No data available in table </b> s'affiche alors vous avez oublié de spécifier les valeurs:

 - awsAccessKey
 - awsSecretKey

dans le fichier details.php. Nous pouvons grandement améliorer l'outils et y ajouter plusieurs fonctionnalités comme:

 - Supprimer un bucket
 - Gérer le contenu de chaque bucket
 - Gérer les acces chaque bucket
 - ......

Probablement je le ferai dans un avenir proche

Merci et profite bien ;-)
