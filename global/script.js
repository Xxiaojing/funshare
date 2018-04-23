$(document).ready(function(){
    var left = $('#leftSideBar');
    var right = $('#rightSideBar');

    left.css("width", $('#leftWidth').width());
    right.css("width", $('#rightWidth').width());

    var end = $('footer');
    var leftTop = left.offset().top,
        leftHeight = left.height(),
        rightTop = right.offset().top,
        rightHeight = right.height();
    var endTop, leftMiss, rightMiss;

    $(window).scroll(function() {
        var docTop = Math.max(document.body.scrollTop, document.documentElement.scrollTop);

        if (end.length > 0) {
            endTop = end.offset().top;
            leftMiss = endTop - docTop - leftHeight;
            rightMiss = endTop - docTop - rightHeight;
        }

        if (leftTop < docTop) {
            left.css('position', 'fixed');
            if ((end.length > 0) && (endTop < (docTop + leftHeight)) && (leftMiss > 70)) {
                left.css({top: leftMiss});
            } else{
                left.css({top: 70});
            }
        } else {
            left.css('position', 'static');
        }

        if (rightTop < docTop) {
            right.css('position', 'fixed');
            if ((end.length > 0) && (endTop < (docTop + rightHeight)) && (rightMiss > 70)) {
                right.css({top: rightMiss});
            } else{
                right.css({top: 70});
            }
        } else {
            right.css('position', 'static');
        }
    });

    $(window).resize(function() {
        $('#leftSideBar').css("width", $('#leftWidth').width());
        $('#rightSideBar').css("width", $('#rightWidth').width());
    });
});