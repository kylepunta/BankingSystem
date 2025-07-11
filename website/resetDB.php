<?php 
    require($_SERVER["DOCUMENT_ROOT"] . '/db.inc.php');
    
    $dump = '/var/www/html/bankDB.sql';

    if (!file_exists($dump)) {
        die("SQL dump file not found!");
    }
    
    // Escape the password and command
    $command = "mysql -u {$username} -p{$password} {$dbname} < {$dump}";
    
    // Run it
    $output = null;
    $return_var = null;
    exec($command, $output, $return_var);
    
    echo('<form action="./">');

    if ($return_var === 0) {
        echo "<p>Database reset successfully.</p>";
    } else {
        echo "<p>Error resetting database. Return code: $return_var</p>";
    }
    
    echo('<input type="submit" value="Back to home screen"/></form>');
?>