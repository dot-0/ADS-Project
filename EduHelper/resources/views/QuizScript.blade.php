<script type="text/javascript">

    function shuffle(array) {
      var currentIndex = array.length, temporaryValue, randomIndex;

      // While there remain elements to shuffle...
      while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
      }

      return array;
    }

    (function() {
//        var questions = [{
//            question: "What is 2*5?",
//            choices: [2, 5, 10, 15],
//            correctAnswer: 2
//        }, {
//            question: "What is 8*8?",
//            choices: [20, 30, 40, 50, 64],
//            correctAnswer: 4
//        }];
        var questions = [];
        console.log(questions);

        var qq = {!! json_encode($quiz_arr) !!};
        console.log(qq);
        for(i = 0 ; i<qq.length ; i++){
            var qn = {
                question: "",
                choices: [],
                correctAnswer: -1
            };
            qn.question = qq[i].question;
            qn.choices.push(qq[i].option1);
            qn.choices.push(qq[i].option2);
            qn.choices.push(qq[i].option3);
            qn.choices.push(qq[i].option4);
            qn.correctAnswer = qq[i].answer - 1;
            questions.push(qn);
        }
        questions = shuffle(questions);
        console.log(" ===> " , questions);

        var questionCounter = 0; //Tracks question number
        var selections = []; //Array containing user choices
        var quizDiv = $('#quizDiv'); //quizDiv div object

        // Display initial question
        displayNext();

        // Click handler for the 'next' button
        $('#quizNextButton').on('click', function(e) {
            e.preventDefault();

            // Suspend click listener during fade animation
            if (quizDiv.is(':animated')) {
                return false;
            }
            choose();

            // If no user selection, progress is stopped
            if (isNaN(selections[questionCounter])) {
                alert('Please make a selection!');
            } else {
                questionCounter++;
                displayNext();
            }
        });

        // Click handler for the 'prev' button
        $('#quizPrevButton').on('click', function(e) {
            e.preventDefault();

            if (quizDiv.is(':animated')) {
                return false;
            }
            choose();
            questionCounter--;
            displayNext();
        });

        // Click handler for the 'startOver Over' button
        $('#startOver').on('click', function(e) {
            e.preventDefault();

            if (quizDiv.is(':animated')) {
                return false;
            }
            questionCounter = 0;
            selections = [];
            displayNext();
            $('#startOver').hide();
            $('#quizDone').hide();
            $('#quizSol').hide();
        });

        // Animates buttons on hover
        $('.button').on('mouseenter', function() {
            $(this).addClass('active');
        });
        $('.button').on('mouseleave', function() {
            $(this).removeClass('active');
        });

        // Creates and returns the div that contains the questions and 
        // the answer selections
        function createQuestionElement(index) {
            var qElement = $('<div>', {
                id: 'question'
            });

            var header = $('<h2>Question ' + (index + 1) + '</h2>');
            qElement.append(header);

            var question = $('<p>').append(questions[index].question);
            qElement.append(question);

            var radioButtons = createRadios(index);
            qElement.append(radioButtons);

            return qElement;
        }

        // Creates a list of the answer choices as radio inputs
        function createRadios(index) {
            var radioList = $('<div class="ajaira"><ul>');
            var item;
            var input = '';
            for (var i = 0; i < questions[index].choices.length; i++) {
                item = $('<li>');
                input = '<input type="radio" style="color:black;" name="answer" value=' + i + ' />';
                input += '&nbsp &nbsp';
                input += questions[index].choices[i];
                item.append(input);
                radioList.append(item);
            }
            return radioList;
        }

        // Reads the user selection and pushes the value to an array
        function choose() {
            selections[questionCounter] = +$('input[name="answer"]:checked').val();
        }

        // Displays next requested element
        function displayNext() {
            quizDiv.fadeOut(function() {
                $('#question').remove();

                if (questionCounter < questions.length) {
                    var nextQuestion = createQuestionElement(questionCounter);
                    quizDiv.append(nextQuestion).fadeIn();
                    if (!(isNaN(selections[questionCounter]))) {
                        $('input[value=' + selections[questionCounter] + ']').prop('checked', true);
                    }

                    // Controls display of 'prev' button
                    if (questionCounter === 1) {
                        $('#quizPrevButton').show();
                    } else if (questionCounter === 0) {

                        $('#quizPrevButton').hide();
                        $('#quizNextButton').show();
                    }
                } else {
                    var scoreElem = displayScore();
                    quizDiv.append(scoreElem).fadeIn();
                    $('#quizNextButton').hide();
                    $('#quizPrevButton').hide();
                    $('#startOver').show();
                    $('#quizDone').show();
                    $('#quizSol').show();
                }
            });
        }

        // Computes score and returns a paragraph element to be displayed
        function displayScore() {
            var score = $('<p>', {
                id: 'question'
            });

            var numCorrect = 0;
            for (var i = 0; i < selections.length; i++) {
                if (selections[i] === questions[i].correctAnswer) {
                    numCorrect++;
                }
            }

            score.append('You got ' + numCorrect + ' questions out of ' +
                questions.length + ' right!!!');
            return score;
        }
    })();   

</script>


<style type="text/css">
    .quizDiv li {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .quizDiv h2 {
        font-size: 25px;
    }

    .quizDiv p{
        font-size: 20px;
        font-family:  "Comic Sans MS", cursive, sans-serif;
        font-weight: 600;
        color: #1b791b;
    }

    .quiz_button{

    }
    .quiz_button a{
        font-size: 20px;
        color: black;
    }

    #quizPrevButton {
        display:none;
    }

    #startOver {
        display:none;
    }

    #quizDone{
        display: none;
    }

     #quizSol{
        display: none;
    }

    .ajaira{
        margin-left: 50px;
    }

    .ajaira li{
    }

    .ajaira p{
        display: inline;
        color: black;
    }

</style>
