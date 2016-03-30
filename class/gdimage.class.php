<?php
/**
*@author PIERRET Theo , OUDINOT Antoine , LEPAUL Robin , GRANGER Yohan , LEFEVE Marine , TRIPET Mathilde
*/
setlocale(LC_ALL, 'fr_FR.utf8') ;

/**
 * @author Jérôme Cutrona
 *
 */
class GDImage {
    const GD      = 'gd' ;
    const GD2PART = 'gd2part' ;
    const GD2     = 'gd2' ;
    const GIF     = 'gif' ;
    const JPEG    = 'jpeg' ;
    const PNG     = 'png' ;
    const WBMP    = 'wbmp' ;
    const XBM     = 'xbm' ;
    const XPM     = 'xpm' ;

    /**
     * @var array
     */
    private static $_factory_types = array(
            self::GD,
            self::GD2PART,
            self::GD2,
            self::GIF,
            self::JPEG,
            self::PNG,
            self::WBMP,
            self::XBM,
            self::XPM,
            ) ;

    /**
     * @var resource $_resource image identifier
     */
    private $_resource = null ;

    private function __construct() {
    }

    /**
     * @return void
     */
    public function __destruct() {
        if (!is_null($this->_resource))
            imageDestroy($this->_resource) ;
    }

    /**
     * Factory to create a GDImage instance from width and height parameters.
     * 
     * @param int $x width
     * @param int $y height
     * @param boolean $truecolor creates a truecolor image if true and a palette based image otherwise
     * @return GDImage
     */
    public static function createFromSize($x, $y, $truecolor=true) {
        $x = (int) $x ;
        $y = (int) $y ;
        $resource = false ;
        if ($truecolor)
            $resource = @imageCreateTrueColor($x, $y) ;
        else
            $resource = @imageCreate($x, $y) ;
        if ($resource !== false) {
            $image = new self() ;
            $image->_resource = $resource ;
            return $image ;
        }
        else
            throw new LogicException("Failed to create GD resource") ;
    }

    /**
     * Factory to create a GDImage instance from filename and filetype paramters.
     * 
     * @param string $filename name of the file
     * @param string $filetype type of the file (must be an element of self::$_factory_types)
     * @return GDImage
     */
    public static function createFromFile($filename, $filetype) {
        if (is_file($filename)) {
            if (in_array($filetype, self::$_factory_types)) {
                $functionName = 'imageCreateFrom' . $filetype ;
                $image = new self() ;
                if (($tmp = @$functionName($filename)) === false) {
                    throw new Exception("unable to load file '{$filename}'") ;
                }
                $image->_resource = $tmp ;
                return $image ;
            }
            else {
                throw new Exception("unknown filetype") ;
            }
        }
        else {
            throw new Exception("{$filename} : no such file") ;
        }
    }

    /**
     * Factory to create a GDImage instance from filename and filetype paramters.
     * 
     * @param string $filename name of the file
     * @param string $filetype type of the file (must be an element of self::$_factory_types)
     * @return GDImage
     */
    public static function createFromString($data) {
        if (($tmp = imageCreateFromString($data)) !== false) {
            $image = new self() ;
            $image->_resource = $tmp ;
            return $image ;
        }
        else {
            throw new Exception("unable to load data") ;
        }
    }

