<?php
/*
 * Information:
 * Author: EMRE CEBECİ
 * Version: v1.3
 * Release Date: 4/19/2020
 * -----------------------
 * Sessions:
 * Session "word-given", if user has a word this session is true else false.
 * Session "word", if user has a word this session is that word else null.
 * Session "word-lenght", word's letter count.
 * Session "hint", if user has a hint this session is that hint for specify word else null.
 * Session "wrongs", user's wrong letter count.
 * Session "confirms", user's confirmed letter count.
 * Session "expected-confirms", expecting confirmed letter count.
 * Session "displayletter_$i", chosen word's displaying letter $i.
 * Session "letter_$i", chosen word's letter $i.
 * Session "onload-scripts", body onload's value.
 * Session "finished", it is a boolean. If game finished true else false.
 * -----------------------
 * Non-relevant variables: "$i", "$search", "$replace","$text (tr_strtoupper and tr_strtolower)"
 * -----------------------
 * Variables:
 * Variable "$x", it is a array of file path's elemenets.
 * Variable "$indexes", it is a array of default indexses' name. You can change it.
 * Variable "$word", chosen random word, it only works once every new game.
 * Variable "$hint", chosen random word's hint, it only works once every new game.
 * Variable "$wordlist", wordlist json data.
 * Variable "$word_count", wordlist lenght.
 * Variable "$random", random number for chosing random word.
 * Variable "$main", canvas HTML code.
 * Variable "$text", word with HTML code.
 * Variable "$alphabet", alphabet in array.
 * |-> "$letter" is $alphabet's specify element.
 * Variable "$wrong_check", it is a boolean, it is check variable. It prevents if letter is wrong, wrongs increases by 2.
 * Variable "$checks", it is about with if letter is wrong. If letter is available it is reducing.
 * Variable "$pressed", get data from posted page. It is button's letter data.
 * Variable "$guessed", get data from guess input.
 * Variable "$onload", onload scripts text.
 * Variable "$loadables_6", onloadable script list for max 6 wrongs.
 * Variable "$loadables_7", onloadable script list for max 7 wrongs.
 * Variable "$loadables_8", onloadable script list for max 8 wrongs.
 * Variable "$wrongs", wrong count.
 * -----------------------
 * Functions:
 * setFoderName(), sets folder name of script location. It prevents locating user to index.php,
 * if name is not index.php it makes the path to file name.
 * checkSessions(), checks the sessions. If there is a session named word and word-given, it does nothing else it gives
 * new word, hint etc.
 * getStatus(), it checks if game finished. It returns you win or you lose texts.
 * getHint(), it returns hint.
 * getMan(), it draws man according to wrongs.
 * getWord(), it writes the displaying word.
 * getButtons(), it is writing every button. If you change buttons, you can change $alphabet variable.
 * getGuess(), it places a input for guess entering.
 * tr_strtoupper() and tr_strtolower(), it fixes Turkish chracters when strupping or strlowing. It is not only for Turkish if you add
 * your language's speacial letters.
 *
 */
session_start();
header('Content-Type: text/html; charset=iso-8859-9');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// You can change to, "6, 7 or 8". Default: 7
define("MAX_WRONGS", 7);

// Set folder or file name for location path.
function setFolderName()
{
    $x = explode("/", str_replace("\\", "/", __FILE__));
    $indexes = array(
        "index.php",
        "default.php",
        "main.php"
    );
    if (in_array($x[count($x) - 1], $indexes)) {
        define("FOLDER_NAME", $x[count($x) - 2]);
    } else {
        define("FOLDER_NAME", $x[count($x) - 2] . "/" . $x[count($x) - 1]);
    }
}
setFolderName();

function tr_strtoupper($text)
{
    $search = array(
        "ç",
        "i",
        "ı",
        "ğ",
        "ö",
        "ş",
        "ü"
    );
    $replace = array(
        "Ç",
        "İ",
        "I",
        "Ğ",
        "Ö",
        "Ş",
        "Ü"
    );
    $text = str_replace($search, $replace, $text);
    $text = strtoupper($text);
    return $text;
}

