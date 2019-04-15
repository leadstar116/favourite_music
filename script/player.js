/**
 *
 * HTML5 Audio player with playlist
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */
//jQuery(document).ready(function() {

    // inner variables
    var song;
    var tracker = $('.tracker');
    var volume = $('.volume');
    var playlistType = '.playlist';

    function initAudio(elem, autoplay = true) {
        var url = elem.attr('audiourl');
        var title = elem.text();
        var cover = elem.attr('cover');
        var artist = elem.attr('artist');
        var favorite_songs = sessionStorage.getItem("favorite_songs");

        if(favorite_songs == undefined) {
            favorite_songs = [];
        } else {
            favorite_songs = favorite_songs.split(",");
        }
        $('.player .title').text(title);
        if($.inArray(elem.attr('attr-id').toString(), favorite_songs) == -1){
            $('.player .title').append('<a attr-id="'+elem.attr('attr-id')+'" attr-text="'+ elem.text() +'" audiourl="'+url+'" class="add-favorite-player-btn ml-1"><i class="fa fa-heart-o" style="color: #f00;"></i></a>');
        } else {
            $('.player .title').append('<a attr-id="'+elem.attr('attr-id')+'" attr-text="'+ elem.text() +'" audiourl="'+url+'" class="add-favorite-player-btn ml-1"><i class="fa fa-heart" style="color: #f00;"></i></a>');
        }
        $('.player .artist').text(artist);
        $('.player .cover').css('background-image','url("'+cover+'")');;

        song = null;
        song = new Audio(url);
        song.autoplay = autoplay;

        // timeupdate event listener        
        song.addEventListener('timeupdate',function (){
            var curtime = parseInt(song.currentTime, 10);
            tracker.slider('value', curtime);
        });

        song.addEventListener('loadedmetadata',function (){
            tracker.slider("option", "max", song.duration);
        });

        song.addEventListener('ended',function (){
            $('.play').removeClass('hidden');
            $('.pause').removeClass('visible');
        });

        $(playlistType+' li span').removeClass('active');
        elem.addClass('active');
        if(autoplay) {
            $('.play').addClass('hidden');
            $('.pause').addClass('visible');
        }
    }
    function playAudio() {
        song.play();

        tracker.slider("option", "max", song.duration);

        $('.play').addClass('hidden');
        $('.pause').addClass('visible');
    }
    function stopAudio() {
        if(song) {
            song.pause();
        }
        $('.play').removeClass('hidden');
        $('.pause').removeClass('visible');
    }

    // play click
    $(document).on('click', '.play', function (e) {
        e.preventDefault();

        playAudio();
    });

    // pause click
    $(document).on('click', '.pause', function (e) {
        e.preventDefault();

        stopAudio();
    });

    // forward click
    $(document).on('click', '.fwd', function (e) {
        e.preventDefault();

        stopAudio();

        var next = $(playlistType+' li span.active').parent().next().children('span');
        if (next.length == 0) {
            next = $(playlistType+' li:first-child span');
        }
        $(playlistType+' li span').removeClass('selected');
        next.addClass('selected');        
        initAudio(next);
    });

    // rewind click
    $(document).on('click', '.rew', function (e) {
        e.preventDefault();

        stopAudio();

        var prev = $(playlistType+' li span.active').parent().prev().children('span');
        if (prev.length == 0) {
            prev = $(playlistType+' li:last-child span');
        }
        $(playlistType+' li span').removeClass('selected');
        prev.addClass('selected');     
        initAudio(prev);
    });

    // show playlist
    $('.pl').click(function (e) {
        e.preventDefault();

        $('.playlist').fadeIn(300);
    });

    // playlist elements - click
    $(document).on('click', '.playlist li span', function () {          
        stopAudio();
        $('.favorite-playlist li span').removeClass('selected');
        $('.favorite-playlist li span').removeClass('active');
        playlistType = '.playlist';
        initAudio($(this));
    });

    $(document).on('click', '.favorite-playlist li span', function () {        
        stopAudio();
        $('.playlist li span').removeClass('selected');
        $('.playlist li span').removeClass('active');
        playlistType = '.favorite-playlist';
        initAudio($(this));
    });

    // initialization - first element in playlist
    if($('.playlist').length) {
        initAudio($('.playlist li:first-child span'), false);
        // set volume
        song.volume = 0.8;
    }

    $("#songsModal").on("hidden.bs.modal", function () {
        // put your default event here
        console.log('aaa');
        stopAudio();
        $("#submitModal").modal('hide');
    });
    $("#submitModal").on("hidden.bs.modal", function () {
        // put your default event here
        console.log('aaa');
        stopAudio();
    });
    // initialize the volume slider
    function initializeTracker(){
        tracker = $('.tracker');
        volume = $('.volume');
        volume.slider({
            range: 'min',
            min: 1,
            max: 100,
            value: 80,
            start: function(event,ui) {},
            slide: function(event, ui) {
                song.volume = ui.value / 100;
            },
            stop: function(event,ui) {},
        });

        // empty tracker slider
        tracker.slider({
            range: 'min',
            min: 0, max: 10,
            start: function(event,ui) {},
            slide: function(event, ui) {
                song.currentTime = ui.value;
            },
            stop: function(event,ui) {}
        });
    }
//});
