<?php
/**
 * Utility class for handling URL paths across all pages
 */
class PathHelper {

    private $path_prefix;

    /**
     * @param string $path_prefix the prefix to add to each URL in order to reach the root directory of the site from the page using this class.
     * The default value is "../", so the only page that needs to specify an input is "index.php", which will input an empty string.
     */
    public function __construct($path_prefix="../") {
        $this->path_prefix = $path_prefix;
    }

    /**
     * Puts every path present in base.php inside an associative array containing the relative paths created according to the specified prefix.
     * For instance, if the prefix is "../", the paths will be as follows: "../example_directory/example-page.php"
     * Each URL referenced in base.php should be added inside this function.
     * @return array the associative array containing every path used by base.php
     */
    public function getBasePaths() {
        $paths["login"] = $this->path_prefix."user_management/login.php";
        $paths["logout"] = $this->path_prefix."user_management/logout.php";
        $paths["register"] = $this->path_prefix."user_management/register.php";
        $paths["products"] = $this->path_prefix."products/products-list.php";
        $paths["notification"] = $this->path_prefix."notification/notification.php";
        $paths["shopping_cart"] = $this->path_prefix."shopping-cart/shopping-cart.php";
        $paths["profile"] = $this->path_prefix."profile/profile-settings.php";
        return $paths;
    }

    /**
     * Returns the correct path for the directory containing uploaded files, according to the specified prefix.
     */
    public function getUploadDir() {
        return $this->path_prefix.UPLOAD_DIR;
    }
}

?>