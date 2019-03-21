$(document).ready(function(){
    var favorite_songs = sessionStorage.getItem("favorite_songs");  
    var favorite_songs_name = sessionStorage.getItem("favorite_songs_name");            
    if(favorite_songs != undefined) {
        favorite_songs = favorite_songs.split(",");
        favorite_songs_name = favorite_songs_name.split(",");
        for(var index = 0; index < favorite_songs.length; index++) {
            $('#favorite_songs_list').append('<li attr-id="'+ favorite_songs[index] +'">'+ favorite_songs_name[index] +'</li>');
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
    });
    sessionStorage.setItem("favorite_songs", favorite_songs);
    sessionStorage.setItem("favorite_songs_name", favorite_songs_name);  
});