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
			
			
			#récuperation contenu article et comptage
				global $plxMotor;
				/* gestion et message de la sauvegarde param */
				include('core/lib/class.plx.msg.php');
				define ('L_SAVE_SUCCESSFUL' ,'');
				define ('L_SAVE_ERR','');
				/* fin reset message sauvegardes */
				
				#comptage des vues				
				$var[$plxMotor->plxRecord_arts->f('numero')] =   $plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('A-'.$plxMotor->plxRecord_arts->f('numero')) ==''  ? '0' :$plxMotor->plxPlugins->aPlugins[__CLASS__]->getParam('A-'.$plxMotor->plxRecord_arts->f('numero')) ;				
				if($plxMotor->mode == 'article') {
					$var[$plxMotor->plxRecord_arts->f('numero')]++;
					$plxMotor->plxPlugins->aPlugins[__CLASS__]->setParam( 'A-'.$plxMotor->plxRecord_arts->f('numero'), $var[$plxMotor->plxRecord_arts->f('numero')], 'numeric') ; 
					@$plxMotor->plxPlugins->aPlugins[__CLASS__]->saveParams();
				}
				$infosViews = $var[$plxMotor->plxRecord_arts->f('numero')];		
			
			#affichage vues
				echo '<span class="plx_artViews">'.$infosViews .' '. $plxMotor->plxPlugins->aPlugins[__CLASS__]->getLang('L_VIEWS').'</span>';
		}
}
?>
