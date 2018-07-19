<link rel="stylesheet" href="https://developer.spotify.com/web-api/static/css/cached.css" >
<link rel="stylesheet" href="/styles.css" >
<script src="/lib/jquery.min.js"></script>
<script src="/lib/handlebars.js"></script>
<script src="/scripts/open-playlist.js"></script>

<?php include 'scripts/templates.php'; ?>


<div class="container">
    <h1>Search for a track</h1>
    <form id="search-form">
        <input type="text" id="query" value="" class="form-control" placeholder="Type an Artist Name"/>
        <input type="submit" id="search" class="btn btn-primary" value="Search" />
    </form>
    <div id="track-results"></div>
    <div id="artist-results"></div>
    <div id="album-results"></div>
    <div id="other-results"></div>
</div>


<script>
var token = 'BQBD4gYtloXTkUbusSXONO7QmS6NItEgn7WKlfn6nUo1dW6cmn-RRJ8qiGV1TH_sExiMBw1gMOUAjco3SkFN53YPkqp8tfx603HniGbm8c6NmqO_dnpR00XpRo1wA3gOnrQg0d9crf17IvuFL-5-rAkdwGfdwhkUs5JEoLUVZcOsJ6i07M-yeLkraiiAviVpeGc';

// find template and compile it
var artistResultsPlaceholder = document.getElementById('artist-results'),
  artistTemplateSource = document.getElementById('artist-results-template').innerHTML,
  artistTemplate = Handlebars.compile(artistTemplateSource);

var albumsResultsPlaceholder = document.getElementById('album-results'),
  albumTemplateSource = document.getElementById('album-results-template').innerHTML,
  albumTemplate = Handlebars.compile(albumTemplateSource);
  
var tracksResultsPlaceholder = document.getElementById('track-results'),
  trackTemplateSource = document.getElementById('track-results-template').innerHTML,
  trackTemplate = Handlebars.compile(trackTemplateSource);
  
var album_tracks_placeholder = document.getElementById('other-results'),
  album_tracks_template_source = document.getElementById('album-tracks-template').innerHTML,
  album_tracks_template = Handlebars.compile(album_tracks_template_source);


document.getElementById('search-form').addEventListener('submit', function (e) {
    e.preventDefault();
    search_spotify(document.getElementById('query').value, token);
}, false);
</script>
