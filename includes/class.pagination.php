<?php

class Pagination {
   private $current_page;
   private $per_page;
   private $total_records;

   function __construct($current_page=1, $per_page=9, $total_records=0) {
       $this->current_page   = (int) $current_page;
       $this->per_page       = (int) $per_page;
       $this->total_records = (int) $total_records;
   }

   //static methods for calling class
   public static function make($current_page, $per_page, $total_records) {
       return new static($current_page, $per_page, $total_records);
   }

   public function offset() {
       return ($this->current_page - 1) * $this->per_page;
   }

   public function totalPages() {
       return ceil($this->total_records/$this->per_page);
   }

   public function previousPage() {
       return $this->current_page - 1;
   }

   public function nextPage() {
       return $this->current_page + 1;
   }

   // Previous and next pages
   public function hasPreviousPage() {
       return ($this->previousPage() >= 1) ? true : false;
   }

   public function has_next_page() {
       return ($this->nextPage() <= $this->totalPages()) ? true : false;
   }
}
?>
