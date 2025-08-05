<?php
function isValidValue($value, $type)
{
    switch ($type) {
        case 'int':
            return is_numeric($value);
        case 'date':
            return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value);
        case 'string':
            return is_string($value);
        default:
            return true;
    }
}
