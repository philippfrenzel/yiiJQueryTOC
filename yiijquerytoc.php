<?php
 
 /**
 * This class is merely used to publish a TOC based upon the headings within a defined container
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 *
 * Jquery Script from
 * @author @gregfranko
 * @link http://gregfranko.com/jquery.tocify.js/
 * @license Open Sourced under the MIT License
 */

namespace yii2jquerytoc;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget as BaseWidget;

class yiijquerytoc extends BaseWidget
{
	/**
	 * @var array the HTML attributes for the widget container tag.
	 */
	public $options = [];
	
	/**
	* @param context the DOM element to check for headings, default is document.body
	*/	
	public $context = 'body';

	/**
	 * default theme for the tocify
	 * @var string
	 */
	public $theme = 'bootstrap';

	/**
	 * @var array the HTML attributes for the widget container tag.
	 */
	public $clientOptions = [];


	/**
	 * Initializes the widget.
	 * If you override this method, make sure you call the parent implementation first.
	 */
	public function init()
	{
		//checks for the element id
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}

		//checks for the element id
		if (!isset($this->options['class'])) {
			$this->options['class'] = 'tocify';
		}
		
		parent::init();
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		echo Html::beginTag('div', $this->options) . "\n";
		echo Html::endTag('div')."\n";
		$this->registerPlugin();
	}

	/**
	* Registers a specific dhtmlx widget and the related events
	* @param string $name the name of the dhtmlx plugin
	*/
	protected function registerPlugin()
	{		
		$id = $this->options['id'];

		//checks for the element id
		if (!isset($this->clientOptions['context'])) {
			$this->clientOptions['context'] = $this->context;
		}

		//checks for the element id
		if (!isset($this->clientOptions['theme'])) {
			$this->clientOptions['theme'] = $this->theme;
		}

		$view = $this->getView();

		/** @var \yii\web\AssetBundle $assetClass */
		CoreAsset::register($view);
		
		$js = array();
		
		$cleanOptions = Json::encode($this->clientOptions);
		$js[] = "$(function() {var toc$id = $('#$id').tocify($cleanOptions)});";
		
		$view->registerJs(implode("\n", $js),View::POS_READY);
	}

}

