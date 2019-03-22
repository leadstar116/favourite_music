$(document).ready(function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");  
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    if(favorite_songs != undefined) {
        favorite_songs = favorite_songs.split(",");
        favorite_songs_name = favorite_songs_name.split(",");
        for(var index = 0; index < favorite_songs.length; index++) {
            $('#favorite_songs_list').append('<li attr-id="'+ favorite_songs[index] +'">'+ favorite_songs_name[index] +'</li>');
            $('#favorite_songs_list_modal').append('<li attr-id="'+ favorite_songs[index] +'">'+ favorite_songs_name[index] +'</li>');
        }
    }
});

$(document).on('click', '#add-favorite-btn', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    if(favorite_songs == undefined) {
        favorite_songs = [];
    } else {
        favorite_songs = favorite_songs.split(",");
    }
    if(favorite_songs_name == undefined) {
        favorite_songs_name = [];
    } else {
        favorite_songs_name = favorite_songs_name.split(",");
    }
    $('#songs_list li.selected').each(function(){
        if($.inArray($(this).attr('attr-id').toString(), favorite_songs) == -1){
            favorite_songs.push($(this).attr('attr-id'));
            favorite_songs_name.push($(this).text());
            $('#favorite_songs_list').append('<li attr-id="'+ $(this).attr('attr-id') +'">'+ $(this).text() +'</li>');
            $('#favorite_songs_list_modal').append('<li attr-id="'+ $(this).attr('attr-id') +'">'+ $(this).text() +'</li>');
        }        
    });
    sessionStorage.setItem("favorite_songs", favorite_songs);
    sessionStorage.setItem("favorite_songs_name", favorite_songs_name);        
});

$(document).on('click', '#songs_list li', function(){    
    if($(this).hasClass('selected')) {
        $(this).removeClass('selected');
    } else {
        $(this).addClass('selected');
    }
});

$(document).on('click', '#favorite_songs_list li', function(){    
    if($(this).hasClass('selected')) {
        $(this).removeClass('selected');
    } else {
        $(this).addClass('selected');
    }
});

$(document).on('click', '#remove-favorite-btn', function(){    
    $('#removeModal').modal('show');  
});

$(document).on('click', '#modal-btn-yes', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    if(favorite_songs == undefined) {
        favorite_songs = [];
    } else {
        favorite_songs = favorite_songs.split(",");
    }
    if(favorite_songs_name == undefined) {
        favorite_songs_name = [];
    } else {
        favorite_songs_name = favorite_songs_name.split(",");
    }
    $('#favorite_songs_list li.selected').each(function(){
        favorite_songs.splice($.inArray($(this).attr('attr-id'), favorite_songs),1);
        favorite_songs_name.splice($.inArray($(this).text(), favorite_songs_name),1);
        $(this).remove();
        $('#favorite_songs_list_modal li[attr-id="'+ $(this).attr('attr-id') +'"]').remove();
    });
    sessionStorage.setItem("favorite_songs", favorite_songs);
    sessionStorage.setItem("favorite_songs_name", favorite_songs_name);  
});

$(document).on('click', '#submit-mail-btn', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    if(favorite_songs == undefined) {
        alert("Favorite list is empty");
    } else {
        $("#submitModal").modal("show");
    }
});

$(document).on('click', '#modal-btn-submit', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    if(favorite_songs == undefined) {
        favorite_songs = '';
    } 
    if(favorite_songs_name == undefined) {
        favorite_songs_name = '';
    } 

    var formdata = new FormData();
    formdata.append("name", $("#submit_name").val());
    formdata.append("company", $("#submit_company").val());
    formdata.append("email", $("#submit_email").val());
    formdata.append("phone", $("#submit_phone").val());
    formdata.append("message", $("#submit_message").val());
    formdata.append("favorite_songs_id", favorite_songs);
    formdata.append("favorite_songs_name", favorite_songs_name);
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: formdata,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                alert("Successfully sent");        
            }
            else
            {
                // Handle errors here
                alert('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            alert('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
});

$(document).on('click', 'add-new-song-btn', function(){
    
});