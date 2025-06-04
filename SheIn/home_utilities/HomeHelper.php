<?php
/**
 * This class represents the concept of a section on the home page, 
 * and stores the informations needed to add a new section to the home.
 */
class HomeSection {
    private $title;
    private $data_array;

    public function __construct($title, $data_array) {
        $this->title = $title;
        $this->data_array = $data_array;
    }

    /**
     * Returns the title of the section.
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Returns an array containing the products that must be visualized in the section.
     * @return array
     */
    public function getData() {
        return $this->data_array;
    }
}
?>