<?php

namespace TNS\UploadBundle\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use TNS\UploadBundle\Annotation\UploadAnnotationReader;
use TNS\UploadBundle\Handler\UploadHandler;

/**
 * Class UploadSubscriber
 * @package TNS\UploadBundle\Listener
 * on implémente la classe EventSubscriber de Doctrine pour pouvoir
 * utiliser cette classe au sein de Doctrine
 */
class UploadSubscriber implements EventSubscriber {

	/**
	 * @var UploadAnnotationReader
	 */
	private $reader;
	/**
	 * @var UploadHandler
	 */
	private $handler;

	public function __construct( UploadAnnotationReader $reader, UploadHandler $handler ) {


		$this->reader  = $reader;
		$this->handler = $handler;
	}


	/**
	 * Returns an array of events this subscriber wants to listen to.
	 *
	 * @return array
	 */
	public function getSubscribedEvents() {
		return [
			'prePersist',
			'preUpdate',
			'postLoad',
			'postRemove'

		];
	}

	/**
	 * @param LifecycleEventArgs $event
	 *
	 */
	public function prePersist( LifecycleEventArgs $event ) {
		$this->preEvent( $event );

	}

	private function preEvent( LifecycleEventArgs $event ) {
		$entity = $event->getEntity();
		foreach ( $this->reader->getUploadableFields( $entity ) as $property => $annotation ) {
			$this->handler->removeOldFile( $entity, $annotation );
			$this->handler->uploadFile( $entity, $property, $annotation );
		}
	}

	public function preUpdate( LifecycleEventArgs $event ) {
		$this->preEvent( $event );
	}

	/**
	 * @param LifecycleEventArgs $event
	 */
	public function postLoad( LifecycleEventArgs $event ) {
		$entity = $event->getEntity();
		foreach ( $this->reader->getUploadableFields( $entity ) as $property => $annotation ) {
			$this->handler->setFileFromFilename( $entity, $property, $annotation );
		}

	}

	public function postRemove( LifecycleEventArgs $event ) {
		$entity = $event->getEntity();
		foreach ( $this->reader->getUploadableFields( $entity ) as $property => $annotation ) {
			$this->handler->removeFile( $entity, $property );
		}
	}
}