<?php

namespace Main;

/**
 * Description of PostfixToInfix
 *
 * @author NewEXE
 */
class PostfixToInfix {

    public static function PostfixToInfix($rpnExp) {
        $stack = [];
        $rpnExpArray = explode(" ", $rpnExp);
        foreach ($rpnExpArray as $item) {
            if (self::isNumber($item)) {
                array_push($stack, $item);
            } else if (self::isOperator($item)) {
                $op2 = array_pop($stack);
                $op1 = array_pop($stack);
                $result = 0;
                switch ($item) {
                    case '+':
                        $result = $op1 + $op2;
                        array_push($stack, $result);
                        break;
                    case '-':
                        $result = $op1 - $op2;
                        array_push($stack, $result);
                        break;
                    case '*':
                        $result = $op1 * $op2;
                        array_push($stack, $result);
                        break;
                    case '/':
                        $op2 == 0.0 ? array_push($stack, 'division by zero') : array_push($stack, $op1 / $op2);
                        break;
                    default:
                        throw new Exception($item . "Operator is not implemented.");
                }
            }
        }
        return array_pop($stack);
    }

    private static function isNumber($char) {
        if (preg_match('/^[0-9]*$/', trim($char))) {
            return true;
        }
        return false;
    }

    private static function isOperator($char) {
        $operators = ['+', '-', '/', '*'];
        if (in_array($char, $operators)) {
            return true;
        }
        return false;
    }

    public static function PostfixListToInfixList($expressions) {
        $infixList = [];
        foreach ($expressions as $str) {
            $infixList[] = self::PostfixToInfix($str);
        }
        return $infixList;
    }

}
