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

$("#uploadBtn").on('change', function (event) {
    var formdata = new FormData();
    $("div.progress").show();
    if($(this).prop('files').length > 0)
    {
        var file = $(this).prop('files')[0];
        formdata.append("file", file);
        formdata.append("category_id", $("#category_id").val());
        formdata.append("category_name", $('#category_name').val());
        formdata.append("type", 'add_new_song');
        
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.onreadystatechange = function () {
            if (this.readyState == 4) { // If the HTTP request has completed 
                if (this.status == 200) { // If the HTTP response code is 200 (e.g. successful)
                    var response = this.responseText; // Retrieve the response text    
                    alert(response);
                    location.reload();      
                };
            };
        };
        ajax.open("POST", "ajax.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP        
        ajax.send(formdata);
    }
    return false;
});

function progressHandler(event) {
    var percent = (event.loaded / event.total) * 100;
    $("#progressBar").css("width", Math.round(percent) + "%");
    $("#progressBar").html(Math.round(percent) + "%");    
}

function completeHandler(event) {
    $("#progressBar").css("width", "100%");
    $("#progressBar").html("100%");  
}

var modalConfirm = function (callback) {
    $(".song-remove-btn").on("click", function () {
        $("#song_id").val($(this).attr('attr-id'));
        $("#song_name").val($(this).attr('attr-name'));
        $("#removeModal").modal('show');
    });

    $("#remove-song-btn-yes").on("click", function () {        
        callback(true);
        $("#removeModal").modal('hide');
    });
};

modalConfirm(function (confirm) {
    if (confirm) {
        console.log('confirm');
        var formdata = new FormData();
        formdata.append("type", 'remove_song');
        formdata.append("song_id", $("#song_id").val());
        formdata.append("category_name", $('#category_name').val());
        formdata.append("song_name", $("#song_name").val());
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
                    alert("Successfully removed");        
                    location.reload();
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
    }
});    

$("#albumUploadBtn").on('change', function (event) {
    if($(this).prop('files').length > 0)
    { 
        var file = $(this).prop('files')[0];
        $("#imageSrc").attr("src", URL.createObjectURL($(this).prop('files')[0]));   
        
        var formdata = new FormData();
        formdata.append("file", file);
        formdata.append("type", 'upload_temp_image');
        
        var ajax = new XMLHttpRequest();     
        ajax.open("POST", "ajax.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP        
        ajax.send(formdata);     
    }
    return false;
});
/*
$(document).on('click', "#save-category-btn", function(){
    var formdata = new FormData();
    var category_name = $("#new-category-name").val();
    formdata.append("category_name", category_name);
    formdata.append("category_image_flag", category_image_flag);
    formdata.append("type", 'add_category');
    
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
                alert("Successfully removed");        
                location.reload();
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
*/