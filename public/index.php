<?php  

  // APPLICATION DATA 
  require 'auth.php';
  require 'auth_secret.php';
  require 'api/functions.php';

  session_start([
     'cookie_lifetime' => 3600,
     'read_and_close'  => false,
  ]);
  
  if (isset($_SESSION["access_token"])) {
    // TOKEN EXISTS
    $token = $_SESSION["access_token"];
  } else {
    // get new token
    // $auth_data = array(
    //   'refresh_token'=> $refresh_token,
    //   'client_secret'=>$client_secret,
    //   'client_id'=>$client_id
    // );
    // get_new_access_token( $auth_data );
    $token = "";
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ma.ttHarr.is | Open Playlist</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" conten="Open Playlist - Add songs for me to listen to">
  <meta property="og:title" content="Open Playlist" />
  <meta property="og:description" content="Completly Open, Always on, Open Playlist. Add songs for me to listen to while we bring in the New Year." />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="http://www.ma.ttharr.is/open-playlist" />
  <meta property="og:image" content="http://www.ma.ttharr.is/open-playlist/assets/high-volume.png" />
  <meta property="fb:app_id" content="713958795473441" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
  <link rel="stylesheet" href="/open-playlist/lib/cached.css" > 
  <link rel="stylesheet" href="/open-playlist/styles.css" >
  <link rel="stylesheet" href="/open-playlist/open-playlist.css" >
  <script src="/open-playlist/lib/jquery.min.js"></script>
  <script src="/open-playlist/lib/handlebars.js"></script>
  <script src="/open-playlist/scripts/open-playlist.js"></script>
</head>
<body>

<?php include 'scripts/templates.php'; ?>

<section>
    <h1>Open Playlist <span class="small">Open, Always on, Social Playlist. Add songs for me to listen to.</span></h1>
    <div class="social">
      <div class="spot_profile_widget detail ">
        <a href="https://open.spotify.com/user/mjharris2407" target="_blank">
          <div class="img" style="background-image:url('/open-playlist/assets/mattharris_profile.jpg')"></div>
        </a>
        <div class="bd">
          <h1>
            <a href="https://open.spotify.com/user/mjharris2407" target="_blank">Matt Harris</a>
          </h1>
          <button title="Follow on Spotify">
            <span class="bt-icon"></span>
            <span class="bt-text">Follow</span>
          </button>
          <div class="count" data-followers="19">
            <div class="count-num front">19</div>
            <div class="count-num back">+1</div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- <a href="https://twitter.com/intent/tweet?screen_name=open_playlist&ref_src=twsrc%5Etfw" class="twitter-mention-button" data-text="Hey, I just added this song!" data-related="open_playlist" data-dnt="true" data-show-count="false">Tweet to @open_playlist</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
</section>

<section class="search">
    <h2>Search for a track</h2>
    <form id="search-form" class="flex-row">
        <input type="text" id="query" value="" class="search_form__input" placeholder="Search an Artist, Album, or Track Name"/>
        <input type="submit" id="search" class="search_form__submit" value="Search" />
    </form>
    <div id="track-results"></div>
    <div id="album-results"></div>
    <div id="artist-results"></div>
    <div id="other-results"></div>
</div>
<!-- EMBEDDED IFRAME WIDGET  -->
<section class="playlist-container flex-row">
  <div class="live-playlist" style="padding-right: 2em;">
    <h3>Listen Now</h3>
    <iframe src="https://open.spotify.com/embed/user/mjharris2407/playlist/5J5woWIVKETFIugsyxexZI" width="300" height="380" frameborder="0" allowtransparency="true"></iframe>
  </div>
  <div id="playlist-data"></div>
</div>
<script>
var playlist_placeholder = document.getElementById('playlist-data'),
  playlist_template_html = document.getElementById('playlist-template').innerHTML,
  playlist_template = Handlebars.compile(playlist_template_html);

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


const open_playlist_id = "<?php echo $open_playlist_id; ?>";
const open_playlist_userid = "<?php echo $open_playlist_userid; ?>";

var token = "<?php echo $token ?>";

document.getElementById('search-form').addEventListener('submit', function (e) {
    e.preventDefault();
    search_spotify(document.getElementById('query').value, token);
}, false);

$(document).ready(function(){
  if (!token){
    console.log('token is unset, get a new one');
    token = get_new_access_token();
  } else {
    get_playlist_data({
      user_id: open_playlist_userid,
      playlist_id: open_playlist_id
    }, token );
  }
});

</script>
</body>
</html>
