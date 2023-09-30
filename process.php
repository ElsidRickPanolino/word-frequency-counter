<?php 
    $txt = $_POST["text"];
    $limit = $_POST["limit"];
    $sort = $_POST["sort"];

    function removePunctuation(string $txt){
        $punctuations = " .,!?;:-()[]{}\"'/\\|&#@–\n";

        $words = [];

        $txt = preg_replace('/\n/', ' ', $txt);

        $token = strtok($txt, $punctuations);

        while ($token !== false)
        {
        array_push($words, $token);
        $token = strtok($punctuations);
        }
        return $words;
    }


    function removeCommonWords(array $str){
        $common_words = ["i", "the", "a", "is", "this", "an", "and", "at", "but", "if"
        ,"in", "it", "of", "on", "or", "to", "with", "as", "s"];

        $empty_string = [" ","\n", ""];

        $alphabet = range('a', 'z');
    
        $str = array_map('strtolower', $str);
    
        //remove common words
        while (true) {
            $commonElements = array_intersect($str, $common_words);
            
            if (empty($commonElements)) {
                break;
            }
        
            foreach ($commonElements as $value) {
                $index = array_search($value, $str);
                if ($index !== false) {
                    unset($str[$index]);
                }
            }
        }

        //remove empty string
        while (true) {
            $commonElements = array_intersect($str, $empty_string);
            
            if (empty($commonElements)) {
                break;
            }
        
            foreach ($commonElements as $value) {
                $index = array_search($value, $str);
                if ($index !== false) {
                    echo "remove ".$str[$index];
                    unset($str[$index]);
                }
            }
        }       
            
        return $str;
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

    function sortByCount($a, $b) {
        return $b['count'] - $a['count'];
    }

    usort($arr, 'sortByCount'); 

    echo "<table>";
    echo "<tr><th>index</th><th>word</th><th>frequency</th>";

    if ($sort == 'asc'){
        for ($i = count($arr)-1; $i >= count($arr)-$limit; $i--) {
            $index = count($arr)-$i;
            echo "<tr>"."<td>$index</td>"."<td>".$arr[$i]["word"]."</td>"."<td>".$arr[$i]["count"]."</td>"."</tr>";
           }
    }
    elseif($sort == 'desc'){
        for ($i = 0; $i < $limit; $i++) {
            $index = $i+1;
            echo "<tr>"."<td>$index</td>"."<td>".$arr[$i]["word"]."</td>"."<td>".$arr[$i]["count"]."</td>"."</tr>";
           }
    
    }
    echo "</table>";
?>
