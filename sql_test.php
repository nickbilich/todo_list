<?php 
    include_once 'config.php';
    include_once 'class/DB.php';
    
    session_start();
    $db = new DB();
    //////////////////////////////////////////////////////////
    $query = 'SELECT task_id, status FROM tasks ORDER BY status';
    $res = $db->queryGet($query);
    echo '<b>All tasks ordered by status:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
            echo ' --- ';
            $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT project_id, count(*) as count_tasks FROM tasks GROUP BY project_id';
    $res = $db->queryGet($query);
    echo '<b>Count of all tasks in each project:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT p.id, p.name, count(*) as count_tasks FROM tasks as t, projects as p WHERE p.id = t.project_id GROUP BY t.project_id ORDER BY p.name';
    $res = $db->queryGet($query);
    echo '<b>Count of all tasks in each project ordered by project names:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT task_id, name, project_id FROM tasks WHERE name LIKE "N%"';
    $res = $db->queryGet($query);
    echo '<b>All tasks have N in begining name:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT projects.name, count(*) ' .
              'FROM tasks ' .
              'LEFT OUTER JOIN projects ' .
              'ON project_id = id ' .
              'WHERE (' .
                  'projects.name LIKE "%a%" AND ' .
                  'projects.name NOT LIKE "a%" AND ' .
                  'projects.name NOT LIKE "%a"' .
              ') ' .
              'OR projects.name IS NULL ' .
              'GROUP BY tasks.project_id ' .
         'UNION ' .
              'SELECT projects.name, count(task_id) ' .
              'FROM projects ' .
              'LEFT OUTER JOIN tasks ' .
              'ON projects.id = tasks.project_id ' .
              'WHERE task_id IS NULL ' .
              'GROUP BY tasks.project_id';
    $res = $db->queryGet($query);
    echo '<b>Count tasks in project with a in the middle of the name:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            if ($value == null) {
                $key = '<b style="color: red;">null</b>';
            }
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT t.task_id, t.name FROM tasks as t INNER JOIN (SELECT task_id, name FROM tasks GROUP BY name HAVING count(*) > 1) as n ON n.name = t.name ORDER BY name';
    $res = $db->queryGet($query);
    echo '<b>List of tasks with duplicate name:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT task_id, name, status, (c1 + c2) as count ' .
              'FROM (' .
                  'SELECT t.task_id, t.name, t.status, count as c1 ' .
                  'FROM tasks as t ' .
                  'INNER JOIN (' .
                      'SELECT task_id, status, count(*) as count ' .
                      'FROM tasks ' .
                      'GROUP BY status ' .
                      'HAVING count(*) > 1' .
                  ') as n ' .
                  'ON n.status = t.status' .
              ') t1 ' .
              'INNER JOIN (' .
                  'SELECT t.task_id as task, t.name as name1, count as c2 ' .
                  'FROM tasks as t ' .
                  'INNER JOIN (' .
                      'SELECT task_id, name, count(*) as count ' .
                      'FROM tasks ' .
                      'GROUP BY name ' .
                      'HAVING count(*) > 1' .
                  ') as n ' .
                  'ON n.name = t.name' .
              ') t2 ' .
              'ON t1.task_id = t2.task ' .
              'ORDER BY count';
    $res = $db->queryGet($query);
    echo '<b>List of tasks with duplicate name and status:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
    //////////////////////////////////////////////////////////
    $query = 'SELECT p.id, p.name FROM projects as p INNER JOIN (SELECT t.project_id FROM tasks as t WHERE t.status = 1  GROUP BY t.project_id HAVING count(*) > 10) pid ON pid.project_id = p.id ORDER BY p.id';
    $res = $db->queryGet($query);
    echo '<b>List of tasks with duplicate name:</b><br>Query: ' . $query . '<br>';
    for ($i = 0; $i < count($res); $i++){
        $j = 0;
        foreach ($res[$i] as $key => $value) {
            echo $key . ": " . $value;
            if ($j != (count($res[$i]) - 1))
                echo ' --- ';
                $j++;
        }
        echo '<br>';
    }
    echo '<br>';
   