$(document).ready(function() {
    function createCommentForm(parentId) {
        var $form = $('<form>').attr({id: 'answer-comment', action: window.location.href, method: 'POST'});


        $form.append($('<input>').attr({type: 'hidden', name: '_csrf', value: $('meta[name=csrf-token]').attr('content')}));

        $form.append($('<input>').attr({type: 'hidden', name: 'parentId', value: parentId}));

        $messageContainer = $('<div>').addClass('form-group field-answer-comment-message');
        $messageContainer.append($('<textarea>').attr({id: 'answer-comment-message', maxlength: 255, rows: 4, name: 'Comment[message]'}).addClass('form-control'));
        $messageContainer.append($('<p>').addClass('help-block help-block-error'));
        $form.append($messageContainer);

        $form.append($('<div>').addClass('form-group').append($('<input>').attr({type: 'submit', value: 'Отправить'}).addClass('btn btn-info btn-xs')));


        $form.yiiActiveForm([{
            "id":"answer-comment-message",
            "name":"message",
            "container":".field-answer-comment-message",
            "input":"#answer-comment-message",
            "error":".help-block.help-block-error",
            "validate":function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {"message":"Необходимо заполнить «Сообщение»."});
                yii.validation.trim($form, attribute, []);
                yii.validation.string(value, messages, {"message":"Значение «Сообщение» должно быть строкой.","max":255,"tooLong":"Значение «Сообщение» должно содержать максимум 255 символов.","skipOnEmpty":1});
            }
        }], []);

        return $form;
    }

   $('.note-comment').on('click', function() {
       $('#answer-comment').remove();
       $(this).closest('.panel').after(createCommentForm($(this).data('id')));

       return false;
   });
});
