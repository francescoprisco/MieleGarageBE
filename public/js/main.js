$( document ).ready(function() {
    "use strict";

    //Closing the alert div
    $( ".closealertbutton" ).on( "click", function() {
        $(this).parent().parent().hide(500)
    });


    //toggle top nav drop down menu
    var menuIsVisible = false;
    $( "#menu-option" ).on( "click", function() {
        if( menuIsVisible ){
            $( "#origin-top-right" ).removeClass( "block" );
            $( "#origin-top-right" ).addClass( "hidden" );
        }else{
            $( "#origin-top-right" ).removeClass( "hidden" );
            $( "#origin-top-right" ).addClass( "block" );
        }
        menuIsVisible = !menuIsVisible;
    });


    //delete item
    $( ".delete-item" ).on( "click", function() {

        var formName = $(this).data("name");
        var formTitle = $(this).data("title") ?? 'Delete';
        var formPositiveButtonText = $(this).data("positive") ?? 'Yes, delete it!';
        var formQuestion = $(this).data("question") ?? 'Are you sure you want to delete the selected';
        var formId = $(this).data("id");
        Swal.fire({
            title: formTitle,
            text: ''+formQuestion+' '+formName+'?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: formPositiveButtonText
        }).then((result) => {

            if (result.value) {
                $( "#"+formId ).submit();
            }

        });
    });

    //restore item
    $( ".restore-item" ).on( "click", function() {

        var formName = $(this).data("name");
        var formTitle = $(this).data("title") ?? 'Restore';
        var formPositiveButtonText = $(this).data("positive") ?? 'Yes, restore it!';
        var formQuestion = $(this).data("question") ?? 'Are you sure you want to restore the selected';
        var formId = $(this).data("id");
        Swal.fire({
            title: formTitle,
            text: ''+formQuestion+' '+formName+'?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: formPositiveButtonText
        }).then((result) => {

            if (result.value) {
                $( "#"+formId ).submit();
            }

        });
    });


});
