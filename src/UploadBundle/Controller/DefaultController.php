<?php

namespace TNS\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	public function indexAction() {
		return $this->render( 'TNSUploadBundle:Default:index.html.twig' );
	}
}
