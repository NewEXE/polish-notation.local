<?php

namespace Main;

/**
 * Description of ExpressionList
 *
 * @author NewEXE
 */
class ExpressionList {

    private $_expressions;
    private $_table;

    public function __construct(\Database\ExpressionTable $table) {
        $this->_table = $table;
    }
    
    public function setExpressions($expressions) {
        return $this->_expressions = $expressions;
    }
    
    public function getExpressions() {
        return $this->_expressions;
    }

    public function parseExpressions() {
        $page = 2;
        do {
            $uri = 'http://php.art-marks.net/?page=' . $page;
            $data = file_get_contents($uri);
            $regexpLinks = '/<a href="\?page=\d{1,}">(prev|next)<\/a>/';
            preg_match_all($regexpLinks, $data, $matchesLinks);
            $regexpExpressions = '/<li class="equation">([\(\)\d\+\-\/\* ]*)<\/li>/';
            preg_match_all($regexpExpressions, $data, $matchesExpressions);
            $linksOnPage = count($matchesLinks[0]);
            $expressions[] = $matchesExpressions[1];
            $page++;
        } while ($linksOnPage != 1);

        $expressions = call_user_func_array('array_merge', $expressions);
        $this->_expressions = preg_replace('/\s/', '', $expressions);
    }
    
    public function saveExpressions() {
        $this->_table->insertData($this->_expressions);
    }

}
