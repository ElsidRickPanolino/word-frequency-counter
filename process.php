<?php 
    $txt = $_POST["text"];

    function removePunctuation(string $txt){
        $punctuations = " .,!?;:-()[]{}\"'/\\|&#@";

        $words = [];

        $token = strtok($txt, $punctuations);

        while ($token !== false)
        {
        array_push($words, $token);
        $token = strtok($punctuations);
        }
        return $words;
    }

    function removeCommonWords(array $str){
        $common_words = ["the", "a", "is", "this", "an", "and", "s", "at", "but", "if"
        ,"in", "it", "of", "on", "or", "to", "with", "s", "as"];
    
        $str = array_map('strtolower', $str);
    
        $result = array_diff($str, $common_words);
    
        $result = array_values($result);
    
        return $result;
    }

    function textToArray(string $txt){
        $txt_array = removePunctuation($txt);
        $txt_array = removeCommonWords($txt_array);    

        return $txt_array;
    }

    function countWords($wordsArray) {
        $wordCounts = [];

        foreach ($wordsArray as $word) {
            if (isset($wordCounts[$word])) {
                $wordCounts[$word]++;
            } else {
                $wordCounts[$word] = 1;
            }
        }     
        $resultArray = array(); 
        foreach ($wordCounts as $word => $count) {
            $resultArray[] = array('word' => $word, 'count' => $count);
        }
    
        return $resultArray;
    }

    $arr = countWords(textToArray($txt));

    for ($i = 0; $i < count($arr); $i++) {
        echo $arr[$i]["word"]."=".$arr[$i]["count"]."<br>";
       }

?>
