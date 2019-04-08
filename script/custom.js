$(document).ready(function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");  
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    var favorite_songs_url = sessionStorage.getItem("favorite_songs_url");            
    if(favorite_songs != undefined) {
        favorite_songs = favorite_songs.split(",");
        favorite_songs_name = favorite_songs_name.split(",");
        favorite_songs_url = favorite_songs_url.split(",");
        for(var index = 0; index < favorite_songs.length; index++) {
            $('#favorite_songs_list').append('<li attr-id="'+ favorite_songs[index] +'" audiourl="'+favorite_songs_url[index]+'">'+ favorite_songs_name[index] +'<a class="single-remove-favorite-btn" attr-id="'+favorite_songs[index]+'" attr-text="'+favorite_songs_name[index]+'"><i class="fa fa-minus" title="Remove from favorites"></i></a></li>');
            $('#favorite_songs_list_modal').append('<li attr-id="'+ favorite_songs[index] +'">'+ favorite_songs_name[index] +'</li>');
        }
    }
});
/*
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
*/

$(document).on('click', '.add-favorite-player-btn', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");        
    var favorite_songs_url = sessionStorage.getItem("favorite_songs_url");                 
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
    if(favorite_songs_url == undefined) {
        favorite_songs_url = [];
    } else {
        favorite_songs_url = favorite_songs_url.split(",");
    }
    if($.inArray($(this).attr('attr-id').toString(), favorite_songs) == -1){
        favorite_songs.push($(this).attr('attr-id'));
        favorite_songs_name.push($(this).attr('attr-text'));
        favorite_songs_url.push($(this).attr('audiourl'));
        $('#favorite_songs_list').append('<li attr-id="'+ $(this).attr('attr-id') +'" audiourl="'+$(this).attr('audiourl')+'">'+ $(this).attr('attr-text') +'<a class="single-remove-favorite-btn" attr-id="'+$(this).attr('attr-id')+'" attr-text="'+$(this).attr('attr-text')+'"><i class="fa fa-minus" title="Remove from favorites"></i></a></li>');
        $('#favorite_songs_list_modal').append('<li attr-id="'+ $(this).attr('attr-id') +'">'+ $(this).attr('attr-text') +'</li>');
        $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').addClass('fa-heart');
        $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').removeClass('fa-heart-o');
    } else {
        favorite_songs.splice($.inArray($(this).attr('attr-id'), favorite_songs),1);
        favorite_songs_name.splice($.inArray($(this).attr('attr-text'), favorite_songs_name),1);
        favorite_songs_url.splice($.inArray($(this).attr('audiourl'), favorite_songs_url),1);
        $('#favorite_songs_list li[attr-id="'+$(this).attr('attr-id')+'"]').remove();
        $('#favorite_songs_list_modal li[attr-id="'+ $(this).attr('attr-id') +'"]').remove();
        $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').addClass('fa-heart-o');
        $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').removeClass('fa-heart');
    }      

    sessionStorage.setItem("favorite_songs", favorite_songs);
    sessionStorage.setItem("favorite_songs_name", favorite_songs_name);   
    sessionStorage.setItem("favorite_songs_url", favorite_songs_url);   
});

$(document).on('click', '#songs_list li', function(){    
    $('#songs_list li').removeClass('selected');    
    $(this).addClass('selected');
});

$(document).on('click', '#favorite_songs_list li', function(){       
    $('#favorite_songs_list li').removeClass('selected');    
    $(this).addClass('selected'); 
});

