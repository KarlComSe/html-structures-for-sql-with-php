<?php 
/**
 *
 * This function is copied from p. 456, PHP & MySQL by J. Ducket.
 * Returns a PDO object, on which it is possible to use fetch, fetchAll, fetchColumn.
 *
 */

function pdo(PDO $pdo, string $sql, array $arguments = null)
{
    if (!$arguments) {
        return $pdo->query($sql);
    }
    $statement = $pdo->prepare($sql);
    $statement->execute($arguments);
    return $statement;
}

/**
 * Exception handler to print out a HTML message with details on the exception,
 * useful to deal with uncaught exceptions.
 *
 * @return object as the database connection object.
 */
function connectToDatabase(string $dsna): object
{
    try {
        $db = new PDO($dsna);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database using DSN:<br>'$dsna'<br>";
        throw $e;
    }
    return $db;
}

$sqlStatement = <<<END
  SELECT
    *
  FROM example;
  END;

// Connect to the database
$dsn = "sqlite:./example.db";
$db = connectToDatabase($dsn);

?>
<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta charset="utf-8">
  <title>HTML for structuring database results with PHP</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="none.css">
  <style>
    .grid-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
    }
    table {
      border: 1px solid purple;
      border-collapse: collapse;
    }
  </style>
</head>

<body>
  <main>
    <h1>This shows various ways to structure database data using PHP and HTML</h1>
    <p>
      This file uses PHP and HTML, together with the SQLITE file example.db.
    </p>
    <blockquote>

    </blockquote>
    <article>
      <h2>Example with tables</h2>
      <table>
        <caption>
          My table
        </caption>
        <thead>
          <tr>
            <th scope='col'>Header 1</th>
            <th scope='col'>Header 2</th>
            <th scope='col'>Header 3</th>
            <th scope='col'>Header 4</th>
            <th scope='col'>Header 5</th>
          </tr>
        </thead>
        <tbody>
<?php
$results = pdo($db, $sqlStatement)->fetchAll();
?>
<?php foreach($results as $key=>$row):
$row['data1'] = htmlspecialchars($row['data1']);
$row['data2'] = htmlspecialchars($row['data2']);
$row['data3'] = htmlspecialchars($row['data3']);
$row['data4'] = htmlspecialchars($row['data4']);
$row['data5'] = htmlspecialchars($row['data5']);

echo 
    <<<END
        <tr>
            <th scope = 'row'>{$row['data1']}</th>
            <td>{$row['data2']}</td>
            <td>{$row['data3']}</td>
            <td>{$row['data4']}</td>
            <td>{$row['data5']}</td>
        </tr>
    END;
endforeach;  
    ?>
        </tbody>
      </table>
    </article>
    <article>
      <h2>Example with list</h2>
      <figure>
        <figcaption>My list</figcaption>
        <ul>
<?php
$results = pdo($db, $sqlStatement)->fetchAll();
?>
<?php foreach($results as $row):
$row['data1'] = htmlspecialchars($row['data1']);
$row['data2'] = htmlspecialchars($row['data2']);
$row['data3'] = htmlspecialchars($row['data3']);
$row['data4'] = htmlspecialchars($row['data4']);
$row['data5'] = htmlspecialchars($row['data5']);
echo 
    <<<END
          <li>{$row['data1']}
            <ul>
              <li>{$row['data2']}</li>
              <li>{$row['data3']}</li>
              <li>{$row['data4']}</li>
              <li>{$row['data5']}</li>
            </ul>
          </li>
    END;
endforeach;
?>
        </ul>
      </figure>
    </article>
    <article>
      <h2>Example with form</h2>
<?php
$results = pdo($db, $sqlStatement)->fetchAll();
?>
<?php foreach($results as $key=>$row):
$key = htmlspecialchars($key);
$row['data1'] = htmlspecialchars($row['data1']);
$row['data2'] = htmlspecialchars($row['data2']);
$row['data3'] = htmlspecialchars($row['data3']);
$row['data4'] = htmlspecialchars($row['data4']);
$row['data5'] = htmlspecialchars($row['data5']);
echo 
    <<<END
      <form method='post'>
        <fieldset>
          <legend>Row from the result set: {$row['data1']}</legend>
          <ul>
            <li>
              <label for='{$key}1'>Data1:</label>
              <input type='text' id='{$key}1' name='data1' value='{$row['data1']}'>
            </li>
            <li>
              <label for='{$key}2'>Data2:</label>
              <input type='text' id='{$key}2' name='data2' value='{$row['data2']}'>
            </li>
            <li>
              <label for='{$key}3'>Data3:</label>
              <input type='text' id='{$key}3' name='data3' value='{$row['data3']}'>
            </li>
            <li>
              <label for='{$key}4'>Data4:</label>
              <input type='text' id='{$key}4' name='data4' value='{$row['data4']}'>
            </li>
            <li>
              <label for='{$key}5'>Data5:</label>
              <input type='text' id='{$key}5' name='data5' value='{$row['data5']}'>
            </li>
            <li class='button'>
              <button type="submit">Submit</button>
            </li>
          </ul>
        </fieldset>
      </form>
      END;
endforeach;
?>
    </article>
    <article>
      <h2>Example with grid layout</h2>
      <p>
        3 column grid.
      </p>
      <div class='grid-container'>
<?php
$results = pdo($db, $sqlStatement)->fetchAll();
?>
<?php foreach($results as $row):
$row['data1'] = htmlspecialchars($row['data1']);
$row['data2'] = htmlspecialchars($row['data2']);
$row['data3'] = htmlspecialchars($row['data3']);
$row['data4'] = htmlspecialchars($row['data4']);
$row['data5'] = htmlspecialchars($row['data5']);
echo 
    <<<END
        <div class='grid-item'>
          <h3>{$row['data1']}</h3>
          <ul>
            <li>{$row['data2']}</li>
            <li>{$row['data3']}</li>
            <li>{$row['data4']}</li>
            <li>{$row['data5']}</li>
          </ul>
        </div>
        END;
endforeach;
        ?>
      </div>
    </article>
  </main>
</body>
</html>
<?php
