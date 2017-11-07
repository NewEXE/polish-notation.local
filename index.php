<?php
namespace Main;

require_once 'ExpressionList.php';
require_once 'Database/ExpressionTable.php';
require_once 'InfixToPostfix.php';
require_once 'PostfixToInfix.php';

use Main\ExpressionList;
use Database\ExpressionTable;
use Main\InfixToPostfix;
use Main\PostfixToInfix;

$dbParams = include('config/db.php');
$table = new ExpressionTable($dbParams);

$expressions = new ExpressionList($table);
$expressions->parseExpressions();
$expressions->saveExpressions();

$expressionsData = $table->selectData();
$expressions->setExpressions($expressionsData);


$expressions->setExpressions(InfixToPostfix::InfixListToPostfixList($expressions->getExpressions()));
$expressions->saveExpressions();

$expressions->setExpressions(PostfixToInfix::PostfixListToInfixList($expressions->getExpressions()));
$expressions->saveExpressions();