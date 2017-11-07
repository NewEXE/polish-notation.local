<?php

namespace Main;

/**
 * Description of InfixToPostfix
 *
 * @author NewEXE
 */
class InfixToPostfix {

    public static function InfixToPostfix($str) {
        $stack = $outString = $rpn = [];

        $priority = ['*' => ['priority' => '2'],
            '/' => ['priority' => '2'],
            '+' => ['priority' => '1'],
            '-' => ['priority' => '1'],
        ];

        $str = preg_replace('/\s/', '', $str);
        $strArray = str_split($strArray);

        if (preg_match('/[\+\-\*\/]/', $strArray['0'])) {
            array_unshift($strArray, '0');
        }

        $markerNum = TRUE;
        foreach ($strArray as $char) {

            if (preg_match("/[\+\-\*\/\^]/", $char)) {
                $markerEndOperators = FALSE; 

                while ($markerEndOperators != TRUE) {
                    $lastOperator = array_pop($stack);
                    if ($lastOperator == '') {
                        $stack[] = $char;
                        $markerEndOperators = TRUE;
                    } else {
                        $currentOperatorPriority = $priority[$char]['priority'];
                        $previousOperatorPriority = $priority[$lastOperator]['priority'];

                        switch ($currentOperatorPriority) {
                            case ($currentOperatorPriority > $previousOperatorPriority):
                                $stack[] = $lastOperator;
                                $stack[] = $char;
                                $markerEndOperators = TRUE;
                                break;

                            case ($currentOperatorPriority <= $previousOperatorPriority):
                                $outString[] = $lastOperator;
                                break;
                        }
                    }
                }

                $markerNum = false;
            } elseif (preg_match('/[0-9\.]/', $char)) {
                if ($markerNum == TRUE) {
                    $num = array_pop($outString);
                    $outString[] = $num . $char;
                } else {
                    $outString[] = $char;
                    $markerNum = TRUE;
                }
            } elseif ($char == '(') {
                $stack[] = $char;
                $markerNum = FALSE;
            } elseif ($char == ')') {
                $markerOpeningBracket = FALSE;
                while ($markerOpeningBracket != TRUE) {
                    $operator = array_pop($stack);
                    if ($operator == '(') {
                        $markerOpeningBracket = TRUE;
                    } else {
                        $outString[] = $operator;
                    }
                }

                $markerNum = FALSE;
            }
        }

        $rpn = $outString;

        while ($tempStack = array_pop($stack)) {
            $rpn[] = $tempStack;
        }

        $rpnStr = implode(' ', $rpn);
        return $rpnStr;
    }

    public static function InfixListToPostfixList($expressions) {
        $postfixList = [];
        foreach ($expressions as $str) {
            $postfixList[] = self::InfixToPostfix($str);
        }
        return $postfixList;
    }

}
