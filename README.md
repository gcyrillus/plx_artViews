# plx_artViews
Compteur de vues
<div id="help">
<h2>Aide du plugin</h2>
	
<h3>Configuration</h3>
<p>Aucune à proprement dit</p>
<h3>Affichage Dans les fichiers des  théme</h3>
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

<hr></div>
