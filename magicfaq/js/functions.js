(function($){ 
    "use strict";

    console.log('hello');

    var question = "";
    var dubsAnswersContainer = $('#dubs-answers-container');

    var updateQuestion = function() {
        question = $("form.ask-dubs input[name=question]").val();
    };

    var answerClickFunction = function(e) {
        e.preventDefault();
        $(this).blur();

        var listItem = $(this).parents('li');
        var answer = listItem.find('div.ask-dubs-answer');

        if (listItem.hasClass('feedback-submitted') === false) {
            giveFeedback(listItem.data('question-id'), 1);
        }
        listItem.addClass('feedback-submitted');

        if (listItem.hasClass('closed')) {
            answer.css('max-height', '300px').
            delay(500).

            queue(function(next) {
                answer.css('max-height', '100%');
                listItem.removeClass('closed').addClass('open'); 
                next();
            });
        } else {
            answer.css('display', 'none').
                css('max-height', '0').
                delay(600).
                queue(function(next) {
                    answer.css('display', 'block');
                    next();
                });
            listItem.removeClass('open').addClass('closed');
        }
    };
    var addQuestion = function(questionText, answer, id) {
        var questionItem = $('<li class="ask-dubs closed" data-question-id="' + id + '">' +
            '<a class="ask-dubs-question" href="#">' + questionText + '</a>' +
            '<div class="ask-dubs-answer"><p>' + answer + '</p>' +
            '<div class="ask-dubs-question-feedback"><p class="helpful-q">Helpful?</p>' +
            '<p class="helpful-a"><a href="#">Yes</a> - <a href="#">Sort of</a> - <a href="#">No</a></p></div>' +
            '<hr></div></li>');

        questionItem.find('a.ask-dubs-question').click(answerClickFunction);
        questionItem.appendTo('ul.ask-dubs');

        $('div.ask-dubs-question-feedback a').click(function() {
            $(this).closest('div.ask-dubs-question-feedback').html('Thank you for your feedback!');
            return false;
        });
    }

    var askQuestion = function() {
        updateQuestion();

        var subtitleText;

        if (typeof question === 'undefined' || question === "") {
            subtitleText = "This Week's Hottest Questions:"
        } else {
            subtitleText = "Registrar Answers:"
            $('#ask-dubs-recommend').css('display', 'block');
            $('#ask-dubs-recommend-feedback').css('display', 'none');
            $('#ask-dubs-recommend input').val(question);
        }

        dubsAnswersContainer.css('opacity', 0);

        $.ajax({
            url: 'data.json',
            //url: "https://apps.doem.washington.edu/questions/ajax/handle.php",
            method: "GET",
            data: { question: question, url: window.location.href }
        }).success(function(msg) {
            $('#ask-dubs-subtitle').html(subtitleText);
            $('li.ask-dubs').remove();  
            msg = JSON.parse(msg);
            var questions = msg['questions'];

            for (var i = 0; i < questions.length; i++) {
                addQuestion(questions[i].question, questions[i].answer, questions[i].id);
            }   
            dubsAnswersContainer.css('opacity', 1);
        });
    }

    var giveFeedback = function(questionId, magnitude) {
        $.ajax({
            url: 'data.json',
            //url: "https://apps.doem.washington.edu/questions/ajax/handle.php",
            method: "POST",
            data: {
                questionId: questionId,
                question: question,
                magnitude: magnitude,
                url: window.location.href
            }
        });

    };

    $('#ask-dubs-recommend button').click(function() {

        $('#ask-dubs-recommend input').val('');
        $('#ask-dubs-recommend').css('display', 'none');
        $('#ask-dubs-recommend-feedback').css('display', 'block');
    });

    askQuestion();

})(jQuery);