function tr_strtolower($text)
{
    $replace = array(
        "ç",
        "i",
        "ı",
        "ğ",
        "ö",
        "ş",
        "ü"
    );
    $search = array(
        "Ç",
        "İ",
        "I",
        "Ğ",
        "Ö",
        "Ş",
        "Ü"
    );
    $text = str_replace($search, $replace, $text);
    $text = strtolower($text);
    return $text;
}

// CHECK IF USER STARTED A GAME
function checkSessions()
{
    if ($_SESSION["word-given"] == true && isset($_SESSION["word"]) == true) {
        // nothing
    } else {
        $wordlist = json_decode(file_get_contents("WorldList_HM.json"), true);
        $word_count = count($wordlist["WordList"]);
        $random = rand(0, $word_count - 1);
        $word = $wordlist["WordList"][$random]["Word"];
        $hint = $wordlist["WordList"][$random]["Hint"];
        $_SESSION["word"] = $word;
        $_SESSION["hint"] = $hint;
        $_SESSION["word-given"] = true;
        $_SESSION["finished"] = false;
        $_SESSION["word-lenght"] = strlen($word);
        $_SESSION["wrongs"] = 0;
        $_SESSION["confirms"] = 0;
        $_SESSION["expected-confirms"] = strlen($word) - substr_count($word, " "); // Word len - Spaces count
        for ($i = 0; $i < strlen($word); $i ++) {
            if ($word[$i] == " ") {
                $_SESSION["letter_" . $i] = "-";
                $_SESSION["displayletter_" . $i] = "-";
            } else {
                $_SESSION["letter_" . $i] = $word[$i];
                $_SESSION["displayletter_" . $i] = "_";
            }
        }
        header("location: ../" . FOLDER_NAME);
    }
}

// Checks if user finished/failed.
function getStatus()
{
    if ($_SESSION["wrongs"] == MAX_WRONGS) {
        echo '
    <div id="info">
        <div class="text">
            <h1><font color="red">ADAM ÖLDÜ!</font></h1>
            <p>Cevap şuydu: ' . $_SESSION["word"] . '</p>
			<button class="info-button" onclick="location.href = \'?p=new\';">Yeni Oyun</button>
		</div>
	</div>
';
        $_SESSION["finished"] = true;
    }
    if ($_SESSION["confirms"] == $_SESSION["expected-confirms"]) {
        echo '
	<div id="info">
		<div class="text">
			<h1><font color="green">ADAM KURTULDU!</font></h1>
            <p>(' . $_SESSION["word"] . ')</p>
			<button class="info-button" onclick="location.href = \'?p=new\';">Yeni Oyun</button>
		</div>
	</div>
';
        $_SESSION["finished"] = true;
    }
}

// Writes hint.
function getHint()
{
    echo "<span class='hint-title'>İpucu:</span> <span class='hint'>" . $_SESSION["hint"] . "</span>";
}

// Drawing man parts.
function getMan()
{
    $wrongs = $_SESSION["wrongs"];
    $onload = "platform();"; // Default onload script: platform();
    $loadables_6 = array(
        "head(); leftEye(); rightEye();",
        "body();",
        "leftArm();",
        "rightArm();",
        "leftLeg();",
        "rightLeg();"
    );
    $loadables_7 = array(
        "head();",
        "leftEye(); rightEye();",
        "body();",
        "leftArm();",
        "rightArm();",
        "leftLeg();",
        "rightLeg();"
    );
    $loadables_8 = array(
        "head();",
        "leftEye();",
        "rightEye();",
        "body();",
        "leftArm();",
        "rightArm();",
        "leftLeg();",
        "rightLeg();"
    );
    $loadables = MAX_WRONGS == 6 ? $loadables_6 : MAX_WRONGS == 7 ? $loadables_7 : $loadables_8;
    for ($i = 0; $i < $wrongs; $i ++) {
        if ($wrongs != 0) {
            $onload = $onload . " " . $loadables[$i];
        }
    }
    if ($_SESSION["onload-scripts"] != $onload) {
        header("location: ../" . FOLDER_NAME);
    }
    $_SESSION["onload-scripts"] = $onload;
    echo "<br>";
    $main = '<canvas width="250px" height="250px" id="man"></canvas>';
    echo $main;
}

// Get the word.
function getWord()
{
    echo "<br>";
    for ($i = 0; $i < $_SESSION["word-lenght"]; $i ++) {
        $text = $text . $_SESSION["displayletter_" . $i] . " ";
    }
    echo "<span class='word'>$text</span>";
}