$(document).on('click', '.single-add-favorite-btn', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    var favorite_songs_url = sessionStorage.getItem("favorite_songs_url");            
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
    if(favorite_songs_url == undefined) {
        favorite_songs_url = [];
    } else {
        favorite_songs_url = favorite_songs_url.split(",");
    }
    if($.inArray($(this).attr('attr-id').toString(), favorite_songs) == -1){
        favorite_songs.push($(this).attr('attr-id'));
        favorite_songs_name.push($(this).attr('attr-text'));
        favorite_songs_url.push($(this).attr('audiourl'));
        console.log($(this).attr('audiourl'));
        $('#favorite_songs_list').append('<li attr-id="'+ $(this).attr('attr-id') +'" audiourl="'+$(this).attr('audiourl')+'">'+ $(this).attr('attr-text') +'</li>');
        $('#favorite_songs_list_modal').append('<li attr-id="'+ $(this).attr('attr-id') +'">'+ $(this).attr('attr-text') +'</li>');
        $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').removeClass('fa-heart-o');
        $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').addClass('fa-heart');
    }        

    sessionStorage.setItem("favorite_songs", favorite_songs);
    sessionStorage.setItem("favorite_songs_name", favorite_songs_name);    
    sessionStorage.setItem("favorite_songs_url", favorite_songs_url);    
});
$(document).on('click', '.single-remove-favorite-btn', function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    var favorite_songs_url = sessionStorage.getItem("favorite_songs_url");            
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
    if(favorite_songs_url == undefined) {
        favorite_songs_url = [];
    } else {
        favorite_songs_url = favorite_songs_url.split(",");
    }
    if($.inArray($(this).attr('attr-id').toString(), favorite_songs) != -1){
        favorite_songs.splice($.inArray($(this).attr('attr-id'), favorite_songs),1);
        favorite_songs_name.splice($.inArray($(this).attr('attr-text'), favorite_songs_name),1);
        favorite_songs_url.splice($.inArray($(this).attr('attr-text'), favorite_songs_url),1);
        $('#favorite_songs_list li[attr-id="'+$(this).attr('attr-id')+'"]').remove();
        $('#favorite_songs_list_modal li[attr-id="'+ $(this).attr('attr-id') +'"]').remove();
        if($('.player a[attr-id="'+$(this).attr('attr-id')+'"]').length) {
            stopAudio();
            $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').addClass('fa-heart-o');
            $('.player a[attr-id="'+$(this).attr('attr-id')+'"] i').removeClass('fa-heart');
        }
    }        

    sessionStorage.setItem("favorite_songs", favorite_songs);
    sessionStorage.setItem("favorite_songs_name", favorite_songs_name);    
    sessionStorage.setItem("favorite_songs_url", favorite_songs_url);    
});
/*
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
*/
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

    if($("#submit_name").val() == '' || $("#submit_company").val() == '' || $("#submit_email").val() == '' || $("#submit_phone").val() == '' || $("#submit_message").val() == '') {
        alert("Please fill up information");
        return;        
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
    $('#submitModal').modal('hide');
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

$("#albumChangeUploadBtn").on('change', function (event) {
    if($(this).prop('files').length > 0)
    { 
        var file = $(this).prop('files')[0];
        $("#imageChangeSrc").attr("src", URL.createObjectURL($(this).prop('files')[0]));   
        
        var formdata = new FormData();
        formdata.append("file", file);
        formdata.append("category_id", $("#category_id").val());
        formdata.append("category_name", $("#category_name").val());
        formdata.append("type", 'change_album_image');
        
        var ajax = new XMLHttpRequest();     
        ajax.open("POST", "ajax.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP        
        ajax.send(formdata);     
    }
    return false;
});

var removeModalConfirm = function (callback) {
    $(".category-remove-btn").on("click", function () {
        $("#modal_category_id").val($(this).attr('attr-id'));
        $("#modal_category_name").val($(this).attr('attr-name'));
        $("#removeCategoryModal").modal('show');
    });

    $("#remove-category-btn-yes").on("click", function () {        
        callback(true);
        $("#removeCategoryModal").modal('hide');
    });
};

removeModalConfirm(function (confirm) {
    if (confirm) {
        var formdata = new FormData();
        formdata.append("category_id", $("#modal_category_id").val());
        formdata.append("category_name", $("#modal_category_name").val());
        formdata.append("type", 'remove_category');
        
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