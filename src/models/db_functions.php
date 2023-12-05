<?php
function executeQuery($query, $params = []) 
{
    $connect = mysqli_connect(
        'db',
        'user',
        'password',
        'hospital'
    );

    $stmt = mysqli_prepare($connect, $query);

    if ($params) {
        $types = str_repeat('s', count($params));
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
