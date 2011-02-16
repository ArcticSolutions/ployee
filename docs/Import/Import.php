#!/usr/bin/env php
<?

error_reporting(E_ALL); 
ini_set("display_errors", 1); 

$options = getopt('d:i:u:m:p:n:s:h');

if(empty($options['d'])
   or empty($options['i'])
   or empty($options['u'])
   or empty($options['m'])
   or empty($options['p'])
   or empty($options['n'])
   or empty($options['s'])
   or isset($options['h'])) {
    printHelp();
    die();
}

if(!is_dir($options['d'])) {
    die('"'.$options['d'].'" is not a valid dir.'."\n");
}

try{
    $pdo = new PDO('mysql:dbname='.$options['n'].';host='.$options['s'],
                   $options['m'],
                   $options['p'],
                   array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

chdir($options['d']);
echo "Importing users and images from \033[0;31m" . getcwd() . "\033[0m\n";

$dirs = scandir(getcwd());

$userStatement = $pdo->prepare('Select id, username, email From employees Where name = ?');
$createUserStatement = $pdo->prepare('Insert Into employees(name,username,email,password) Values(:name,:username,:email,:password)');
$insertImageStatement = $pdo->prepare('Insert Into images(filename,employee_id,originalname,filename_thumb) Values(:filename,:employee_id,:originalname,:filename_thumb)');

foreach($dirs as $dir) {
    if($dir == '.' or $dir == '..')
        continue;
    echo "Importing: \033[0;32m" . $dir . "\033[0m\n";
    
    //Check if user exists, else create
    
    $userStatement->execute(array(trim($dir)));
    $user = $userStatement->fetch();
    
    
    if(!isset($user['username'])) {
        echo "User not found in database, creating new user\n";
        $data = array(
            'name' => trim($dir),
            'username' => $options['u'],
            'email' => trim(file_get_contents(getcwd() . '/' . $dir . '/email.txt')),
            'password' => substr(md5($dir . time()), 0, 5)
        );
        
        $options['u'] += 1;
        
        try {
            $createUserStatement->execute($data);
        } catch(PDOException $e) {
            echo 'Error creating new user: ' . $e->getMessage() . "\n";
        }
        if($createUserStatement->rowCount() >= 1) {
            $userStatement->execute(array(trim($dir)));
            $user = $userStatement->fetch();
        }
        if(!isset($user['username'])) {
            echo "Error creating new user: skipping \033[0;31m" . $dir . "\033[0m\n";
            continue;
        }
    }
    
    $files = scandir(getcwd() . '/' . $dir);
    
    // Makes image storage directory
    if(!is_dir($options['i'] . '/' . $user['id'])) {
        mkdir($options['i'] . '/' . $user['id']);
    }
    
    // Imports all images for the employee
    foreach($files as $file) {
        // Skips non .jpg files
        if(!preg_match('/.jpg/', $file)) {
            continue;
        }
        echo "Importing image: \033[4;33m" . $file . "\033[0m\n";
        
        // Resize to large image
        resizeImageAndMove(getcwd() . '/' . $dir . '/' . $file, 590, $options['i'] . '/' . $user['id'], $file);
        // Resize to thumb
        resizeImageAndMove(getcwd() . '/' . $dir . '/' . $file, 200, $options['i'] . '/' . $user['id'], 't_' . $file);
        
        $data = array(
            'filename' => $file,
            'employee_id' => $user['id'],
            'originalname' => $file,
            'filename_thumb' => 't_' . $file
        );
        $insertImageStatement->execute($data);
    }
}

echo "\n\nAll done!\n";

$pdo = null;

//-------------------
// Functions
//-------------------
function printHelp()
{
    echo "Usage: -d importdir -i exportdir -u startid -m mysql user -p mysql password -n mysql database -s mysql server\n";
    echo "-d: Directory to import from\n";
    echo "-i: Directory to export to\n";
    echo "-u: User id to start incrementing from, eg. 1000\n";
    echo "-m: Mysql user\n";
    echo "-p: Mysql password\n";
    echo "-n: Mysql database name\n";
    echo "-s: Mysql server address\n";
}

/*
    Function resizeImageAndMove($filename, $width, $newdir, $newname)
    creates a resized image
    variables:
    $filename		Original filename
    $width		width of resized image
    $newdir	        New directory where the file will be saved
    $newname	        Filename of the resized image
*/
function resizeImageAndMove($filename, $width, $newDir, $newName) {
        $sourceImage = imagecreatefromjpeg($filename);
        
	$oldX = imageSX($sourceImage);
	$oldY = imageSY($sourceImage);
        
        $newW = $width;
        $newH = ($oldY / $oldX) * $width;
        
	$destinationImage = ImageCreateTrueColor($newW, $newH);
        
	imagecopyresampled($destinationImage, $sourceImage, 0, 0, 0, 0, $newW, $newH, $oldX, $oldY);
        
	imagejpeg($destinationImage, $newDir . '/' . $newName, 100);
        
	imagedestroy($destinationImage); 
	imagedestroy($sourceImage); 
}