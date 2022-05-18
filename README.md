<h2>Aide du plugin</h2>
	
<h3>Configuration</h3>
<p>Optionnelle</p>
<p>Le filtrage des robots indexeur peut-être désactivé (activé par défaut)</p>
<p>Le nombre de lien vers les articles les plus lus peut-être modifié (default:5)</p>
<p><b>Le fichier stockant les infos de configuration et de stockage</b> est situé dans le repertoire de <code>data/configuration/plugins</code> <sub><sup>(repertoire commun de configuration des plugins)</sup></sub>, ce fichier est désactiver lorsque le plugin est désactiver, <b>ce fichier est supprimé lorsque vous supprimez le plugin</b>. Faites en un backup si vous souhaitez preservé la configuration et comptage des vues.</p>
<h3>Affichage Dans les fichiers des  théme</h3>
  <h4>Afficher le nombre de vue</h4>
<p>Pour afficher le nombre de vue, inserez le code suivant :
<code>&lt;?php if (eval($plxMotor->plxPlugins->callHook('showViews'))) return; ?></code> à l'endroit ou vous voulez le faire apparaitre.</p>
<p><b>Exemple:</b> Dans les fichiers <code>home.php, categorie.php, article.php,tag.php , ...</code> du théme par défaut, vous pouvez l'inserer sous le titre de l'article.<small><i>(extrait du code du fichier ci-dessous)</i></small>
<pre><code>&lt;header>
	&lt;span class="art-date">
		&lt;time datetime="&lt;?php $plxShow->artDate('#num_year(4)-#num_month-#num_day'); ?>">
			&lt;?php $plxShow->artDate('#num_day #month #num_year(4)'); ?>
		&lt;/time>
	&lt;/span>
	&lt;h2>
		&lt;?php $plxShow->artTitle('link'); ?>
	&lt;/h2>
	&lt;div>
		&lt;small>
			&lt;span class="written-by">
				&lt;?php $plxShow->lang('WRITTEN_BY'); ?> &lt;?php $plxShow->artAuthor() ?>
			&lt;/span>
<b style="color:green">&lt;!--  insertion du code --></b><b style="color:tomato">&lt;?php if (eval($plxMotor->plxPlugins->callHook('showViews'))) return; ?></b>
			&lt;span class="art-nb-com">
				&lt;?php $plxShow->artNbCom(); ?>
			&lt;/span>
		&lt;/small>
	&lt;/div></code></pre></p>
<h4>Afficher une listes des articles les plus lus</h4>
<p>Pour afficher une liste des aricles les plus lus, inserer le code ci dessous à l'endroit du théme où vous souhaitez le voir apparaitre</p>
<p><b>exemple</b> pour l'ajouter à la sidebar du thème par défaut entre les derniers articles et les tags ( fichier <code>sidebar.php</code> )</p>
<pre><code>	&lt;h3>
		&lt;?php $plxShow->lang('LATEST_ARTICLES'); ?>
	&lt;/h3>
	&lt;ul class="lastart-list unstyled-list">
		&lt;?php $plxShow->lastArtList('&lt;li>&lt;a class="#art_status" href="#art_url" title="#art_title">#art_title&lt;/a>&lt;/li>'); ?>
	&lt;/ul>
<b style="color:green">&lt;!--  insertion du code --></b><b style="color:tomato">&lt;?php if (eval($plxMotor->plxPlugins->callHook('mostViews'))) return; ?></b>		
	&lt;h3>
		&lt;?php $plxShow->lang('TAGS'); ?>
	&lt;/h3>
</code></pre>

<hr>
aperçu administration:
<img src="https://github.com/gcyrillus/plx_artViews/blob/v0.4/vues0.4.jpg">
