<?php
  class plx_artViews extends plxPlugin {	 
	
    public function __construct($default_lang) {
	
		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		
		# déclaration des hooks
		$this->addHook('IndexBegin', 'IndexBegin');
		$this->addHook('showViews', 'showViews');
		$this->addHook('mostViews', 'mostViews');
        
        # droits pour accèder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);
		
		// initialize la constabte BOTS_OFF , false par défaut.
		if ($this->getParam('excludeBots') ==='1') { define('BOTS_OFF', true);} else { define('BOTS_OFF', false);}		

    }
        # désactive de force la compression gzip 
        public function  IndexBegin() {
            echo '<?php ';
			?>
			$plxMotor->aConf['gzip'] ='0';
            ?>
			<?php 

        }		
		#code à exécuter à l’activation du plugin
		/* config par defaug  */	
        public function OnActivate() { 
			global $plxMotor;
			$plxMotor->plxPlugins->aPlugins[__CLASS__]->setParam( 'excludeBots', 1 , 'numeric') ; 
			$plxMotor->plxPlugins->aPlugins[__CLASS__]->setParam( 'nbArts', 	 5 , 'numeric') ; 
			$plxMotor->plxPlugins->aPlugins[__CLASS__]->saveParams();		
		}		
		
		public function showViews() {	
			if (BOTS_OFF === true ){
				$bots = array('google','msnbot','ia_archiver','lycos','jeeves','scooter','fast-webcrawler','slurp@inktomi','turnitinbot','technorati','yahoo','findexa','findlinks','gaisbo','zyborg','surveybot','bloglines','blogsearch','pubsub','syndic8','userland','gigabot','become.com','baiduspider','360spider','spider','sosospider','yandex');	
			}
			else {
				$bots = array();
			}	
			
			#récuperation contenu article et comptage
				global $plxMotor;
			/* gestion et message de la sauvegarde param en silencieux*/
				include_once('core/lib/class.plx.msg.php');
				defined('L_SAVE_SUCCESSFUL') or define('L_SAVE_SUCCESSFUL', '');
				defined('L_SAVE_ERR') or define('L_SAVE_ERR', '');
			/* fin reset message sauvegardes */
				
			#comptage des vues				
				$var[$plxMotor->plxRecord_arts->f('numero')] =   $plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('A-'.$plxMotor->plxRecord_arts->f('numero')) ==''  ? '0' :$plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('A-'.$plxMotor->plxRecord_arts->f('numero')) ;				
				$useragent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
				if($plxMotor->mode == 'article'  &&  (!in_array($useragent, $bots))){
					$var[$plxMotor->plxRecord_arts->f('numero')]++;
					$plxMotor->plxPlugins->aPlugins[__CLASS__]->setParam( 'A-'.$plxMotor->plxRecord_arts->f('numero'), $var[$plxMotor->plxRecord_arts->f('numero')], 'numeric') ; 
					$plxMotor->plxPlugins->aPlugins[__CLASS__]->saveParams();
				}
				$infosViews = $var[$plxMotor->plxRecord_arts->f('numero')];		
			
			#affichage vues
				echo '<span class="plx_artViews">'.$infosViews .' '. $plxMotor->plxPlugins->aPlugins[__CLASS__]->getLang('L_VIEWS').'</span>';

				
		}
		public function mostViews($option) {
			// or load as file
			$stats = new SimpleXMLElement(PLX_ROOT.PLX_CONFIG_PATH.'plugins/'.__CLASS__.'.xml',null,true);
			$totalNum =0;		
			foreach($stats as $artViewved ) {
				$num='';
				if ( substr($artViewved['name'],0,2) == 'A-'){ 
					$num=   $artViewved->attributes()->name ;
					$num =  substr("$num",2,8);
					$list["$num"]= "$artViewved";
					$totalNum = $totalNum + $list["$num"];				
				}
			}	
			// sort harvest
			arsort($list);
			// get articles datas			
			$plxMotor = plxMotor::getinstance();
			foreach($plxMotor->plxGlob_arts->aFiles as $v) {
					$art = $plxMotor->parseArticle(PLX_ROOT . $plxMotor->aConf['racine_articles'] . $v);
					if(!empty($art)) {
						$artsList[$art['numero']] = $art;
					}
				}

			if ($option == '') {
				// print most viewed article 
				$i=0;
			echo PHP_EOL.'			<h3>'. $plxMotor->plxPlugins->aPlugins[__CLASS__]->getLang('L_MOST_VIEWED').'</h3>
			<ul class="mostViewed unstyled-list">'.PHP_EOL;
				foreach($list as $numero => $val) {
					$i++;
					$find =str_pad( $numero,4,"0", STR_PAD_LEFT);// format expected
					echo '				<li>
					<a href="'.$plxMotor->urlRewrite('?article' . ltrim($numero,'0') . '/' . $artsList[$find]['url']).'" title="'.$artsList[$find]['title'].'">'. $artsList[$find]['title'].' ('.$list[$find].') </a>
				</li>'.PHP_EOL;
					if($i == $plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('nbArts')) break;
				}
			echo '			</ul>'.PHP_EOL;
			}
			if($option == 'total') {
				echo $totalNum;
			}	
		}
}
?>	
