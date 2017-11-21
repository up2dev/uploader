<?php
/**
 * Created by PhpStorm.
 * User: franz
 * Date: 20/11/17
 * Time: 09:38
 */

namespace TNS\UploadBundle\Annotation;

use Doctrine\Common\Annotations\Reader;


class UploadAnnotationReader {

	/**
	 * @var Reader
	 */
	private $reader;

	public function __construct( Reader $reader ) {

		$this->reader = $reader;
	}

	/**
	 * @param $entity
	 *
	 * @return array
	 */
	public function getUploadableFields( $entity ): array {
		$reflection = new \ReflectionClass( get_class( $entity ) );
		if ( ! $this->isUploadable( $entity ) ) {
			return [];
		}
		$properties = [];
		foreach ( $reflection->getProperties() as $property ) {
			$annotation = $this->reader->getPropertyAnnotation( $property, UploadableField::class );
			if ( $annotation !== null ) {
				$properties[ $property->getName() ] = $annotation;
			}
		}

		return $properties;

	}

	/**
	 * @param $entity
	 *
	 * @return bool
	 */
	public function isUploadable( $entity ): bool {
		$reflection = new \ReflectionClass( get_class( $entity ) );

		return $this->reader->getClassAnnotation( $reflection, Uploadable::class ) !== null;
	}

}