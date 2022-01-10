 <?php
  
  class FormSanitizer{
      public static function sanitizeFormString($inputText){

        $inputText =strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
        //inputText=trim($inputText);
        $inputText=strtolower($inputText);
        $inputText=ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeFormLastname($inputText){

        $inputText =strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
        //inputText=trim($inputText);
        $inputText=strtolower($inputText);
        $inputText=ucfirst($inputText);
        return $inputText;
    }

    public static function sanitizeFormPassword($inputText){

        $inputText =strip_tags($inputText);
         return $inputText;
        
    }

    public static function sanitizeFormPhonenumber($inputText){
        $inputText = filter_var($inputText, FILTER_SANITIZE_NUMBER_INT);
        $inputText= str_replace(" ","", $inputText);
        return $inputText;
        
    }

    public static function sanitizeFormEmail($inputText){

        $inputText =strip_tags($inputText);
        $inputText=str_replace(" ","",$inputText);
         return $inputText;
    }
  }

 ?>