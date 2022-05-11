<?php
  class plx_artViews extends plxPlugin {	 
	
    public function __construct($default_lang) {
	
		# appel du constructeur de la classe plxPlugin (obligatoire)
		parent::__construct($default_lang);
		
		# déclaration des hooks
		$this->addHook('IndexBegin', 'IndexBegin');
		$this->addHook('showViews', 'showViews');
        
        # droits pour accèder à la page config.php du plugin
		$this->setConfigProfil(PROFIL_ADMIN);
		
		
			
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
		
		
		public function showViews() {	
			if (BOTS_OFF == 1 ){
				$bots = array(
					 'google'
					,'msnbot'
					,'ia_archiver'
					,'lycos'
					,'jeeves'
					,'scooter'
					,'fast-webcrawler'
					,'slurp@inktomi'
					,'turnitinbot'
					,'technorati'
					,'yahoo'
					,'findexa'
					,'findlinks'
					,'gaisbo'
					,'zyborg'
					,'surveybot'
					,'bloglines'
					,'blogsearch'
					,'pubsub'
					,'syndic8'
					,'userland'
					,'gigabot'
					,'become.com'
					,'baiduspider'
					,'360spider'
					,'spider'
					,'sosospider'
					,'yandex'
				);	
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
					@$plxMotor->plxPlugins->aPlugins[__CLASS__]->saveParams();
				}
				$infosViews = $var[$plxMotor->plxRecord_arts->f('numero')];		
			
			#affichage vues
				echo '<span class="plx_artViews">'.$infosViews .' '. $plxMotor->plxPlugins->aPlugins[__CLASS__]->getLang('L_VIEWS').'</span>';
				
				
			///////////////////////////////////////////////////////////////////////	
				
				

				

	
				
				
				
				
				
			///////////////////////////////////////////////////////////////////////	
				
		}
	public function mostViews() {
		
		
	}
}
?>	
