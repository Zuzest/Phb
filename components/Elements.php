<?php

class Elements extends ComponentBase {
	public function __construct() {
		$di = $this->getDi();
		$session = $di->getSession();
		// vdump($di);
		$siteversion = $session->get('siteVersion');
		// vdump($session); exit;
		if (!$siteversion) {
			// тут надо определять тип устройства
			$siteversion = $this->detectMobile() ? 'mobile' : 'desktop';
			// $this->siteVersion = $siteversion;
			// } else {
		}
		$this->siteVersion = $siteversion;
		// vdump($this->siteVersion);exit;

		return $this;
	}

	// private $siteVersion = 'mobile';
	// храним версию сайта (desktop|mobile)
	public $siteVersion;

	/*public function detectMobile() {
		include_once $this->config->mobileDetector->classPath;
		$detector = new Mobile_Detect;
		return $detector->isMobile();
	}*/

  public function detectMobile()
  {
    include_once $this->config->plugins->mobileDetectorPath;
    $detector = new Mobile_Detect;
    return $detector->isMobile();
  }
	public function isMobile() {
		if ('desktop' === $this->siteVersion) {
			return false;
		}

		return true;
	}

	public function isDesktop() {
		if ('mobile' === $this->siteVersion) {
			return false;
		}

		return true;
	}

	public function getSiteVersion() {
		return $this->siteVersion;
	}

	public function setSiteVersion($version = 'desktop') {
		// public function setMobile() {
		$versionList = [
			'desktop',
			'mobile',
		];
		$version = in_array($version, $versionList) ? $version : 'desktop';
		$this->session->set('siteVersion', $version);
		$this->cookies->set('siteVersion', $version, time() + 172800)->send();
		// vdump($this->cookies->get('siteVersion')->getValue());exit;
	}

	public function pageReload() {
		$link = $this->getServerLik();
		$link .= $this->request->getURI();
		return $this->response->redirect($link)->send();
	}

	public function getServerLik() {
		return $this->request->getScheme() . '://' . $this->request->getHttpHost();
	}

}
