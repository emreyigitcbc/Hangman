# PHP Hangman Game

Simple, PHP, HTML, JS hangman game.

## Using

Download one of `TR`or `EN` version and move files to your www folder.

Before you start using, you may change some settings in `index.php` 

You can change max wrong count to 6, 7 or 8.
`Default is: 7`

```php
define("MAX_WRONGS", 7);
```
That was all you could change, everything is auto just add this to your website and let people have fun!

Also you may want to change page title, author etc.

## Adding and removing new words
It is very easy, just open WordList_HM.json and write something like that to end of "WordList" list:
```json
		{
			"Word": "word",
			"Hint": "hiny"
		},
```
To remove a word simply delete that.
## Information About Code (For Devs)

#### Sessions:
Session "word-given", if user has a word this session is true else false.

Session "word", if user has a word this session is that word else null.

Session "word-lenght", word's letter count.

Session "hint", if user has a hint this session is that hint for specify word else null.

Session "wrongs", user's wrong letter count.

Session "confirms", user's confirmed letter count.

Session "expected-confirms", expecting confirmed letter count.

Session "displayletter_$i", chosen word's displaying letter $i.

Session "letter_$i", chosen word's letter $i.

Session "onload-scripts", body onload's value.

Session "finished", it is a boolean. If game finished true else false.

#### Non-relevant variables:
"$i", "$search", "$replace","$text (tr_strtoupper and tr_strtolower)"

#### Variables:
Variable "$x", it is a array of file path's elemenets.

Variable "$indexes", it is a array of default indexses' name. You can change it.

Variable "$word", chosen random word, it only works once every new game.

Variable "$hint", chosen random word's hint, it only works once every new game.

Variable "$wordlist", wordlist json data.

Variable "$word_count", wordlist lenght.

Variable "$random", random number for chosing random word.

Variable "$main", canvas HTML code.

Variable "$text", word with HTML code.

Variable "$alphabet", alphabet in array.

|-> "$letter" is $alphabet's specify element.

Variable "$wrong_check", it is a boolean, it is check variable.
 
It prevents if letter is wrong, wrongs increases by 2.

Variable "$checks", it is about with if letter is wrong. If letter is available it is reducing.

Variable "$pressed", get data from posted page. It is button's letter data.

Variable "$guessed", get data from guess input.

Variable "$onload", onload scripts text.

Variable "$loadables_6", onloadable script list for max 6 wrongs.

Variable "$loadables_7", onloadable script list for max 7 wrongs.

Variable "$loadables_8", onloadable script list for max 8 wrongs.

Variable "$wrongs", wrong count.


#### Functions:
setFoderName(), sets folder name of script location. It prevents locating user to index.php,
if name is not index.php it makes the path to file name.

checkSessions(), checks the sessions. If there is a session named word and word-given, it does nothing else it gives
new word, hint etc.

getStatus(), it checks if game finished. It returns you win or you lose texts.

getHint(), it returns hint.

getMan(), it draws man according to wrongs.

getWord(), it writes the displaying word.

getButtons(), it is writing every button. If you change buttons, you can change $alphabet variable.

getGuess(), it places a input for guess entering.

tr_strtoupper() and tr_strtolower(), it fixes Turkish chracters when strupping or strlowing. It is not only for Turkish if you add your language's speacial letters.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
