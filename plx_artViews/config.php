<?php if(!defined('PLX_ROOT')) exit;

	# Control du token du formulaire
	plxToken::validateFormToken($_POST);
	
    if(!empty($_POST)) {
        $plxPlugin->setParam('excludeBots', $_POST['excludeBots'], 'numeric'); 
        $plxPlugin->setParam('nbArts', $_POST['nbArts'], 'numeric'); 
        $plxPlugin->saveParams();
		header('Location: parametres_plugin.php?p='.$plugin);
	exit;
    }
	$var['excludeBots'] = $plxPlugin->getParam('excludeBots')=='' ?  1 	: $plxPlugin->getParam('excludeBots');
	$var['nbArts'	  ] = $plxPlugin->getParam('nbArts'		)=='' ?  5 	: $plxPlugin->getParam('nbArts'     );
	

?>

<form action="parametres_plugin.php?p=<?php echo $plugin ?>" method="post" id="plx_artViews">
	<fieldset>
		<legend>Configuration</legend>
			<label><?php echo $plxPlugin->getLang('L_EXCLUDE_BOTS') ?>	:</label><?php plxUtils::printSelect('excludeBots',array('1'=>L_YES,'0'=>L_NO),$var['excludeBots']); ?>
			<label><?php echo $plxPlugin->getLang('L_NBARTS_SHOW')  ?>	:</label><input type="text" name="nbArts" size="2" value="<?php  echo $var['nbArts'] ?>" />
			<label><?php echo $plxPlugin->getLang('L_SAVE_TO_UPDATE') ?>	:</label><input type="submit" name="submit" value="<?php $plxPlugin->lang('L_SAVE') ?>" />
			<?php echo plxToken::getTokenPostMethod() ?>
			<label><?php echo $plxPlugin->getLang('L_PLUGIN_DEFAULT_SETTING') ?>	:</label><button id="reset"><?php echo $plxPlugin->getLang('L_RESET_TO_DEFAULT') ?></button>
			<b><?php echo $plxPlugin->getLang('L_VIEW_CODE') ?></b>
			<label for="code"><?php echo $plxPlugin->getLang('L_CODE_TO_INSERT_TO_TPLS') ?>:</label><textarea id="code" readonly cols="68" rows="1" style="resize:none;height:1.8em;">&lt;?php if (eval($plxMotor->plxPlugins->callHook('showViews'))) return; ?&gt;</textarea>
			<!--<b><?php echo $plxPlugin->getLang('L_VIEW_LIST_CODE') ?></b>-->
			<label for="codeList"><?php echo $plxPlugin->getLang('L_CODE_TO_INSERT_MOST') ?>:</label><textarea id="codeList" readonly cols="68" rows="1" style="resize:none;height:1.8em;">&lt;?php if (eval($plxMotor->plxPlugins->callHook('mostViews'))) return; ?&gt;</textarea>
	</fieldset>


</form>
	<div id="infos">
		<h3><?php echo $plxPlugin->getLang('L_VIEWS_INFOS') ?> </h3>
		<div>
		<p><?php echo $plxPlugin->getLang('L_TOTAL_VIEWS') ?>: <?php $plxPlugin->mostViews('total'); ?> </p>
		</div>
		<div>
		<?php $plxPlugin->mostViews(''); ?>
		</div>
	</div>
<script>
(function () {
	 let defautSettings = {excludeBots: 1 , nbArts: 5 };
	let resetFields= document.querySelectorAll('input[type="text"], textarea, select');
function reset() {
	for (i=0; i < resetFields.length;i++) {
		resetFields[i].value= defautSettings[resetFields[i].getAttribute('name')]
	}
}
function copy() {
  let code = document.querySelector("#code");  
  let statut = document.querySelector("[for='code']");
  code.select();
  document.execCommand("copy");
  statut.innerHTML="<?php echo $plxPlugin->getLang('L_CODE_TO_INSERT_COPIED') ?>";
}
function copylist() {
  let code = document.querySelector("#codeList");  
  let statut = document.querySelector("[for='codeList']");
  code.select();
  document.execCommand("copy");
  statut.innerHTML="<?php echo $plxPlugin->getLang('L_CODE_TO_INSERT_COPIED') ?>";
}
document.querySelector("#reset").addEventListener ("click", reset, false);	
document.querySelector("#code").addEventListener ("click", copy, false);	
document.querySelector("#codeList").addEventListener ("click", copylist, false);	


})();
</script>