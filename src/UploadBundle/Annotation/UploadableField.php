<?php
/**
 * Created by PhpStorm.
 * User: franz
 * Date: 20/11/17
 * Time: 09:16
 */

namespace TNS\UploadBundle\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;


/**
 * Class UploadableField
 * @package TNS\UploadBundle\Annotation
 * @Annotation
 * @Target("PROPERTY")
 *
 */
class UploadableField {

	/**
	 * @var string
	 */
	private $filename;

	/**
	 * @var string
	 */
	private $path;


	public function __construct( array $options ) {
		if ( empty( $options['filename'] ) ) {
			throw new \InvalidArgumentException( "L'annotation UploadableField doit avoir un attribut 'filename'" );
		}
		if ( empty( $options['path'] ) ) {
			throw new \InvalidArgumentException( "L'annotation UploadableField doit avoir un attribut 'path'" );
		}
		$this->filename = $options['filename'];
		$this->path     = $options['path'];
	}

	/**
	 * @return string
	 */
	public function getFilename() {
		return $this->filename;
	}

	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

}