// Get letter buttons.
function getButtons()
{
    echo "<br>";
    echo "<form method='post' action='?p=enter'>";
    $alphabet = array(
        'A',
        'B',
        'C',
        'Ç',
        'D',
        'E',
        'F',
        'G',
        'Ğ',
        'H',
        'I',
        'İ',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'Ö',
        'P',
        'R',
        'S',
        'Ş',
        'T',
        'U',
        'Ü',
        'V',
        'Y',
        'Z'
    );
    $i = 0;
    foreach ($alphabet as $letter) {
        $i = $i + 1;
        if ($i == 10 || $i == 20) {
            echo "<br>";
        }
        if ($_SESSION["finished"] == true) {
            $addon = " onclick='return false;'";
        }
        echo "<button type='submit' name='letter' value='$letter'$addon>$letter</button>";
    }
    echo "</form>";
}

// Get guess input.
function getGuess()
{
    echo "<br>";
    echo "<form method='post' action='?p=guess'>";
    echo '<input name="guess" class="input-guess" autocomplete="off" placeholder="Tahmininiz" onchange="this.form.submit()"></input>';
    echo "</form>";
}
?>
<html>
<head>
<title>AdamAsmaca - EmreCebeci</title>
<meta name="author" content="Emre Cebeci" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="default.css" />
<script src="hangman.js"></script>
</head>
<body onload="<?php echo $_SESSION["onload-scripts"]; ?>">
	<div id="header">
		<h1 class="title">Adam Asmaca</h1>
		<span>» by Emre Cebeci</span>
	</div>
	<div class="clear"></div>
	<div id="content">
<?php
switch ($_GET["p"]) {
    default:
        checkSessions();
        getStatus();
        getHint();
        getMan();
        getWord();
        getButtons();
        getGuess();
        break;
    case "enter":
        $pressed = $_POST["letter"];
        $checks = $_SESSION["word-lenght"]; // This is for, if user pressed wrong letter.
        $wrong_check = false;
        // Check every letter.
        for ($i = 0; $i < $_SESSION["word-lenght"]; $i ++) {
            if (tr_strtolower($_SESSION["displayletter_" . $i]) != tr_strtolower($pressed)) {
                // If displayletter_$i not equals to pressed letter, check word else wrong.
                if (tr_strtolower($pressed) == tr_strtolower($_SESSION["word"][$i])) {
                    // If letter found, make displayletter_$i, letter_$i and increase confirms by 1, reduce checks by 1.
                    $_SESSION["displayletter_" . $i] = tr_strtoupper($_SESSION["letter_" . $i]);
                    $_SESSION["confirms"] += 1;
                    $checks -= 1;
                }
            } else {
                $wrong_check = true;
            }
        }
        // Increase wrongs by 1 if wrong_check is true else increase by 0.
        $_SESSION["wrongs"] += $wrong_check == true ? 1 : 0;
        if ($checks == $_SESSION["word-lenght"] && $wrong_check == false) {
            // If checks equals to word lenght and wrong check is false, it means wrong letter!
            // wrong_check == false is important beacause it prevents double increasing of wrongs.
            $_SESSION["wrongs"] += 1;
        }
        header("location: ../" . FOLDER_NAME);
        break;
    case "guess":
        $guessed = $_POST["guess"];
        if (tr_strtolower($guessed) == tr_strtolower($_SESSION["word"])) {
            $_SESSION["confirms"] = $_SESSION["expected-confirms"];
        } else {
            $_SESSION["wrongs"] += 1;
        }
        header("location: ../" . FOLDER_NAME);
        break;
    case "new":
        $_SESSION["word-given"] = true;
        $_SESSION["word"] = null;
        header("location: ../" . FOLDER_NAME);
        break;
}
?>
</div>
	<div id="footer">
		<div class="footer-links">
			<a class="title">Destek</a>
			<ul>
				<li><a href="https://github.com/emreyigitcbc">GitHub Profili</a></li>
				<li><a href="https://github.com/emreyigitcbc/HangMan">GitHub Rep.</a></li>
			</ul>
		</div>
		<div class="copy">Yapımcı: Emre Cebeci, sürüm: 1.3</div>
	</div>
</body>
</html>