    /**
     * Trap "inaccessible methods" to invoke GD functions, if available.
     * If a method named 'colorAllocate' is trapped, it will try to invoke 'imageColorAllocate' function.
     *
     * @param $methodName name of the "inaccessible method"
     * @param $methodArguments array of the arguments of the "inaccessible method"
     */
    public function __call($methodName, $methodArguments) {
        $gdFunction = "image{$methodName}" ;
        if (function_exists($gdFunction)) {
            // Prevent direct call of imageCreateFrom...
            if (mb_eregi('^imageCreateFrom', $gdFunction)) {
                throw new BadMethodCallException("Forbidden method call " . get_class($this) . "::{$methodName}") ;
            }
            // Special case of copy functions
            if (mb_eregi('^(copy|colormatch)', $methodName)) {
                // First parameter of the method should be an instance of the class
                if (isset($methodArguments[0]) && $methodArguments[0] instanceof self) {
                    // Preparing argument for GD function call
                    $methodArguments[0] = $methodArguments[0]->_resource ;
                }
                else
                    throw new InvalidArgumentException("First parameter of '".get_class($this)."::{$methodName}' should be an instance of ".get_class($this)) ;
            }
            // Avoid function which first parameter is not an image resource
            if (!mb_eregi('^(imagefont|imageftbbox|imagegrab|imagegrab|imageloadfont|imageps|imagetypes)', $gdFunction)) {
	            // First parameter should be the image resource
	            array_unshift($methodArguments, $this->_resource) ;
            }
            // Call GD function
            $returnValue = @call_user_func_array($gdFunction, $methodArguments) ;
            if ($returnValue !== null) {
                if (is_resource($returnValue)) {
                    $newImage = new GDImage() ;
                    $newImage->_resource = $returnValue ;
                    return $newImage ;
                }
                else {
                    return $returnValue ;
                }
            }
            else
                throw new BadMethodCallException("Error in " . get_class($this) . "::{$methodName}") ;
        }
        else
        	throw new BadMethodCallException("Unknow method call: " . get_class($this) . "::{$methodName}") ;
    }

/*
    public static function fontHeight() {
        $args = &func_get_args() ;
        return call_user_func_array('imageFontHeight', $args) ;
    }

    public static function fontWidth() {
        $args = &func_get_args() ;
        return call_user_func_array('imageFontWidth', $args) ;
    }

    public static function ftbBox() {
        $args = &func_get_args() ;
        return call_user_func_array('imageFtbBox', $args) ;
    }

    public static function grabScreen() {
        $args = &func_get_args() ;
        return call_user_func_array('imageGrabScreen', $args) ;
    }

    public static function grabWindow() {
        $args = &func_get_args() ;
        return call_user_func_array('imageGrabWindow', $args) ;
    }

    public static function loadFont() {
        $args = &func_get_args() ;
        return call_user_func_array('imageLoadFont', $args) ;
    }
*/

    /**
     * Retrieve information about the currently installed GD library.
     * 
     * @return array Returns an associative array.
     */
    public static function info() {
        return gd_info() ;
    }

    /**
     * Get the size of an image.
     * 
     * @param string $filename This parameter specifies the file you wish to retrieve information about.
     * @param array $imageinfo This optional parameter allows you to extract some extended information from the image file.
     * @return array Returns an array with 7 elements.
     */
    public static function getImageSize($filename, &$imageinfo=array()) {
        return @getimagesize($filename, $imageinfo) ;
    }

    /**
     * Trap "inaccessible static methods" to invoke GD functions, if available.
     * If a method named 'iptcembed' is trapped, it will try to invoke 'iptcembed' function
     *
     * @param $methodName name of the "inaccessible method"
     * @param $methodArguments array of the arguments of the "inaccessible method"
     */
    // /*
    public static function __callStatic($methodName, $methodArguments) {
        $gdFunction = !function_exists($methodName) ? 'image'.$methodName : $methodName ;
        if (function_exists($gdFunction) && !mb_eregi('^imageCreateFrom', $gdFunction)) {
            $returnValue = call_user_func_array($gdFunction, $methodArguments) ;
            if ($returnValue !== null)
                return $returnValue ;
            else
                throw new BadMethodCallException('Error in ' . get_class() . "::{$methodName}") ;    		
        }
        else
            throw new BadMethodCallException("Call to unknow static method " . get_class() . "::{$methodName}") ;
    }
     // */

    /**
     * @return void
     */
    public function __clone() {
        if (!$this->isTrueColor()) {
            if (($tmp = @imageCreate($this->sx(), $this->sy())) === false) {
                throw new Exception("unable to clone GDImage") ;
            }
            imagePaletteCopy($tmp, $this->_resource) ;
        }
        else {
            if (($tmp = @imageCreateTrueColor($this->sx(), $this->sy())) === false) {
                throw new Exception("unable to clone GDImage") ;
            }
        }
        imageCopy($tmp, $this->_resource, 0, 0, 0, 0, $this->sx(), $this->sy()) ;
        $this->_resource = $tmp ;
    }
}
